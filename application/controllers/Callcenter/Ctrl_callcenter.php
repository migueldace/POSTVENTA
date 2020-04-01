<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_callcenter extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
        $this->api_maestra = API_MAESTRA;
        $this->api_sacpv = API_SACPV;
    }
    public function inicio()
    {       
        $this->template->set('titulo', 'Inicio Call-center'); 
        $menu = menu(3, 30);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Callcenter/inicio');
    }
    public function solicitud() {
        $this->template->set('titulo', 'Solicitud Post-Venta'); 
        $menu = menu(3, 31);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Callcenter/solicitud'); 
    }
    public function datos_solicitud() {
        $rut_cliente = $this->input->post("rut_cliente");
        //FORMATEAR RUT
        if (strlen($rut_cliente) == 8) { //SI ES RUT DE 8 DIGITOS
            $parte1 = substr($rut_cliente, 0,1);
            $parte2 = substr($rut_cliente, 1,3);
            $parte3 = substr($rut_cliente, 4,3);
            $parte4 = substr($rut_cliente, 7,1);
            $rut_formateado = $parte1.".".$parte2.".".$parte3."-".$parte4;
        }
        else if(strlen($rut_cliente) == 9) {
            $parte1 = substr($rut_cliente, 0,2);
            $parte2 = substr($rut_cliente, 2,3);
            $parte3 = substr($rut_cliente, 5,3);
            $parte4 = substr($rut_cliente, 8,1);
            $rut_formateado = $parte1.".".$parte2.".".$parte3."-".$parte4;
        }
        //*****API CLIENTE*****
        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_formateado;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        // echo $datos;
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        // var_dump($datos);
        if ($informacion['cliente'] == NULL) {
            echo "<h1>No se encontrarón datos para el rut ingresado, verifique e intente nuevamente!</h1>";
        }
        // var_dump($datos->datos);
        else {
            //*****API VIVIENDA CLIENTE*****
            $data2[] = '';
            $url2 = $this->api_maestra . 'viviendas/'.$rut_formateado;
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
            foreach ($informacion['cliente'] as $cli) {
                $idcliente = $cli->idcliente;
                break;
            }
            $data7[] = '';
            $url7 = $this->api_sacpv . 'solicitudes/'.$idcliente;
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
            $this->load->view('Callcenter/solicitud_cuerpo', $informacion);
        }
    }
    public function ingresar_solicitud() {
        $usuario_rut = $this->input->post("mi_rut");
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
            var_dump($datos_solicitud);
            $data = $datos_solicitud;
            $url = $this->api_sacpv . 'solicitudes';
            $metodo = 'POST';
            $datos_insercion = setCurl($url, $metodo, $data);
            $datos_insercion = json_decode($datos_insercion);
            $info["insercion"] = $datos_insercion->datos;
            // var_dump($datos_insercion);
            $id_solicitud = $info["insercion"]->id;
            // echo $id_solicitud;
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
            // var_dump($historial_solicitud);
            $data = $historial_solicitud;
            $url = $this->api_sacpv . 'solicitud_historial';
            $metodo = 'POST';
            $datos_historial = setCurl($url, $metodo, $data);
            $this->enviar_correo_solicitud($id_solicitud, $usuario_rut, $comentario);
            $this->session->set_flashdata('mensaje', 'La solicitud fue ingresada correctamente con el número '.$id_solicitud);
            header("Location: ".base_url()."Callcenter/ctrl_callcenter/solicitud");
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
                $this->enviar_correo_solicitud($id_solicitud_pendiente, $usuario_rut, $comentario);
                $this->session->set_flashdata('mensaje', 'Existe una solicitud pendiente para este cliente, los sucesos indicados fueron añadidos a su solicitud número '.$id_solicitud_pendiente);
                header("Location: ".base_url()."Callcenter/ctrl_callcenter/solicitud");
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
                $this->enviar_correo_solicitud($id_solicitud, $usuario_rut, $comentario);
                $this->session->set_flashdata('mensaje', 'La solicitud fue ingresada correctamente con el número '.$id_solicitud);
                header("Location: ".base_url()."Callcenter/ctrl_callcenter/solicitud");
            }
        }
    }
    public function reagendar_contratista() {
        $id_solicitud = $this->input->post("id_solicitud");
        $informacion['id_solicitud'] = $id_solicitud;
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
        //*****API CONTRATISTAS*****
        $url = $this->api_maestra . 'usuario_perfil/19';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratistas'] = $datos->datos;
        $informacion['partidas_suceso'] = $array_respuesta;
        $this->load->view('Solicitudes/modal_resumen_callcenter', $informacion);
    }
    public function actualizar_partida() {
        $id_suceso_partida = $this->input->post("id_suceso_partida");
        $contratista = $this->input->post("contratista");
        $fecha = $this->input->post("fecha");
        $hora = $this->input->post("hora");
        $fecha_hora = $fecha." ".$hora;
        //API SUCESO PARTIDA
        $datos_partida = array(
            'unidad_medida' => "",
            'fecha_inicio' => $fecha_hora,
            'fecha_termino' => "",
            'dias_trabajo' => "",
            'id_contratista' => $contratista,
            'partidas' => "",
            'estado' => "",
            'solicitud_suceso' => "",
            'precio_adicional' => "",
            'justificacion' => ""
        );
        $data= $datos_partida;
        $url = $this->api_sacpv . 'suceso_partidas/'.$id_suceso_partida;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
    }


// CORREOS
    private function enviar_correo_solicitud($cod_solicitud, $rut_cliente, $comentario) {
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
                                      <img src="'.base_url().'assets/img/malpo.png" width="600" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
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
                                              <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;">Rut Cliente: '.$cliente_rut.'</p>
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
        $this->email->send();
        // echo $htmlContent;
    }
    public function correo_de_asignacion() { //$cod_solicitud, $id_inspector, $rut_cliente, $fecha_inspeccion
        $cod_solicitud = $this->input->post("id_solicitud");
        $rut_cliente = $this->input->post("rut_cliente");
        $id_inspector = $this->input->post("id_supervisor");
        $fecha_visita = $this->input->post("fecha_visita");
        $hora_visita = $this->input->post("hora_visita");
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
        $url = $this->api_maestra . 'usuario_perfil/9';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['supervisores'] = $datos->datos;
        foreach ($informacion['supervisores'] as $sup) {
            if ($sup->idusuario == $id_inspector) {
                $nombre_inspector = $sup->usuarioNombre;
                break;
            }
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
                                        Asignación de Inspector para su Solicitud Nº '.$cod_solicitud.'
                                    </p>
                                    <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.', <br>se ha asignado un inspector para una proxima visita en su vivienda
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
                                            <p style="font-size:14px; line-height:22px; font-weight:bold; color:#333333; margin:0 0 5px;"><b>DATOS INSPECTOR:</b>
                                            </p>
                                            <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Nombre Inspector:</b> '.$nombre_inspector.'</p>
                                            <p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Fecha Visita:</b> '.date("d/m/Y", strtotime($fecha_visita)).' '.date("h:i A", strtotime($hora_visita)).'</p>
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
        $this->email->subject('Visita de inspección POST-VENTA');
        $this->email->message($htmlContent);
        $this->email->send();
    }
}