<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_tipo_trabajo extends CI_Controller
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
        $this->template->set('titulo', 'Tipo de Trabajo Admin');
        $menu = menu(1, 7);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/tipo_trabajo_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'tipo_trabajo';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'tipo_trabajo';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'tipo_trabajo/' . $data->id_tipo_trabajo;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_tipo_trabajo' => $this->input->post('id_tipo_trabajo'),
            'tipo_trabajo' => strtoupper($this->input->post('tipo_trabajo')),            
            'estado' => $this->input->post('estado')
        );
    }
}
