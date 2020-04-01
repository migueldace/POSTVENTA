<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_categorias extends CI_Controller
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
        $this->template->set('titulo', 'Categorias Admin');
        $menu = menu(1, 1);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/categorias_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'categorias';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'categorias';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'categorias/' . $data->id_categoria;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_categoria' => $this->input->post('id_categoria'),
            'categoria' => strtoupper($this->input->post('categoria')),
            'garantia' => $this->input->post('garantia'),
            'estado' => $this->input->post('estado')
        );
    }
}
