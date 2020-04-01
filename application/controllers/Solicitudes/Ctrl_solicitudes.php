<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_solicitudes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
        // $this->validar();
    }

    public function ingresadas()
    {
        $this->template->set('titulo', 'Solicitudes Ingresadas');
        $menu = menu(4, 41);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitudes_ingresadas_view');
    }

    public function asignadas()
    {
        $this->template->set('titulo', 'Solicitudes Asignadas');
        $menu = menu(4, 42);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitudes_asignadas_view');
    }

    public function supervision()
    {
        $this->template->set('titulo', 'Solicitudes en Supervisión');
        $menu = menu(4, 43);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitudes_supervision_view');
    }

    public function proceso()
    {
        $this->template->set('titulo', 'Solicitudes en Proceso');
        $menu = menu(4, 44);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitudes_proceso_view');
    }

    public function finalizadas()
    {
        $this->template->set('titulo', 'Solicitudes Finalizadas');
        $menu = menu(4, 45);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitudes_finalizadas_view');
    }

    public function rechazadasCallcenter()
    {
        $this->template->set('titulo', 'Rechazadas CallCenter');
        $menu = menu(4, 46);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/rechazadas_callcenter_view');
    }

    public function rechazadasSupervisor()
    {
        $this->template->set('titulo', 'Rechazadas Supervisor');
        $menu = menu(4, 47);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/rechazadas_supervisor_view');
    }

    public function detalle()
    {        
        $this->template->set('titulo', 'Detalle Solicitud');
        $menu = menu();
        $this->template->set('menu', $menu);
        $this->template->load_template1('Solicitudes/solicitud_detalle_view');
    }  
    
    public function obtenerDetalle()
    {
        $data[] = '';
        $url = API_SACPV . 'solicitud_detalle/'. $this->input->post('id');'';
        $metodo = 'GET';
        $datos = setCurl($url, $metodo, $data);
        echo $datos;
    }
}
