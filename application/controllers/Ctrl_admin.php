<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctrl_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('api_sesion');
        $this->load->helpers('webservice');
        $this->load->helpers('menu');
        //$this->validar();
    }

    public function validar()
    {
        if (!sesion()) :
            redirect('inicio/error_sesion');
        endif;
    }    

    public function inicio()
    {       
        $this->template->set('titulo', 'Inicio Admin'); 
        $menu = menu(1, 1);
        $this->template->set('menu', $menu);
        $this->template->load_template1('Admin/inicio_view');
    }
    
}
