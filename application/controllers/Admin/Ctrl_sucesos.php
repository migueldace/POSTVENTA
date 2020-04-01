<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_sucesos extends CI_Controller
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
        $this->template->set('titulo', 'Sucesos Admin');
        $menu = menu(1, 2);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/sucesos_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'sucesos';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'sucesos';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'sucesos/' . $data->id_suceso;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_suceso' => $this->input->post('id_suceso'),
            'suceso' => strtoupper($this->input->post('suceso')),
            'prioridad' => $this->input->post('prioridad'),
            'estado' => $this->input->post('estado'),
            'categoria' => $this->input->post('categoria')
        );
    }
}
