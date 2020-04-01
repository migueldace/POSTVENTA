<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_obtener extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
    }

    function ObtenerActivos()
    {
        $data[] = '';
        $url = API_SACPV . 'obtener_activos/' . $this->input->post('tabla');
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    function SolicitudesEstados()
    {
        $data[] = '';

        $estado = $this->input->post('estado');
        $perfil = $_SESSION['id_perfil'];
        $usuario = $_SESSION['idusuario'];

        $url = API_SACPV . 'solicitudes_estados/' . $estado . '/' . $perfil . '/' . $usuario . '';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    function obtenerSupervisores()
    {
        $data[] = '';
        $url = API_SACPV . 'supervisores/listado';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function buscarAgendaSupervisor()
    {
        $data = array(
            'id_supervisor' => $this->input->post('id_supervisor'),
            'fecha_visita' => $this->input->post('fecha_visita')
        );
        $url = API_SACPV . 'supervisores/agenda';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function agendarSupervisor()
    {
        $cod_solicitud = $this->input->post('id_solicitud');
        $rut_cliente = $this->input->post('rut_cliente');
        $id_inspector = $this->input->post('id_supervisor');
        $fecha_visita = $this->input->post('fecha_visita');
        $hora_visita = $this->input->post('hora_visita');
        // var_dump($cod_solicitud, $rut_cliente, $id_inspector, $fecha_visita, $hora_visita);
        $data = array(
            'id_solicitud' => $this->input->post('id_solicitud'),
            'id_supervisor' => $this->input->post('id_supervisor'),
            'id_callcenter' => $_SESSION['idusuario'],
            'fecha_visita' => $this->input->post('fecha_visita'),
            'hora_visita' => $this->input->post('hora_visita'),
            'estado' => 2,

            'solicitud' => $this->input->post('id_solicitud'),
            'estado' => 2,
            'usuario' => $_SESSION['idusuario'],
            'fecha' => FECHA
        );

        $url = API_SACPV . 'supervisores/agendar';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function calendarioSupervisores()
    {
        $data = array('id_supervisor' => $this->input->post('id_supervisor'));
        $url = API_SACPV . 'supervisores/calendario';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function actualizarAgenda()
    {
        $data = array(
            'id_solicitud' => $this->input->post('id_solicitud'),           
            'fecha_visita' => $this->input->post('fecha_visita'),
            'hora_visita' => $this->input->post('hora_visita'),           
        );
        $url = API_SACPV . 'supervisores/actualizar_agenda';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }
    
    public function obtenerContratistas()
    {
        $data[] = '';
        $url = API_SACPV . 'contratistas/listado';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function calendarioContratistas()
    {
        $data = array('id_contratista' => $this->input->post('id_contratista'));
        $url = API_SACPV . 'contratistas/calendario';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function sucesosContratista()
    {
        $data = array('id_solicitud' => $this->input->post('id_solicitud'));
        $url = API_SACPV . 'contratistas/sucesos';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function actualizarContratista()
    {
        $data = array(
            'id_suceso_partidas' => $this->input->post('id_suceso_partidas'),  
            'id_contratista' => $this->input->post('id_contratista'),         
            'fecha_inicio' => $this->input->post('fecha_inicio'),                     
        );
        $url = API_SACPV . 'contratistas/actualizar_agenda';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function agendarContratistas()
    {
        $id_solicitud = $this->input->post('id_solicitud');
        $rut_cliente = $this->input->post('rut_cliente');
        $data = array(
            'solicitud' => $this->input->post('id_solicitud'),
            'estado' => 4,
            'usuario' => $_SESSION['idusuario'],
            'fecha' => FECHA
        );

        $url = API_SACPV . 'contratistas/agendar';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        $this->correo_confirmacion_contratistas($id_solicitud, $rut_cliente);
        echo $datos;
    }

    //CORREO DE ASIGNACION
    public function correo_de_asignacion() {
        $cod_solicitud = $this->input->post('id_solicitud');
        $rut_cliente = $this->input->post('rut_cliente');
        $id_inspector = $this->input->post('id_supervisor');
        $fecha_visita = $this->input->post('fecha_visita');
        $hora_visita = $this->input->post('hora_visita');

        $data[] = '';
        $url = $this->api_maestra . 'clientes/'.$rut_cliente;
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        $datos = json_decode($datos);
        $informacion['cliente'] = $datos->datos;
        $nombre_inspector = $cliente_rut = $cliente_correo = $cliente_nombre = "";
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
                                    <center><p style="margin:0 0 10px; font-size:14px; line-height:18px; color:#333333;"><b>Las fechas están sujetas a cambios con previo aviso.</b></p></center>
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
        // echo $htmlContent;
    }
}
