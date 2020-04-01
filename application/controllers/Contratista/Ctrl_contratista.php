<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_contratista extends CI_Controller
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
    public function resumen_solicitud() {
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
        //*****API CONTRATISTAS*****
        $url = $this->api_maestra . 'usuario_perfil/19';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratistas'] = $datos->datos;
        $informacion['materiales_partidas'] = $array_materiales;
        $this->load->view('Solicitudes/modal_resumen_contratista', $informacion);
    }
    public function correo_confirmacion_contratistas($id_solicitud, $rut_cliente) {
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
        //*****API CONTRATISTAS*****
        $url = $this->api_maestra . 'usuario_perfil/19';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['contratistas'] = $datos->datos;
        //A******API CLIENTE****
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
        //****FORMAR TABLA CON SUCESOS*****
        $contador = 1;
        $datos_tabla = "";
        foreach ($informacion['sucesos'] as $s) {
            $id_solicitud_suceso = $s->id_solicitud_suceso;
            if ($s->id_estado == 12 or $s->id_estado == 13) { //si esta finalizado o pagado
            }
            else if ($s->id_estado == 14) { //RECHAZADO
            }
            else if ($s->id_estado == 11) { //PENDIENTE
                $datos_partidas = "";
                foreach ($informacion['partidas_suceso'] as $ps) {
                    if ($id_solicitud_suceso == $ps->id_solicitud_suceso) {
                        $nombre_contratista= "";
                        $id_contratista = $ps->contratista;
                        foreach ($informacion['contratistas'] as $c) {
                            if ($c->idusuario == $id_contratista) {
                                $nombre_contratista = "<span class='badge badge-primary'>$c->usuarioNombre</span>";
                                break;
                            }
                        }
                        if ($ps->id_estado == 20) {
                            $fecha_inicio = date('d-m-Y H:i A',strtotime($ps->fecha_inicio));
                            $datos_partidas .= "$nombre_contratista <span class='badge badge-primary'><br>Inicio: $fecha_inicio</span><br>";
                        }
                    }
                }
                $datos_tabla.= "<tr style='border: 1px solid black'>
                                    <td style='border: 1px solid black'>$s->suceso<br>$s->origen</td>
                                    <td style='border: 1px solid black'>$datos_partidas</td>
                                </tr>";
            }
        }
        //****FIN TABLA*****
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
                                        Asignación de equipos de trabajos para su Solicitud Nº '.$id_solicitud.'
                                    </p>
                                    <p style="text-align: center;font-size:14px; line-height:22px; font-weight:bold; color:#a02b3e; margin:0 0 5px;">Estimado(a) '.$cliente_nombre.', <br>se ha confirmado visitas para los equipos de trabajo en su vivienda.
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
                                            <h3><b>DATOS DE LOS EQUIPOS DE TRABAJO:</b>
                                            </h3>
                                            <div >
                                                <table style="border: 1px solid black">
                                                    <thead class="text-center"  style="border: 1px solid black">
                                                        <tr class="thead-dark"  style="border: 1px solid black">
                                                            <th style="width: 50%; border: 1px solid black">SUCESO - ORIGEN</th>
                                                            <th style="width: 50%; border: 1px solid black">CONTRATISTAS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="">'.$datos_tabla.'
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                          </td>
                                          <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <center><p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>LAS FECHAS ESTÁN SUJETAS A CAMBIOS CON PREVIO AVISO.</b></p></center>
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
        // $this->email->send();
        echo $htmlContent;
    }
}