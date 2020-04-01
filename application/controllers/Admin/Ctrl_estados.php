<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_estados extends CI_Controller
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
        $this->template->set('titulo', 'Estados Admin');
        $menu = menu(1, 8);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/estados_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'estados';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'estados';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'estados/' . $data->id_estado;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_estado' => $this->input->post('id_estado'),
            'estado' => strtoupper($this->input->post('estado')),
            'categoria_estado' => $this->input->post('categoria_estado')            
        );
    }
}
