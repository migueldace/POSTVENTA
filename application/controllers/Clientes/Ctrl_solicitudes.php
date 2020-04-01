<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_solicitudes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
    }

    public function index()
    {
        // $usuario_data = array(
        //     'id_cliente' => 1,
        //     'rutcliente' => '18.343.605-8',
        //     'nombre' => 'Miguel Segura',
        //     'email' => 'msegura@malpo.cl',
        //     'logueado' => TRUE
        // );
        // $this->session->set_userdata($usuario_data);

        $this->templatecliente->set('titulo', 'Solicitudes Clientes');
        $menu = menu(2, 23);
        $this->templatecliente->set('menu', $menu);
        $this->templatecliente->load_template2('Cliente/solicitudes_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'solicitudes/'.$this->input->post('id');
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function Sucesos()
    {
        $data[] = '';
        $url = API_SACPV . 'solicitud_suceso/'.$this->input->post('id');
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function Historial()
    {
        $data[] = '';
        $url = API_SACPV . 'solicitud_historial/'.$this->input->post('id');
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }
}
