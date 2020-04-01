<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_cliente extends CI_Controller
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

    public function validar()
    {
        if (!sesion()) :
            redirect('inicio/error_sesion');
        endif;
    }    

    public function index()
    {       
        // $this->template->set('titulo', 'Inicio Cliente'); 
        // $menu = menu(1, 1);
        // $this->template->set('menu', $menu);
        // $this->template->load_template1('Cliente/login');
        $this->load->view('Cliente/login');
    }
    public function inicio() {
        // Catch the user's answer
        // $captcha_answer = $this->input->post('g-recaptcha-response');
        // // Verify user's answer
        // $response = $this->recaptcha->verifyResponse($captcha_answer);
        // // Processing ...
        // if ($response['success']) {
        // }else {
        //     $this->session->set_flashdata('error', 'Error de Captcha!');
        //     header("Location: ".base_url()."index.php/controlador/index");
        // }
        if ($this->input->post('usuario')) {
            $usuario_rut = $this->input->post('usuario');
            $usuario_correo = $this->input->post('clave');
        }
        else if($this->session->userdata('rutcliente')) {
            $usuario_rut = $this->session->userdata('rutcliente');
            $usuario_correo = $this->session->userdata('email');
        }
        else {
            header("Location: ".base_url()."ctrl_cliente");
        }
        //FORMATEAR RUT
        if (strlen($usuario_rut) == 8) { //SI ES RUT DE 8 DIGITOS
            $parte1 = substr($usuario_rut, 0,1);
            $parte2 = substr($usuario_rut, 1,3);
            $parte3 = substr($usuario_rut, 4,3);
            $parte4 = substr($usuario_rut, 7,1);
            $rut_formateado = $parte1.".".$parte2.".".$parte3."-".$parte4;
        }
        else if(strlen($usuario_rut) == 9) {
            $parte1 = substr($usuario_rut, 0,2);
            $parte2 = substr($usuario_rut, 2,3);
            $parte3 = substr($usuario_rut, 5,3);
            $parte4 = substr($usuario_rut, 8,1);
            $rut_formateado = $parte1.".".$parte2.".".$parte3."-".$parte4;
        }
        else { //NO EXISTEN RUT DE OTROS DIGITOS, SE VA A LA B :V
            $this->session->set_flashdata('mensaje', 'Datos incorrectos, intente nuevamente!');
            header("Location: ".base_url()."ctrl_cliente");
        }
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_formateado;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        if ($informacion['cliente'] == NULL) { //VALIDAR SI EXISTE EL RUT
            $this->session->set_flashdata('mensaje', 'Datos incorrectos, intente nuevamente!');
            header("Location: ".base_url()."ctrl_cliente");
        }
        else { //SI EXISTE, VERIFICAR EL CORREO
            $idcliente = 0;
            $cliente_rut = "";
            $cliente_correo = "";
            $cliente_nombre = "";
            foreach ($informacion['cliente'] as $cli) {
                $idcliente = $cli->idcliente;
                $cliente_rut = $cli->clienteRut;
                $cliente_correo = $cli->clienteCorreo;
                $cliente_nombre = $cli->clienteNombre;
                break;
            }
            if (strtoupper($usuario_correo) == strtoupper($cliente_correo)) { //SI EL CORREO ES CORRECTO
                $usuario_data = array(
                    'id_cliente' => $idcliente,
                    'rutcliente' => $cliente_rut,
                    'nombre' => $cliente_nombre,
                    'email' => $cliente_correo,
                    'logueado' => TRUE
                );
                $this->session->set_userdata($usuario_data);
                $this->templatecliente->set('titulo', 'Solicitudes Clientes');
                $menu = menu(2, 23);
                $this->templatecliente->set('menu', $menu);
                $this->templatecliente->load_template2('Cliente/solicitudes_view');
            }
            else {
                $this->session->set_flashdata('mensaje', 'Datos incorrectos, intente nuevamente!');
                header("Location: ".base_url()."ctrl_cliente");
            } 
        }
    }
    public function solicitud() {
        $rut_cliente = $this->session->userdata('rutcliente');
        $id_cliente = $this->session->userdata('id_cliente');
        //*****API CLIENTE*****
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_cliente;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        // echo $datos;
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        // var_dump($datos->datos);
        //*****API VIVIENDA CLIENTE*****
        $data2[] = '';
        $url2 = $this->api_maestra . 'viviendas/'.$rut_cliente;
        $datos2 = setCurl($url2, $metodo, $data2);
        $datos2 = json_decode($datos2);
        $informacion['vivienda'] = $datos2->datos;
        
        //*****API PROYECTOS*****
        $data3[] = '';
        $url3 = $this->api_maestra . 'proyectos';
        $datos3 = setCurl($url3, $metodo, $data3);
        $datos3 = json_decode($datos3);
        $informacion['proyectos'] = $datos3->datos;
        //*****API CATEGORIAS*****
        $data4[] = '';     
        $url4 = $this->api_sacpv . 'obtener_activos/categorias';
        $datos4 = setCurl($url4, $metodo, $data4);
        $datos4 = json_decode($datos4);
        $informacion['categorias'] = $datos4->datos;
        //*****API SUCESOS*****
        $data5[] = '';     
        $url5 = $this->api_sacpv . 'obtener_activos/sucesos';
        $datos5 = setCurl($url5, $metodo, $data5);
        $datos5 = json_decode($datos5);
        $informacion['sucesos'] = $datos5->datos;
        //*****API ORIGENES*****
        $data6[] = '';     
        $url6 = $this->api_sacpv . 'obtener_activos/origen';
        $datos6 = setCurl($url6, $metodo, $data6);
        $datos6 = json_decode($datos6);
        $informacion['origen'] = $datos6->datos;

        //*****API SOLICITUDES***** //CAMBIR DESPUES A SOLO LAS SOLICITUDES PENDIENTES O EN PROCESO
        $data7[] = '';
        $url7 = $this->api_sacpv . 'solicitudes/'.$id_cliente;
        $datos7 = setCurl($url7, $metodo, $data7);
        $datos7 = json_decode($datos7);
        $informacion['solicitudes'] = $datos7->datos;
        if (empty($informacion['solicitudes']) or is_null($informacion['solicitudes'])) {
        }
        else {
          $array_respuesta = [];
          foreach ($informacion['solicitudes'] as $sol) {
            $id_solicitud = $sol->id_solicitud;
            $data8[] = '';
            $url8 = $this->api_sacpv . 'solicitud_suceso/'.$id_solicitud;
            $datos8 = setCurl($url8, $metodo, $data8);
            $datos8 = json_decode($datos8);
            $informacion['solicitud_suceso'] = $datos8->datos;
            // var_dump( $informacion['solicitud_suceso']);
            
            $objeto = new stdClass();
            foreach ($informacion['solicitud_suceso'] as $s_c) {
              if ($s_c->id_estado == 10 or $s_c->id_estado == 11) { //si estan pendiente
                $objeto->id_suceso = $s_c->id_suceso;
                $objeto->id_origen = $s_c->id_origen;
                $objeto->id_estado = $s_c->id_estado;
                array_push($array_respuesta, $objeto);
              }
            }
          }
          $informacion['sucesos_pendientes'] = (object)$array_respuesta;
        }
        //*****DATOS VISTA*****
        $this->templatecliente->set('titulo', 'Solicitud de Atención'); 
        $menu = menu(2, 4);
        $this->templatecliente->set('menu', $menu);
        $this->templatecliente->load_template2('Cliente/solicitud', $informacion);
    }
    public function datos_vivienda_categorias() {
        $rut_cliente = $this->input->post("rut_cliente");
        $id_vivienda = $this->input->post("id_vivienda");
        //*****API VIVIENDA CLIENTE*****
        $data[] = '';
        $metodo = 'GET';
        $url = $this->api_maestra . 'viviendas/'.$rut_cliente;
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['vivienda'] = $datos->datos;
        $array_respuesta = [];
        $objeto = new stdClass();

        foreach ($informacion['vivienda'] as $viv) {
            if ($viv->idvivienda == $id_vivienda) {
                $objeto->direccion_real = $viv->viviendaDireccion;
                $objeto->garantia = date("d-m-Y",strtotime($viv->viviendaFecharecepcion));
                $objeto->tipo_vivienda = $viv->viviendaTipo;
                $objeto->modelo_vivienda = $viv->viviendaModelo;
                array_push($array_respuesta, $objeto);
            }
        }
        echo json_encode($array_respuesta);
    }
    public function ingresar_solicitud() {
        $rut_cliente = $this->input->post("rut_cliente");
        $vivienda_afectada = $this->input->post("vivienda");
        $direccion_real = $this->input->post("direccion_real");
        $id_cliente = $this->input->post("id_cliente");
        $suceso_origen = $this->input->post("suceso_origen");
        $comentario = $this->input->post("comentario");
        $comentario = preg_replace("/[\r\n|\n|\r]+/", " ", $comentario);
        //ACTUALIZAR DIRECCION
        $datos_vivienda = array(
            'viviendaUnysoft' => "",
            'viviendaClienterut' => "",
            'viviendaProyecto' => "",
            'viviendaDireccion' => $direccion_real,
            'viviendaFecharecepcion' => "",
            'viviendaTipo' => "",
            'viviendaModelo' => "",
            'viviendaArrendatario' => "",
            'viviendaNombreAr' => "",
            'viviendaTelefonoAr' => "",
            'viviendaCorreoAr' => ""
        );
        $data= $datos_vivienda;
        $url = $this->api_maestra . 'viviendas/'.$vivienda_afectada;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        //*********VERIFICAR SI TIENE UNA SOLICITUD PENDIENTE, SI ES EL CASO, AÑADIRLE LOS NUEEVOS SUCESOS A ESA SOLCITUD*****
        $data7[] = '';
        $url7 = $this->api_sacpv . 'solicitudes/'.$id_cliente;
        $metodo7 = "GET";
        $datos7 = setCurl($url7, $metodo7, $data7);
        $datos7 = json_decode($datos7);
        $informacion['solicitudes'] = $datos7->datos;
        if (empty($informacion['solicitudes']) or is_null($informacion['solicitudes'])) {
            //SI NO TIENE SOLICITUDES, LA INGRESO NORMALMENTE
             //*****INGRESO DE SOLICITUD*****
           $datos_solicitud = array(
                'comentario_cliente'  => $comentario,
                'id_vivienda' => $vivienda_afectada,
                'id_cliente' => $id_cliente,
                'id_supervisor' => "",
                'id_callcenter' => "",
                'fecha_visita' => "",
                'hora_visita' => "",
                'tipo_trabajo' => 1,
                'estado' => 1 
            );
            // var_dump($datos_solicitud);
            $data = $datos_solicitud;
            $url = $this->api_sacpv . 'solicitudes';
            $metodo = 'POST';
            $datos_insercion = setCurl($url, $metodo, $data);
            $datos_insercion = json_decode($datos_insercion);
            $info["insercion"] = $datos_insercion->datos;
            $id_solicitud = $info["insercion"]->id;
            //*****INGRESO DE DETALLE SOLICITUD*****
            foreach ($suceso_origen as $so) {
                $su_or = explode("#", $so);
                $suceso =  $su_or[0]; // suceso
                $origen =  $su_or[1]; // origen
                $datos_solicitud_suceso = array(
                    'suceso_cliente'  => $suceso,
                    'edmu' => 5, //sin definir
                    'origen' => $origen,
                    'suceso' => $suceso,
                    'solicitud' => $id_solicitud,
                    'estado' => 10 
                );
                var_dump($datos_solicitud_suceso);
                $data = $datos_solicitud_suceso;
                $url = $this->api_sacpv . 'solicitud_suceso';
                $metodo = 'POST';
                $datos_suceso = setCurl($url, $metodo, $data);
            }
            // *****INGRESAR HISTORIAL DE SOLICITUD*****
            $historial_solicitud = array(
                'solicitud'  => $id_solicitud,
                'estado' => 1,
                'usuario' => $id_cliente,
                'fecha' => date('Y-m-d')
            );
            $data = $historial_solicitud;
            $url = $this->api_sacpv . 'solicitud_historial';
            $metodo = 'POST';
            $datos_historial = setCurl($url, $metodo, $data);
            $this->enviar_correo_solicitud($id_solicitud, $rut_cliente, $comentario);
            $this->session->set_flashdata('mensaje', 'Su solicitud fue ingresada correctamente con el número '.$id_solicitud);
            header("Location: ".base_url()."ctrl_cliente/solicitud");
        }
        else {
            $id_solicitud_pendiente = 0; 
            foreach ($informacion['solicitudes'] as $s) {
                if ($s->id_estado == 1 and $s->id_vivienda == $vivienda_afectada) {
                    $id_solicitud_pendiente = $s->id_solicitud;
                    break;
                }
            }
            if ($id_solicitud_pendiente != 0) { //SI EXISTE UNA SOLICITUD PENDIENTE, SE AÑADIRAN LOS SUCESOS A ESA
                //*****INGRESO DE DETALLE SOLICITUD*****
                foreach ($suceso_origen as $so) {
                    $su_or = explode("#", $so);
                    $suceso =  $su_or[0]; // suceso
                    $origen =  $su_or[1]; // origen
                    $datos_solicitud_suceso = array(
                        'suceso_cliente'  => $suceso,
                        'edmu' => 5, //sin definir
                        'origen' => $origen,
                        'suceso' => $suceso,
                        'solicitud' => $id_solicitud_pendiente,
                        'estado' => 10 //verificar una vez se tengan todos los estados
                    );
                    $data = $datos_solicitud_suceso;
                    $url = $this->api_sacpv . 'solicitud_suceso';
                    $metodo = 'POST';
                    $datos_suceso = setCurl($url, $metodo, $data);
                }
                $this->enviar_correo_solicitud($id_solicitud_pendiente, $rut_cliente, $comentario);
                $this->session->set_flashdata('mensaje', 'Tiene una solicitud pendiente, los sucesos indicados fueron añadidos a su solicitud número '.$id_solicitud_pendiente);
                header("Location: ".base_url()."ctrl_cliente/solicitud");
            }
            else { //SINO, SE INGRESA NORMALMENTE
                //*****INGRESO DE SOLICITUD*****
                $datos_solicitud = array(
                    'comentario_cliente'  => $comentario,
                    'id_vivienda' => $vivienda_afectada,
                    'id_cliente' => $id_cliente,
                    'id_supervisor' => "",
                    'id_callcenter' => "",
                    'fecha_visita' => "",
                    'hora_visita' => "",
                    'tipo_trabajo' => 1,
                    'estado' => 1 
                );
                $data = $datos_solicitud;
                $url = $this->api_sacpv . 'solicitudes';
                $metodo = 'POST';
                $datos = setCurl($url, $metodo, $data);
                $datos = json_decode($datos);
                $info["insercion"] = $datos->datos;
                $id_solicitud = $info["insercion"]->id;
                //*****INGRESO DE DETALLE SOLICITUD*****
                foreach ($suceso_origen as $so) {
                    $su_or = explode("#", $so);
                    $suceso =  $su_or[0]; // suceso
                    $origen =  $su_or[1]; // origen
                    $datos_solicitud_suceso = array(
                        'suceso_cliente'  => $suceso,
                        'edmu' => 5, //sin definir
                        'origen' => $origen,
                        'suceso' => $suceso,
                        'solicitud' => $id_solicitud,
                        'estado' => 10 //verificar una vez se tengan todos los estados
                    );
                    $data = $datos_solicitud_suceso;
                    $url = $this->api_sacpv . 'solicitud_suceso';
                    $metodo = 'POST';
                    $datos_suceso = setCurl($url, $metodo, $data);
                }
                //*****INGRESAR HISTORIAL DE SOLICITUD*****
                $historial_solicitud = array(
                    'solicitud'  => $id_solicitud,
                    'estado' => 1,
                    'usuario' => $id_cliente,
                    'fecha' => date('Y-m-d')
                );
                $data = $historial_solicitud;
                $url = $this->api_sacpv . 'solicitud_historial';
                $metodo = 'POST';
                $datos_historial = setCurl($url, $metodo, $data);
                $this->enviar_correo_solicitud($id_solicitud, $rut_cliente, $comentario);
                $this->session->set_flashdata('mensaje', 'Su solicitud fue ingresada correctamente con el número '.$id_solicitud);
                header("Location: ".base_url()."ctrl_cliente/solicitud");
            }
        }
    }
    public function actualizar_datos_cliente() {
        $id_cliente = $this->input->post("id_cliente");
        $rut_cliente = $this->input->post("rut_cliente");
        $nombre_cliente = $this->input->post("nombre_cliente");
        $telefono_cliente = $this->input->post("telefono_cliente");
        $correo_cliente = $this->input->post("correo_cliente");
        $direccion_cliente = $this->input->post("direccion_cliente");
        
        $datos_actualizar = array(
            'clienteRut' => $rut_cliente,
            'clienteCorreo' => $correo_cliente,
            'clienteNombre' => $nombre_cliente,
            'clienteTelefono' => $telefono_cliente,
            'clienteDireccion' => $direccion_cliente
        );
        $data= $datos_actualizar;
        $url = $this->api_maestra . 'clientes/'.$id_cliente;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
    }
    private function enviar_correo_solicitud($cod_solicitud, $rut_cliente, $comentario) {
    	$rut = $rut_cliente;
        $data[] = '';
        $url = $this->api_maestra . "clientes/$rut";
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
                          <tr>
                            <td height="40" style="font-size:12px;" align="center"></td>
                          </tr>
                          <tr>
                            <td>
                              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tbody>
                                  <tr>
                                    <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0">
                                      <!-- inicio contenido -->
                                      <img src="'.base_url().'assets/img/malpo.png" width="600" alt="summer‘s coming trimm your sheeps" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                      <p style="margin:0 30px 33px;; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">Solicitud de Atención Nº '.$cod_solicitud.'
                                      </p>
                                      <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.', su solicitud fue recibida correctamente
                                      </p>
                                      <!-- inicio articulos -->
                                      <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody>
                                          <tr valign="top">
                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          </tr>
                                          <tr valign="top">
                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p>
                                            </td>
                                            <td colspan="3">
                                              <hr>
                                              <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;"></p>
                                              <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;">Rut Cliente: '.$rut_cliente.'</p>
                                              <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;">Fecha de la Solicitud: '.date('d-m-Y').'</p>
                                              <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;">Observación: '.$comentario.'</p>
                                              <p style="font-size: 13px;text-align: center;"><strong>* Para mayor detalle de su solicitud, dirigirse <a href="https://www.innovamalpo.cl/Comercial/POSTVENTA/ctrl_cliente" target="_blank" style="color:#3399cc; text-decoration:none; font-weight:bold;">Aquí</a></strong></p>
                                            </td>
                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!-- /fin articulos -->
                                      <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                      </table>
                                      <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#DDDDDD">
                                        <tbody>
                                          <tr valign="top">
                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="400">
                                              <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">Constructora e Inmobiliaria Malpo</p>
                                              <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">Contácto Post Venta 6008183000-(71)2233397<br>
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
                                      <!-- fin contenido --> 
                                      <table style="margin:0; font-size:5px; line-height:5px;" bgcolor="#DDDDDD" width="600" cellpadding="0" cellspacing="0"><tr><td height="30">&nbsp;</td></tr>
                                      </table>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- end main block -->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </body>
            </html>';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $correo = "servicioalcliente@malpo.cl";
        $destinatarios = array($correo, $cliente_correo);//AGREGAR CORREO CORPORATIVO
        $this->email->to($destinatarios);
        $this->email->from('servicioalcliente@malpo.cl','Servicio al cliente Malpo');
        $this->email->subject('Solicitud de Post-Venta');
        $this->email->message($htmlContent);
        // if ($cliente_correo == "msegura@malpo.cl") {
           
        // }
        // else {
            $this->email->send();
        // }
    }
}
