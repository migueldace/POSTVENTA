<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_clientes extends CI_Controller
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
        $this->template->set('titulo', 'Clientes Admin');
        $menu = menu(1, 9);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/clientes_view');
    }

    public function ListarTabla()
    {
        $data[] = '';
        $url = API_MAESTRA . 'clientes';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    public function nuevoRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;

        $data_vivienda[] = '';
        $url = API_UNYSOFT . 'viviendas/viviendas_por_cliente/' . $data->clienteRut;
        $metodo = 'GET';
        $viviendas = setCurl($url, $metodo, $data_vivienda);
        $url = API_MAESTRA . 'clientes';
        $metodo = 'POST';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
        if ($viviendas != '') {

            foreach (json_decode($viviendas) as $value) {

                $data_insertar = array(
                    'viviendaUnysoft' => $value->cod_vivienda,
                    'viviendaClienterut' => $value->rut_cliente,
                    'viviendaProyecto' => $value->cod_proyecto,
                    'viviendaDireccion' => $value->uniDireccion,
                    'viviendaFecharecepcion' => $value->fecha_rmo,
                    'viviendaTipo' => $value->tipo_vivienda,
                    'viviendaModelo' => $value->modelo_vivienda,
                    'viviendaArrendatario' => 0,
                    'viviendaNombreAr' => '',
                    'viviendaTelefonoAr' => '',
                    'viviendaCorreoAr' => '',
                );
                $url = API_MAESTRA . 'viviendas';
                $metodo = 'POST';
                setCurl($url, $metodo, $data_insertar);
                // echo $datos;
            }
        }

        
    }

    public function editarRegistro()
    {
        $data = $this->datosFormulario();
        $data = (object) $data;
        $url = API_MAESTRA . 'clientes/' . $data->idcliente;
        $metodo = 'PUT';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }

    private function datosFormulario()
    {
        return array(
            'idcliente' => $this->input->post('idcliente'),
            'clienteRut' => strtoupper($this->input->post('clienteRut')),
            'clienteCorreo' => $this->input->post('clienteCorreo'),
            'clienteNombre' => $this->input->post('clienteNombre'),
            'clienteTelefono' => $this->input->post('clienteTelefono'),
            'clienteDireccion' => $this->input->post('clienteDireccion')
        );
    }

    public function buscarRut()
    {
        $data[] = '';
        $url = API_UNYSOFT . 'clientes/cliente/' . $this->input->post('rut');
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }
}
