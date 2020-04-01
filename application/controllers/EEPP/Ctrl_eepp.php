<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_eepp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
        $this->api_maestra = API_MAESTRA;
        $this->api_sacpv = API_SACPV;
    }
    public function eepp_supervisor() {
        //*****API CONTRATISTAS*****
        $data = [];
        $url = $this->api_maestra . 'usuario_perfil/19';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratistas'] = $datos->datos;

        $this->template->set('titulo', 'EEPP Supervisor'); 
        $menu = menu(6, 60);
        $this->template->set('menu', $menu);
        $this->template->load_template1('EEPP/eepp_supervisor_view', $informacion);
    }
    public function buscar_proyectos() {
        //RECIBIR DATOS
        $contratista = $this->input->post("contratista");
        $fecha_inicio = $this->input->post("fecha_inicio");
        $fecha_corte = $this->input->post("fecha_corte");
        //*****API EEPP*****
        $data = [];
        $url = $this->api_sacpv . "estados_pago/1/21/$fecha_inicio/$fecha_corte/$contratista/I59";
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        // var_dump($datos);
        $datos = json_decode($datos);
        $informacion['proyectos'] = $datos->datos;
        //VALIDAR LA RESPUESTA, SI TRAE DATOS, MOSTRARLOS, SINO LANZAR UN ERROR
        if (empty($informacion['proyectos']) or is_null($informacion['proyectos'])) {
            echo "error";
        }
        else {
            $datos_tabla = "";
            $ultimo_proyecto = "";
            foreach ($informacion['proyectos'] as $pro) {
                if ($ultimo_proyecto == $pro->proyecto) {
                    # code...
                }
                else {
                    $datos_tabla .= "
                    <tr>
                    <td><b>$pro->proyecto_nombre</b></td>
                    <td style='text-align: center; width: 30%'><button class='btn btn-primary' onclick='ver_eepp($contratista,\"$fecha_inicio\",\"$fecha_corte\",\"$pro->proyecto\",\"$pro->proyecto_nombre\");'>VERIFICAR</button></td>
                 </tr>";
                 }
                 $ultimo_proyecto = $pro->proyecto;
            }
            $tabla ='<table id="" class="table  table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="thead-dark">
                  <tr>
                    <th style="text-align: center; width: 70%">PROYECTO</th>
                    <th style="text-align: center; width: 30%">VERIFICAR TRABAJOS</th>
                  </tr>
                </thead>
                <tbody>'.
                    $datos_tabla
                .'</tbody>
            </table>';
            echo $tabla;
        }
    }
    public function buscar_eepp() {
        //RECIBIR DATOS
        $contratista = $this->input->post("contratista");
        $fecha_inicio = $this->input->post("fecha_inicio");
        $fecha_corte = $this->input->post("fecha_corte");
        $cod_proyecto = $this->input->post("proyecto");
        $nombre_proyecto = $this->input->post("nombre_proyecto");
        $informacion['contratista'] = $contratista;
        $informacion['fecha_inicio'] = $fecha_inicio;
        $informacion['fecha_corte'] = $fecha_corte;
        $informacion['cod_proyecto'] = $cod_proyecto;
        $informacion['nombre_proyecto'] = $nombre_proyecto;
        //*****API EEPP*****
        $data = [];
        $url = $this->api_sacpv . "estados_pago/2/21/$fecha_inicio/$fecha_corte/$contratista/$cod_proyecto";
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion["eepp"] = $datos->datos;
        $this->load->view("EEPP/modal_eepp_supervisor", $informacion);
    }
    public function actualizar_material() {
        $id_materiales = $this->input->post("id_materiales");
        $precio = $this->input->post("precio");
        $cantidad = $this->input->post("cantidad");
        $datos_suceso = array(
            'id_suceso_partida' => "",
            'cod_recurso' => "",
            'recurso_detalle' => "",
            'cantidad' => $cantidad,
            'comprado_por' => "",
            'estado' => "",
            'precio' => $precio
        );
        $data= $datos_suceso;
        $url = $this->api_sacpv . 'suceso_materiales/'.$id_materiales;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo "ok";
    }
    public function actualizar_partidas () {
        $id_partida = $this->input->post("id_partida");
        $precio = $this->input->post("adicional");
        $cantidad = $this->input->post("cantidad");
        $comentario = $this->input->post("comentario");
        $datos_partida = array(
                    'unidad_medida' => $cantidad,
                    'fecha_inicio' => "",
                    'fecha_termino' => "",
                    'dias_trabajo' => "",
                    'id_contratista' => "",
                    'partidas' => "",
                    'estado' => "",
                    'solicitud_suceso' => "",
                    'precio_adicional' => $precio,
                    'justificacion' => $comentario
        );
        $data= $datos_partida;
        $url = $this->api_sacpv . 'suceso_partidas/'.$id_partida;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo "ok";
    }
    public function vb_eepp_supervisor() {
        $contratista = $this->input->post("contratista");
        $fecha_inicio = $this->input->post("fecha_inicio");
        $fecha_corte = $this->input->post("fecha_corte");
        $cod_proyecto = $this->input->post("cod_proyecto");
        //*****API EEPP*****
        $data = [];
        $url = $this->api_sacpv . "estados_pago/2/21/$fecha_inicio/$fecha_corte/$contratista/$cod_proyecto";
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion["eepp"] = $datos->datos;
        if (is_null($informacion["eepp"]) or empty($informacion["eepp"])) {
            echo "error";
        }
        else {
            foreach ($informacion["eepp"] as $eepp) {
                $id_suceso_partidas = $eepp->id_suceso_partidas;
                //ACTUALIZAR LOS ESTADOS DE LAS PARTIDAS A 22 -> VB SUPERVISOR
                $datos_partida = array(
                    'unidad_medida' => "",
                    'fecha_inicio' => "",
                    'fecha_termino' => "",
                    'dias_trabajo' => "",
                    'id_contratista' => "",
                    'partidas' => "",
                    'estado' => 22,
                    'solicitud_suceso' => "",
                    'precio_adicional' => "",
                    'justificacion' => ""
                );
                $data= $datos_partida;
                $url = $this->api_sacpv . 'suceso_partidas/'.$id_suceso_partidas;
                $metodo = 'PUT';
                $datos = setCurl($url, $metodo, $data);
            }
            echo "ok";
        }
    }
    public function pdf_eepp_supervisor() {
        $contratista = $this->input->post("contratista_eepp");
        $data = [];
        $url = $this->api_maestra . "usuarios/$contratista";
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratista'] = $datos->datos;
        $nombre_contratista = $informacion['contratista']->usuarioNombre;
        $rut_contratista = $informacion['contratista']->usuarioRut;

        $fecha_inicio = $this->input->post("fecha_inicio_eepp");
        $fecha_corte = $this->input->post("fecha_corte_eepp");
        $cod_proyecto = $this->input->post("cod_proyecto_eepp");
        $nombre_proyecto = $this->input->post("nombre_proyecto_eepp");
        //INPUTS
        $contacto = $this->input->post("contacto");
        $encargado = $this->input->post("encargado");
        $n_pago = $this->input->post("n_pago");
        $fecha_pago = $this->input->post("fecha_pago");
        $descuentos = $this->input->post("descuentos");
        $anticipo = $this->input->post("anticipo");
        $iva = $this->input->post("iva");
        if ($iva == "si") {
            $iva = "si";
        }
        else {
            $iva = "no";
        }

        $informacion['contratista'] = $contratista;
        $informacion['nombre_contratista'] = $nombre_contratista;
        $informacion['rut_contratista'] = $rut_contratista;
        $informacion['fecha_inicio'] = $fecha_inicio;
        $informacion['fecha_corte'] = $fecha_corte;
        $informacion['cod_proyecto'] = $cod_proyecto;
        $informacion['nombre_proyecto'] = $nombre_proyecto;

        $informacion['contacto'] = $contacto;
        $informacion['encargado'] = $encargado;
        $informacion['n_pago'] = $n_pago;
        $informacion['fecha_pago'] = $fecha_pago;
        $informacion['descuentos'] = $descuentos;
        $informacion['anticipo'] = $anticipo;
        $informacion['iva'] = $iva;
        // *****API EEPP*****
        $data = [];
        $url = $this->api_sacpv . "estados_pago/2/21/$fecha_inicio/$fecha_corte/$contratista/$cod_proyecto";
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion["eepp"] = $datos->datos;
        $nombre_pdf = "Estado de pago $nombre_contratista $fecha_pago";
        $pagina_uno = $this->load->view('EEPP/vista_pdf_eepp', $informacion, TRUE);
        
        // Cargamos la librería
        $this->load->library('pdfgenerator');
        // definamos un nombre para el archivo. No es necesario agregar la extension .pdf
        $filename = $nombre_pdf;
        // generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
        $this->pdfgenerator->generate($pagina_uno, $filename, true, 'Letter', 'portrait');

    }
    public function listado_materiales() {
        $data = [];
        $metodo = 'GET';
        $url = $this->api_sacpv . 'materiales';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['materiales_partidas'] = $datos->datos;
        $this->template->set('titulo', 'Listado de materiales'); 
        $menu = menu(6, 61);
        $this->template->set('menu', $menu);
        $this->template->load_template1('EEPP/listado_de_materiales', $informacion);
    }
}