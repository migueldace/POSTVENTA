<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_edmu extends CI_Controller
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
        $this->template->set('titulo', 'Edmu Admin');
        $menu = menu(1, 6);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/edmu_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'edmu';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'edmu';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'edmu/' . $data->id_edmu;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_edmu' => $this->input->post('id_edmu'),
            'edmu' => strtoupper($this->input->post('edmu')),
            'detalle' => strtoupper($this->input->post('detalle')),                  
            'estado' => $this->input->post('estado')
        );
    }
}
