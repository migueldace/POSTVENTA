<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_viviendas extends CI_Controller
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
        $data['rut'] = $this->uri->segment(4);
        $this->template->set('titulo', 'Viviendas Admin');
        $menu = menu(1, 9);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/viviendas_view', $data);
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_MAESTRA . 'viviendas/' . $this->input->post('rut') . '';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $url = API_MAESTRA . 'viviendas';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_MAESTRA . 'viviendas/' . $data->idvivienda;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'idvivienda' => $this->input->post('idvivienda'),
            'viviendaUnysoft' => $this->input->post('viviendaUnysoft'),
            'viviendaClienterut' => $this->input->post('viviendaClienterut'),
            'viviendaProyecto' => $this->input->post('viviendaProyecto'),
            'viviendaDireccion' => $this->input->post('viviendaDireccion'),
            'viviendaFecharecepcion' => $this->input->post('viviendaFecharecepcion'),
            'viviendaTipo' => $this->input->post('viviendaTipo'),
            'viviendaModelo' => $this->input->post('viviendaModelo'),
            'viviendaArrendatario' => $this->input->post('viviendaArrendatario'),
            'viviendaNombreAr' => $this->input->post('viviendaNombreAr'),
            'viviendaTelefonoAr' => $this->input->post('viviendaTelefonoAr'),
            'viviendaCorreoAr' => $this->input->post('viviendaCorreoAr'),
        );
    }
}
