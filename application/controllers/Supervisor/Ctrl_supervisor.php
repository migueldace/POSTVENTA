<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_supervisor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
        $this->api_maestra = API_MAESTRA;
        $this->api_sacpv = API_SACPV;
        // $this->validar();
    }
    public function inicio()
    {   
        $this->template->set('titulo', 'Mis inspecciones'); 
        $menu = menu(5, 50);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Supervisor/inicio');
    }
    public function detalle_ingresadas() {
        $id_solicitud = $this->input->post("id_solicitud");
        $informacion['id_solicitud'] = $id_solicitud;
        $informacion['fecha_visita'] = $this->input->post("fecha_visita");
        $informacion['hora_visita'] = $this->input->post("hora_visita");
        $informacion['estado'] = $this->input->post("estado");
        $informacion['prioridad'] = $this->input->post("prioridad");
        $informacion['rut'] = $this->input->post("rut");
        $informacion['nombre'] = $this->input->post("nombre");
        $informacion['telefono'] = $this->input->post("telefono");
        $informacion['comentario'] = $this->input->post("comentario");
        $informacion['rmo'] = $this->input->post("rmo");
        $informacion['cod_proyecto'] = $this->input->post("cod_proyecto");
        $informacion['proyecto'] = $this->input->post("proyecto");
        $informacion['direccion'] = $this->input->post("direccion");
        $informacion['fecha_visita_contratista'] = $this->input->post("fecha_visita_contratista");
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $array_respuesta = [];
        // $array_materiales = [];
        foreach ($informacion['sucesos'] as $s) {
            $id_solicitud_suceso = $s->id_solicitud_suceso;
            //*****PARTIDAS*****
            $url = $this->api_sacpv . 'suceso_partidas/'.$id_solicitud_suceso;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['suceso_partida'] = $datos->datos;
            if (empty($informacion['suceso_partida']) or is_null($informacion['suceso_partida'])) {}
            else {
                foreach ($informacion['suceso_partida'] as $sp) {
                    $objeto = new stdClass();
                    $objeto->id_suceso_partida = $sp->id_suceso_partidas;
                    $objeto->medida = $sp->unidad_medida;
                    $objeto->partida = $sp->partida;
                    $objeto->contratista = $sp->id_contratista;
                    $objeto->dias = $sp->dias_trabajo;
                    $objeto->fecha = $sp->fecha_inicio;
                    $objeto->id_solicitud_suceso = $sp->id_solicitud_suceso;
                    array_push($array_respuesta, $objeto);
                }
            }
        }
        $informacion['partidas_suceso'] = $array_respuesta;
        // $informacion['materiales_suceso'] = $array_materiales;
        //*****API PARTIDAS***** 
            $url = $this->api_sacpv . 'obtener_activos/partidas';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['partidas'] = $datos->datos;
        //*****API SUCESOS*****    
            $url = $this->api_sacpv . 'obtener_activos/sucesos';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['sucesos_all'] = $datos->datos;
        //*****API ORIGENES*****   
            $url = $this->api_sacpv . 'obtener_activos/origen';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['origen'] = $datos->datos;
        //*****API EDMU*****   
            $url = $this->api_sacpv . 'obtener_activos/edmu';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['edmu'] = $datos->datos;
        //*****API CONTRATISTAS*****
            $url = $this->api_maestra . 'usuario_perfil/19';
            $metodo = 'GET';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['contratistas'] = $datos->datos;

        $this->load->view('Solicitudes/modal_asignadas_supervisor_view', $informacion);
    }

    public function obtener_recursos() {
        $recurso_buscado = $this->input->post('recurso_buscado');
        // $informacion["id_solicitud_suceso"] = $this->input->post('id_solicitud_suceso');
        //*****API RECURSOS*****
        $data[] = '';
        $url = "https://www.innovamalpo.cl/api_master/api_unysoft/recursos/buscar_recurso/".$recurso_buscado;
        $metodo = 'GET'; #a que metodo estoy apuntando
        $datos = setCurl($url, $metodo, $data);
        $informacion["recursos"] = json_decode($datos);
        if ( empty($informacion["recursos"]) or is_null($informacion["recursos"]) ) {
            echo "<div class='alert alert-warning'>No se encontrarón resultados</div>";
        }
        else {
            $this->load->view("Solicitudes/tabla_agregar_recursos",$informacion);
        }
        // echo json_encode($recursos);
    }
    public function mi_calendario() {
        $this->template->set('titulo', 'Mi calendario'); 
        $menu = menu(5, 51);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Supervisor/calendario');
    }
    public function actualizar_ingresar_partidas() {
        //SUCESO
        $id_solicitud_suceso = $this->input->post("id_solicitud_suceso");
        $id_suceso = $this->input->post("suceso");
        $origen = $this->input->post("origen");
        $edmu = $this->input->post("edmu");
        $contratista = $this->input->post("contratista");
        $dias = $this->input->post("dias");
        $comentario = $this->input->post("comentario");
        $fecha = $this->input->post("fecha");
        $hora = $this->input->post("hora");
        $fecha_hora = $fecha." ".$hora;
        //API SUCESO
        $datos_suceso = array(
            'suceso_cliente' => "",
            'suceso_supervisor' => $id_suceso,
            'observacion' => $comentario,
            'edmu' => $edmu,
            'origen' => $origen,
            'suceso' => $id_suceso,
            'solicitud' => "",
            'otro_motivo_rechazo' => "",
            'estado' => 11
        );
        $data= $datos_suceso;
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud_suceso;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        //INGRESO DE PARTIDAS
        $partidas = $this->input->post("sucesos_partidas"); //ESTRUCTURA ID_SOLICITUD_SUCESO-PARTIDA/METROS
        //*****INGRESO DE PARTIDAS*****
        foreach ($partidas as $p) {
            $sucesos_partidas = explode("---", $p);
            $partida = $sucesos_partidas[1]; 
            $metros = $sucesos_partidas[2]; 
            $datos_partida = array(
                'unidad_medida' => $metros,
                'fecha_inicio' => $fecha_hora,
                'fecha_termino' => "",
                'dias_trabajo' => $dias,
                'id_contratista' => $contratista,
                'partidas' => $partida,
                'estado' => 20,
                'solicitud_suceso' => $id_solicitud_suceso,
                'precio_adicional' => 0,
                'justificacion' => ""
            );
            $data = $datos_partida;
            $url = $this->api_sacpv . 'suceso_partidas';
            $metodo = 'POST';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $info["insercion"] = $datos->datos;
        }
    }
    public function buscar_partidas() {
        $id_solicitud_suceso = $this->input->post("id_solicitud_suceso");
        //*****ÄPI PARTIDAS*****
        $metodo = 'GET';
        $data = [];
        $url = $this->api_sacpv . 'suceso_partidas/'.$id_solicitud_suceso;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['suceso_partida'] = $datos->datos;
        $partidas = "";
        if (empty($informacion['suceso_partida']) or is_null($informacion['suceso_partida'])) {}
        else {
            foreach ($informacion['suceso_partida'] as $sp) {
                if ($sp->id_estado == 20 or $sp->id_estado == 21) { //PENDIENTE O CONCLUIDO
                    $partidas .= "<option value='$sp->id_suceso_partidas'>$sp->partida</option>";
                }
            }
        }
        echo $partidas;
    }
    public function ingresar_materiales() {
        $id_suceso_partida = $this->input->post("id_suceso_partida");
        $cod_recurso = $this->input->post("cod_recurso");
        $recurso_detalle = $this->input->post("recurso_detalle");
        $cantidad = $this->input->post("cantidad");
        $comprado_por = $this->input->post("comprado_por");
        if (empty($id_suceso_partida) or is_null($id_suceso_partida) or empty($cod_recurso) or is_null($cod_recurso) or empty($recurso_detalle) or is_null($recurso_detalle) or empty($cantidad) or is_null($cantidad) or empty($comprado_por) or is_null($comprado_por)) {
            echo "error";
        }
        else {
            //********INGRESO API MATERIALES******
            $datos_materiales = array(
                'id_suceso_partida' => $id_suceso_partida,
                'cod_recurso' => $cod_recurso,
                'recurso_detalle' => $recurso_detalle,
                'cantidad' => $cantidad,
                'comprado_por' => $comprado_por,
                'precio' => 0
            );
            $data = $datos_materiales;
            $url = $this->api_sacpv . 'suceso_materiales';
            $metodo = 'POST';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $info["insercion"] = $datos->datos;
            echo "ok";
        }
    }
    public function rechazar_suceso() {
        $id_solicitud_suceso = $this->input->post("id_solicitud_suceso");
        $comentario = $this->input->post("comentario");
        $origen = $this->input->post("origen");
        $edmu = $this->input->post("edmu");
        //API SUCESO
        echo $id_solicitud_suceso;
        $datos_suceso = array(
            'suceso_cliente' => "",
            'suceso_supervisor' => "",
            'observacion' => $comentario,
            'edmu' => $edmu,
            'origen' => $origen,
            'suceso' => "",
            'solicitud' => "",
            'otro_motivo_rechazo' => $comentario,
            'estado' => 14
        );
        $data= $datos_suceso;
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud_suceso;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
    }
    public function confirmar_inspeccion() {
        $id_solicitud = $this->input->post("id_solicitud");
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $contador_sucesos = 0;
        $contador_pendientes = 0;
        $contador_rechazadas = 0;
        $contador_ready = 0;
        foreach ($informacion['sucesos'] as $s) {
            $edmu = $s->edmu;
            $estado = $s->id_estado; //10 el pendiente, 14 rechazado
            if ($estado == 10) {
                if ($edmu == 5) { //SI AUN NO SE HA TOCADO EL EDMU, SIGNIFICA QUE NO SE HA TOCADO EL SUCESO
                    $contador_pendientes ++;
                }
                else {
                    $contador_ready++;
                }
            }
            else if ($estado == 14){
                $contador_rechazadas++;
            }
            else {
                 $contador_ready++;
            }
            $contador_sucesos++;
        }
        if ($contador_pendientes >=1) { //SI QUEDAN PENDIENTES
            echo "error";
        }
        else if ($contador_rechazadas == $contador_sucesos) { //SI LAS RECHAZADAS SON IGUAL A EL TOTAL, OSEA TODAS SE RECHAZARON
            echo "rechazo";
        }
        else if(($contador_rechazadas+$contador_ready) == $contador_sucesos){
            //PROCEDER Y CAMBIAR EL ESTADO DE LA SOLICITUD
            //*****ACTUALIZAR SOLICITUD****************
            $datos_solicitud = array(
                'comentario_cliente' => "",
                'id_cliente' => "",
                'id_supervisor' => "",
                'id_callcenter' => "",
                'id_vivienda' => "",
                'tipo_trabajo' => "",
                'fecha_visita' => "",
                'hora_visita' => "",
                'estado' => 3
            );
            $data= $datos_solicitud;
            $url = $this->api_sacpv . 'solicitudes/'.$id_solicitud;
            $metodo = 'PUT';
            $datos = setCurl($url, $metodo, $data);
            //*****INGRESAR HISTORIAL DE SOLICITUD*****
            $historial_solicitud = array(
                'solicitud'  => $id_solicitud,
                'estado' => 3,
                'usuario' => $this->session->userdata('idusuario'),
                'fecha' => date('Y-m-d')
            );
            $data = $historial_solicitud;
            $url = $this->api_sacpv . 'solicitud_historial';
            $metodo = 'POST';
            $datos_historial = setCurl($url, $metodo, $data);
            echo "tamos ready";
        }
        
    }
    public function rechazar_solicitud() {
        $id_solicitud = $this->input->post("id_solicitud");
        $rut_cliente = $this->input->post("rut_cliente");
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $contador_sucesos = 0;
        $contador_pendientes = 0;
        $contador_rechazadas = 0;
        $contador_ready = 0;
        foreach ($informacion['sucesos'] as $s) {
            $edmu = $s->edmu;
            $estado = $s->id_estado; //10 el pendiente, 14 rechazado
            if ($estado == 10) {
                if ($edmu == 5) { //SI AUN NO SE HA TOCADO EL EDMU, SIGNIFICA QUE NO SE HA TOCADO EL SUCESO
                    $contador_pendientes ++;
                }
                else {
                    $contador_ready++;
                }
            }
            else if ($estado == 14){
                $contador_rechazadas++;
            }
            else {
                $contador_ready++;
            }
            $contador_sucesos++;
        }
        if ($contador_pendientes >=1) { //SI QUEDAN PENDIENTES
            echo "error";
        }
        else if ($contador_rechazadas == $contador_sucesos) { //SI LAS RECHAZADAS SON IGUAL A EL TOTAL, AQUI SE RECHAZA LA SOLICITUD, ANTES NO
            $datos_solicitud = array(
                'comentario_cliente' => "",
                'id_cliente' => "",
                'id_supervisor' => "",
                'id_callcenter' => "",
                'id_vivienda' => "",
                'tipo_trabajo' => "",
                'fecha_visita' => "",
                'hora_visita' => "",
                'estado' => 6 //rechazada
            );
            $data= $datos_solicitud;
            $url = $this->api_sacpv . 'solicitudes/'.$id_solicitud;
            $metodo = 'PUT';
            $datos = setCurl($url, $metodo, $data);
            //*****INGRESAR HISTORIAL DE SOLICITUD*****
            $historial_solicitud = array(
                'solicitud'  => $id_solicitud,
                'estado' => 6,
                'usuario' => $this->session->userdata('idusuario'),
                'fecha' => date('Y-m-d')
            );
            $data = $historial_solicitud;
            $url = $this->api_sacpv . 'solicitud_historial';
            $metodo = 'POST';
            $datos_historial = setCurl($url, $metodo, $data);
            $this->correo_rechazo($id_solicitud, $rut_cliente);
            echo "tamos ready";
        }
        else if(($contador_rechazadas+$contador_ready) == $contador_sucesos){ //HAY SUCESOS YA INGRESADOS, NO SE PUEDE RECHAZAR
           echo "error_listos";
        }
        
    }
    public function inspeccion_final() {
        $id_solicitud = $this->input->post("id_solicitud");
        $informacion['id_solicitud'] = $id_solicitud;
        $informacion['fecha_visita'] = $this->input->post("fecha_visita");
        $informacion['hora_visita'] = $this->input->post("hora_visita");
        $informacion['estado'] = $this->input->post("estado");
        $informacion['prioridad'] = $this->input->post("prioridad");
        $informacion['rut'] = $this->input->post("rut");
        $informacion['nombre'] = $this->input->post("nombre");
        $informacion['telefono'] = $this->input->post("telefono");
        $informacion['comentario'] = $this->input->post("comentario");
        $informacion['rmo'] = $this->input->post("rmo");
        $informacion['cod_proyecto'] = $this->input->post("cod_proyecto");
        $informacion['proyecto'] = $this->input->post("proyecto");
        $informacion['direccion'] = $this->input->post("direccion");
        $informacion['fecha_visita_contratista'] = $this->input->post("fecha_visita_contratista");
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $array_respuesta = [];
        $array_materiales = [];
        // var_dump($informacion['sucesos']);
        foreach ($informacion['sucesos'] as $s) {
            $id_solicitud_suceso = $s->id_solicitud_suceso;
            //*****PARTIDAS*****
            $url = $this->api_sacpv . 'suceso_partidas/'.$id_solicitud_suceso;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['suceso_partida'] = $datos->datos;
            if (empty($informacion['suceso_partida']) or is_null($informacion['suceso_partida'])) {}
            else {
                foreach ($informacion['suceso_partida'] as $sp) {
                    $objeto = new stdClass();
                    $objeto->id_suceso_partida = $sp->id_suceso_partidas;
                    $objeto->medida = $sp->unidad_medida;
                    $objeto->partida = $sp->partida;
                    $objeto->id_estado = $sp->id_estado;
                    $objeto->estado = $sp->estado;
                    $objeto->contratista = $sp->id_contratista;
                    $objeto->dias = $sp->dias_trabajo;
                    $objeto->fecha_inicio = $sp->fecha_inicio;
                    $objeto->fecha_termino = $sp->fecha_termino;
                    $objeto->id_solicitud_suceso = $sp->id_solicitud_suceso;
                    array_push($array_respuesta, $objeto);
                }
            }
            
        }
        $informacion['partidas_suceso'] = $array_respuesta;
        //*****MATEARIALES*****
        foreach ($informacion['partidas_suceso'] as $suc) {
            $url = $this->api_sacpv . 'suceso_materiales/'.$suc->id_suceso_partida;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['suceso_materiales'] = $datos->datos;
            if (empty($informacion['suceso_materiales']) or is_null($informacion['suceso_materiales'])) {}
            else {
                foreach ($informacion['suceso_materiales'] as $sm) {
                    $objeto = new stdClass();
                    $objeto->partida = $suc->partida;
                    $objeto->id_solicitud_suceso = $suc->id_solicitud_suceso;
                    $objeto->id_materiales = $sm->id_materiales;
                    $objeto->id_suceso_partida = $sm->id_suceso_partida;
                    $objeto->cod_recurso = $sm->cod_recurso;
                    $objeto->recurso_detalle = $sm->recurso_detalle;
                    $objeto->cantidad = $sm->cantidad;
                    $objeto->comprado_por = $sm->comprado_por;
                    array_push($array_materiales, $objeto);
                }
            }
        }
        $informacion['materiales_partidas'] = $array_materiales;
        //*****API EDMU*****   
        $url = $this->api_sacpv . 'obtener_activos/edmu';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['edmu'] = $datos->datos;
        //*****API CONTRATISTAS*****
        $url = $this->api_maestra . 'usuario_perfil/19';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratistas'] = $datos->datos;
        $this->load->view('Solicitudes/modal_inspeccion_final_view', $informacion);
    }
    public function inspeccion_final_partidas() {
        $id_solicitud = $this->input->post("id_solicitud");
        $partidas_realizadas = $this->input->post("partidas_realizadas");
        $id_solicitud_suceso = $this->input->post("id_solicitud_suceso");
        $edmu = $this->input->post("edmu");
        if (empty($partidas_realizadas) or is_null($partidas_realizadas)) {
            $datos_suceso = array(
                'suceso_cliente' => "",
                'suceso_supervisor' => "",
                'observacion' => "",
                'edmu' => $edmu,
                'origen' => "",
                'suceso' => "",
                'solicitud' => "",
                'otro_motivo_rechazo' => "",
                'estado' => ""
            );
            $data= $datos_suceso;
            $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud_suceso;
            $metodo = 'PUT';
            $datos = setCurl($url, $metodo, $data);
            echo "error";
        }
        else {
            foreach ($partidas_realizadas as $pr) {
                //API SUCESO PARTIDA
                $datos_partida = array(
                    'unidad_medida' => "",
                    'fecha_inicio' => "",
                    'fecha_termino' => date("Y-m-d H:i"),
                    'dias_trabajo' => "",
                    'id_contratista' => "",
                    'partidas' => "",
                    'estado' => 21,
                    'solicitud_suceso' => "",
                    'precio_adicional' => 0,
                    'justificacion' => ""
                );
                $data= $datos_partida;
                $url = $this->api_sacpv . 'suceso_partidas/'.$pr;
                $metodo = 'PUT';
                $datos = setCurl($url, $metodo, $data);
            }
            //*****API SUCESOS DE LA SOLICITUD*****
            $data[] = '';
            $metodo = "GET";
            $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['sucesos'] = $datos->datos;
            $array_respuesta = [];
            foreach ($informacion['sucesos'] as $s) {
                if ($s->id_estado == 14) { // SI ESTA RECHAZADO, NO HAGO NADA
                }
                else { //SI EL SUCESO ESTA EN OTRO ESTADO
                    $id_solicitud_suceso = $s->id_solicitud_suceso;
                    //*****PARTIDAS*****
                    $url = $this->api_sacpv . 'suceso_partidas/'.$id_solicitud_suceso;
                    $datos = setCurl($url, $metodo, $data);
                    $datos = json_decode($datos);
                    $informacion['suceso_partida'] = $datos->datos;
                    $quedan_pendientes = 0;
                    if (empty($informacion['suceso_partida']) or is_null($informacion['suceso_partida'])) {}
                    else {
                        foreach ($informacion['suceso_partida'] as $sp) { //RECORRER LAS PARTIDAS DEL SUCESO
                            //VALIDAR LOS ESTADOS, SI TODOS SON 21 o 22, SE DEBE ACTUALIZAR EL SUCESO A 12 FINALIZADO
                            if($sp->id_estado == 20) { //si queda alguno pendiente
                                $quedan_pendientes++;
                            }
                            $objeto = new stdClass();
                            $objeto->id_suceso_partida = $sp->id_suceso_partidas;
                            $objeto->medida = $sp->unidad_medida;
                            $objeto->partida = $sp->partida;
                            $objeto->id_estado = $sp->id_estado;
                            $objeto->estado = $sp->estado;
                            $objeto->contratista = $sp->id_contratista;
                            $objeto->dias = $sp->dias_trabajo;
                            $objeto->fecha_inicio = $sp->fecha_inicio;
                            $objeto->fecha_termino = $sp->fecha_termino;
                            $objeto->id_solicitud_suceso = $sp->id_solicitud_suceso;
                            array_push($array_respuesta, $objeto);
                        }
                        if ($quedan_pendientes == 0 and $s->id_estado == 11) { //NO QUEDA NINGUNO PENDIENTE, SE DEBE CERRAR EL SUCESO
                            //API SUCESO PARTIDA
                             $datos_suceso = array(
                                'suceso_cliente' => "",
                                'suceso_supervisor' => "",
                                'observacion' => "",
                                'edmu' => "",
                                'origen' => "",
                                'suceso' => "",
                                'solicitud' => "",
                                'otro_motivo_rechazo' => "",
                                'estado' => 12
                            );
                            $data= $datos_suceso;
                            $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud_suceso;
                            $metodo = 'PUT';
                            $datos = setCurl($url, $metodo, $data);
                        }
                    }
                }
            }
            $datos_suceso = array(
                'suceso_cliente' => "",
                'suceso_supervisor' => "",
                'observacion' => "",
                'edmu' => $edmu,
                'origen' => "",
                'suceso' => "",
                'solicitud' => "",
                'otro_motivo_rechazo' => "",
                'estado' => ""
            );
            $data= $datos_suceso;
            $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud_suceso;
            $metodo = 'PUT';
            $datos = setCurl($url, $metodo, $data);
            $data[] = '';
            $metodo = "GET";
            $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['sucesos'] = $datos->datos;
            $informacion['partidas_suceso'] = $array_respuesta;
            //*****API EDMU*****   
            $url = $this->api_sacpv . 'obtener_activos/edmu';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['edmu'] = $datos->datos;
            //*****API CONTRATISTAS*****
            $url = $this->api_maestra . 'usuario_perfil/19';
            $metodo = 'GET';
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['contratistas'] = $datos->datos;
            $this->load->view('Solicitudes/tabla_sucesos', $informacion);
            // var_dump($this->input->post());
        }
    }
    public function finalizar_solicitud() {
        $id_solicitud = $this->input->post("id_solicitud");
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $array_respuesta = [];
        $contador_sucesos_pendientes = 0;
        foreach ($informacion['sucesos'] as $s) {
            if ($s->id_estado == 10 or $s->id_estado == 11) {
                $contador_sucesos_pendientes++;
            }
        }
        if ($contador_sucesos_pendientes == 0) { //SI NO QUEDA NINGUN SUCESO PENDIENTE 
            //FINALIZAR LA SOLICITUD, INSERTAR TMB EL HISTORIAL
            //*****ACTUALIZAR SOLICITUD****************
            $datos_solicitud = array(
                'comentario_cliente' => "",
                'id_cliente' => "",
                'id_supervisor' => "",
                'id_callcenter' => "",
                'id_vivienda' => "",
                'tipo_trabajo' => "",
                'fecha_visita' => "",
                'hora_visita' => "",
                'estado' => 5
            );
            $data= $datos_solicitud;
            $url = $this->api_sacpv . 'solicitudes/'.$id_solicitud;
            $metodo = 'PUT';
            $datos = setCurl($url, $metodo, $data);
            //*****INGRESAR HISTORIAL DE SOLICITUD*****
            $historial_solicitud = array(
                'solicitud'  => $id_solicitud,
                'estado' => 5,
                'usuario' => $this->session->userdata('idusuario'),
                'fecha' => date('Y-m-d')
            );
            $data = $historial_solicitud;
            $url = $this->api_sacpv . 'solicitud_historial';
            $metodo = 'POST';
            $datos_historial = setCurl($url, $metodo, $data);
            echo "tamos ready";

        }
        else {
            echo "error";
        }
    }
    public function cargar_partidas () {

        $id_suceso = $this->input->post("id_suceso");
        $id = $this->input->post("id");
        //*****ÄPI PARTIDAS*****
        $metodo = 'GET';
        $data = [];
        $url = $this->api_sacpv . 'partidas_del_suceso/'.$id_suceso;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['partidas'] = $datos->datos;
        $partidas = "";
        if (empty($informacion['partidas']) or is_null($informacion['partidas'])) {}
        else {
            $contador = 1;
            foreach ($informacion['partidas'] as $sp) {
                $partidas .= "<option id='partida".$id."_$contador' value='$sp->id_partida'>$sp->partida - $sp->unidad</option>";
                $contador++;
            }
        }
        echo $partidas;
    }
    public function pdf_conformidad_supervisor() {
        $id_solicitud = $this->input->post("id_solicitud_pdf");
        $informacion['id_solicitud'] = $id_solicitud;

        $rut = $this->input->post("rut_pdf");
        $informacion['rut'] = $rut;

        $nombre = $this->input->post("nombre_pdf");
        $informacion['nombre'] = strtoupper($nombre);

        $telefono = $this->input->post("telefono_pdf");
        $informacion['telefono'] = $telefono;

        $proyecto = $this->input->post("proyecto_pdf");
        $informacion['proyecto'] = $proyecto;

        $direccion = $this->input->post("direccion_pdf");
        $informacion['direccion'] = $direccion;

        $nombre_pdf = "Conformidad solicitud n° $id_solicitud";
        //*****API SUCESOS DE LA SOLICITUD*****
        $data[] = '';
        $metodo = "GET";
        $url = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['sucesos'] = $datos->datos;
        $array_respuesta = [];
        foreach ($informacion['sucesos'] as $s) {
            $id_solicitud_suceso = $s->id_solicitud_suceso;
            //*****PARTIDAS*****
            $url = $this->api_sacpv . 'suceso_partidas/'.$id_solicitud_suceso;
            $datos = setCurl($url, $metodo, $data);
            $datos = json_decode($datos);
            $informacion['suceso_partida'] = $datos->datos;
            if (empty($informacion['suceso_partida']) or is_null($informacion['suceso_partida'])) {}
            else {
                foreach ($informacion['suceso_partida'] as $sp) {
                    $objeto = new stdClass();
                    $objeto->id_suceso_partida = $sp->id_suceso_partidas;
                    $objeto->medida = $sp->unidad_medida;
                    $objeto->tipo_medida = $sp->unidad;
                    $objeto->partida = $sp->partida;
                    $objeto->id_estado = $sp->id_estado;
                    $objeto->estado = $sp->estado;
                    $objeto->contratista = $sp->id_contratista;
                    $objeto->dias = $sp->dias_trabajo;
                    $objeto->fecha_inicio = $sp->fecha_inicio;
                    $objeto->fecha_termino = $sp->fecha_termino;
                    $objeto->id_solicitud_suceso = $sp->id_solicitud_suceso;
                    array_push($array_respuesta, $objeto);
                }
            }
        }
        $informacion['partidas_suceso'] = $array_respuesta;
        $pagina_uno = $this->load->view('Supervisor/pdf_conformidad', $informacion, TRUE);

        // Cargamos la librería
        $this->load->library('pdfgenerator');
        // definamos un nombre para el archivo. No es necesario agregar la extension .pdf
        $filename = $nombre_pdf;
        // generamos el PDF. Pasemos por encima de la configuración general y definamos otro tipo de papel
        $this->pdfgenerator->generate($pagina_uno, $filename, true, 'Letter', 'landscape'); //landscape = horizontal - portrait = vertical
    }
    //**********CORREOS*****
    public function correo_rechazo($cod_solicitud, $rut_cliente) {
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_cliente;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        foreach ($informacion['cliente'] as $cli) {
            $idcliente = $cli->idcliente;
            $cliente_rut = $cli->clienteRut;
            $cliente_correo = $cli->clienteCorreo;
            $cliente_nombre = $cli->clienteNombre;
            break;
        }
        $this->load->library('email');
        $htmlContent = '
        <!doctype html>
        <html>
          <head>
          <meta charset="utf-8">
          <title></title>
          </head>
          <body style="font-family:"Helvetica Neue", Helvetica, Arial, sans-serif; background-color:#eeeeee; margin:0; padding:0; color:#333333;">
            <table width="100%" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table cellpadding="0" cellspacing="0" width="600" border="0" align="center">
                      <tbody>
                        <tr><td height="40" style="font-size:12px;" align="center"></td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tbody>
                                <tr>
                                  <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0">
                                    <img src="'.base_url().'assets/img/malpo.png" width="600" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                    <p style="margin:0 30px 33px;; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                        Su Solicitud Nº '.$cod_solicitud.' no fue acogida!
                                    </p>
                                    <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.'. <br>Le informamos que su solicitud acaba de ser rechazada, para obtener más información, acceda a nuestra plataforma presionando <a href="https://www.innovamalpo.cl/Comercial/POSTVENTA/Ctrl_cliente" target="_blank" style="color:#3399cc; text-decoration:none; font-weight:bold;">Aquí</a>
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td colspan="3">
                                          <hr>
                                            <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;">
                                            </p>
                                            <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Si usted tiene alguna duda o consulta respecto a la resolución de esta solicitud, puede ponerse en contácto con nosotros a los fonos: 6008183000 - (71)2233397</b></p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#DDDDDD">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="400">
                                            <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">Constructora e Inmobiliaria Malpo
                                            </p>
                                            <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">Contacto Post Venta 6008183000-(71)2233397<br>
                                                Sitio Web: <a href="http://www.malpo.cl/" target="_blank" style="color:#3399cc; text-decoration:none; font-weight:bold;">www.malpo.cl</a>
                                            </p>
                                          </td>
                                          <td width="26"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="114">
                                            <a href="https://www.facebook.com/people/Malpo-Constructora/100004219085988" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/facebook.png" width="30" height="30" alt="facebook" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="https://twitter.com/malpoconstruct?lang=es" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/twitter.png" width="30" height="30" alt="twitter" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="http://www.malpo.cl/blog/" target="_blank" style="float:left; width:24px; height:24px; margin:6px 0 10px 0;"><img src="'.base_url().'assets/img/rss.png" width="30" height="30" alt="rss" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <p style="margin:0; font-weight:bold; clear:both; font-size:12px; line-height:22px;"><a href="'.base_url().'index.php" target="_blank" style="color:#3399cc; text-decoration:none;">Ir al sitio</a>
                                            </p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
        </html>';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $correo = "servicioalcliente@malpo.cl";
        $destinatarios = array($correo, $cliente_correo);
        $this->email->to($destinatarios);
        $this->email->from('servicioalcliente@malpo.cl','Servicio al cliente Malpo');
        $this->email->subject('Rechazo de solicitud POST-VENTA');
        $this->email->message($htmlContent);
        // $this->email->send();
        echo $htmlContent;
    }
    public function correo_ausencia() {
        // $id_solicitud = $this->input->post("id_solicitud");
        $rut_cliente = $this->input->post("rut_cliente");
        // $fecha_inspeccion = $this->input->post("fecha_inspeccion");
        $id_solicitud = 5555;
        $fecha_inspeccion = "25-02-2020 15:00 Hrs";
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_cliente;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        foreach ($informacion['cliente'] as $cli) {
            $idcliente = $cli->idcliente;
            $cliente_rut = $cli->clienteRut;
            $cliente_correo = $cli->clienteCorreo;
            $cliente_nombre = $cli->clienteNombre;
            break;
        }
        $this->load->library('email');
        $htmlContent = '
        <!doctype html>
        <html>
          <head>
          <meta charset="utf-8">
          <title></title>
          </head>
          <body style="font-family:"Helvetica Neue", Helvetica, Arial, sans-serif; background-color:#eeeeee; margin:0; padding:0; color:#333333;">
            <table width="100%" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table cellpadding="0" cellspacing="0" width="600" border="0" align="center">
                      <tbody>
                        <tr><td height="40" style="font-size:12px;" align="center"></td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tbody>
                                <tr>
                                  <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0">
                                    <img src="'.base_url().'assets/img/malpo.png" width="600" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                    <p style="margin:0 30px 33px;; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                        No se encontró moradores en su vivienda!
                                    </p>
                                    <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.'. <br>Le informamos que nuestro inspector no encontró moradores en su vivienda al momento de realizar la visita programada para el día '.$fecha_inspeccion.' (Solicitud N° '.$id_solicitud.'). Si es la primera vez que ocurre esto, su solicitud será re agendada previa coordinación, en caso contrario su solicitud será rechazada y deberá realizar nuevamente el ingreso de la solicitud si desea atención. <br>
                                        *Si usted avisó con al menos 24 hrs su ausencia, por favor ignore este correo.*
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td colspan="3">
                                          <hr>
                                            <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;">
                                            </p>
                                            <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Si usted tiene alguna duda o consulta respecto a la resolución de esta solicitud, puede ponerse en contácto con nosotros a los fonos: 6008183000 - (71)2233397</b></p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#DDDDDD">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="400">
                                            <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">Constructora e Inmobiliaria Malpo
                                            </p>
                                            <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">Contacto Post Venta 6008183000-(71)2233397<br>
                                                Sitio Web: <a href="http://www.malpo.cl/" target="_blank" style="color:#3399cc; text-decoration:none; font-weight:bold;">www.malpo.cl</a>
                                            </p>
                                          </td>
                                          <td width="26"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="114">
                                            <a href="https://www.facebook.com/people/Malpo-Constructora/100004219085988" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/facebook.png" width="30" height="30" alt="facebook" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="https://twitter.com/malpoconstruct?lang=es" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/twitter.png" width="30" height="30" alt="twitter" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="http://www.malpo.cl/blog/" target="_blank" style="float:left; width:24px; height:24px; margin:6px 0 10px 0;"><img src="'.base_url().'assets/img/rss.png" width="30" height="30" alt="rss" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <p style="margin:0; font-weight:bold; clear:both; font-size:12px; line-height:22px;"><a href="'.base_url().'index.php" target="_blank" style="color:#3399cc; text-decoration:none;">Ir al sitio</a>
                                            </p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
        </html>';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $correo = "servicioalcliente@malpo.cl";
        $destinatarios = array($correo, $cliente_correo);
        $this->email->to($destinatarios);
        $this->email->from('servicioalcliente@malpo.cl','Servicio al cliente Malpo');
        $this->email->subject('Rechazo de solicitud POST-VENTA');
        $this->email->message($htmlContent);
        // $this->email->send();
        echo $htmlContent;
    }
    public function correo_ausencia_trabajos() {
        // $id_solicitud = $this->input->post("id_solicitud");
        $rut_cliente = $this->input->post("rut_cliente");
        // $fecha_inspeccion = $this->input->post("fecha_inspeccion");
        $id_solicitud = 5555;
        $fecha_inspeccion = "25-02-2020 15:00 Hrs";
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_cliente;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        foreach ($informacion['cliente'] as $cli) {
            $idcliente = $cli->idcliente;
            $cliente_rut = $cli->clienteRut;
            $cliente_correo = $cli->clienteCorreo;
            $cliente_nombre = $cli->clienteNombre;
            break;
        }
        $this->load->library('email');
        $htmlContent = '
        <!doctype html>
        <html>
          <head>
          <meta charset="utf-8">
          <title></title>
          </head>
          <body style="font-family:"Helvetica Neue", Helvetica, Arial, sans-serif; background-color:#eeeeee; margin:0; padding:0; color:#333333;">
            <table width="100%" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table cellpadding="0" cellspacing="0" width="600" border="0" align="center">
                      <tbody>
                        <tr><td height="40" style="font-size:12px;" align="center"></td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tbody>
                                <tr>
                                  <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0">
                                    <img src="'.base_url().'assets/img/malpo.png" width="600" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                    <p style="margin:0 30px 33px;; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                        No se encontró moradores en su vivienda!
                                    </p>
                                    <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.'. <br>Le informamos que nuestro equipo de trabajos, no encontró moradores en su vivienda al momento de realizar la visita de trabajos programada para el día '.$fecha_inspeccion.' (Solicitud N° '.$id_solicitud.'). Debido a esto se re agendaran los trabajos para una siguiente oportunidad previa coordinación. <br>
                                    *Si usted avisó con al menos 24 hrs de su ausencia por favor ignore este correo*
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td colspan="3">
                                          <hr>
                                            <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;">
                                            </p>
                                            <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Si usted tiene alguna duda o consulta respecto a la resolución de esta solicitud, puede ponerse en contácto con nosotros a los fonos: 6008183000 - (71)2233397</b></p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#DDDDDD">
                                      <tbody>
                                        <tr valign="top">
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="400">
                                            <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">Constructora e Inmobiliaria Malpo
                                            </p>
                                            <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">Contacto Post Venta 6008183000-(71)2233397<br>
                                                Sitio Web: <a href="http://www.malpo.cl/" target="_blank" style="color:#3399cc; text-decoration:none; font-weight:bold;">www.malpo.cl</a>
                                            </p>
                                          </td>
                                          <td width="26"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          <td width="114">
                                            <a href="https://www.facebook.com/people/Malpo-Constructora/100004219085988" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/facebook.png" width="30" height="30" alt="facebook" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="https://twitter.com/malpoconstruct?lang=es" target="_blank" style="float:left; width:24px; height:24px; margin:6px 15px 10px 0;"><img src="'.base_url().'assets/img/twitter.png" width="30" height="30" alt="twitter" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <a href="http://www.malpo.cl/blog/" target="_blank" style="float:left; width:24px; height:24px; margin:6px 0 10px 0;"><img src="'.base_url().'assets/img/rss.png" width="30" height="30" alt="rss" style="display:block; margin:0; border:0; background:#eeeeee;"></a>
                                            <p style="margin:0; font-weight:bold; clear:both; font-size:12px; line-height:22px;"><a href="'.base_url().'index.php" target="_blank" style="color:#3399cc; text-decoration:none;">Ir al sitio</a>
                                            </p>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </body>
        </html>';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $correo = "servicioalcliente@malpo.cl";
        $destinatarios = array($correo, $cliente_correo);
        $this->email->to($destinatarios);
        $this->email->from('servicioalcliente@malpo.cl','Servicio al cliente Malpo');
        $this->email->subject('Rechazo de solicitud POST-VENTA');
        $this->email->message($htmlContent);
        // $this->email->send();
        echo $htmlContent;
    }
    //********CORREOS******
}