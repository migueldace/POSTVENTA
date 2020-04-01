<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_calendarios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
    }

    public function calendario_supervisores()
    {
        $this->template->set('titulo', 'Calendario S');
        $menu = menu(3, 32);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Callcenter/calendario_supervisores_view');
    }

    public function calendario_contratistas()
    {
        $this->template->set('titulo', 'Calendario C' );
        $menu = menu(3, 33);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Callcenter/calendario_contratistas_view');
    }
}