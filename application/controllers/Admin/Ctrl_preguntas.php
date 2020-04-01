<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_preguntas extends CI_Controller
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
        $this->template->set('titulo', 'Encuentas Admin');
        $menu = menu(1, 4);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/preguntas_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_SACPV . 'preguntas';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_SACPV . 'preguntas';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_SACPV . 'preguntas/' . $data->id_pregunta;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'id_pregunta' => $this->input->post('id_pregunta'),
            'pregunta' => strtoupper($this->input->post('pregunta')),
            'tipo_pregunta' => strtoupper($this->input->post('tipo_pregunta')),
            'estado' => $this->input->post('estado')
        );
    }
}
