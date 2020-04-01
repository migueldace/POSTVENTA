<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_origenes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
    }

    public function index()
    {
        $this->template->set('titulo', 'Origenes Admin');
        $menu = menu(1, 5);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/origenes_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'origenes';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'origenes';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'origenes/' . $data->id_origen;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_origen' => $this->input->post('id_origen'),
            'origen' => strtoupper($this->input->post('origen')),           
            'estado' => $this->input->post('estado')
        );
    }
}
