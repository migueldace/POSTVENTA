<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_partidas extends CI_Controller
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
        $this->template->set('titulo', 'Partidas Admin');
        $menu = menu(1, 3);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/partidas_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'partidas';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'partidas';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'partidas/' . $data->id_partida;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_partida' => $this->input->post('id_partida'),
            'partida' => strtoupper($this->input->post('partida')),
            'precio' => $this->input->post('precio'),
            'unidad' => $this->input->post('unidad'),
            'estado' => $this->input->post('estado'),
            'categoria' => $this->input->post('categoria')
        );
    }
}
