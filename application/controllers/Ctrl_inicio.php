<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_inicio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->controller = API_MAESTRA;
		$this->load->helpers('webservice');
		$this->load->helpers('api_sesion');
		$this->master_login = MASTER_LOGIN;
		
	}

	public function index(){

		/* if (!sesion()):
	      redirect('inicio/error_perfil');
	    else:
	    	redirect('ctrl_admin/inicio');
		endif;
		*/

	     switch ($this->session->userdata('id_perfil')) {	
			#redireccionar segun perfil	
			case 2:#administrador de sistema
				redirect('ctrl_admin/inicio');
				break;
			case 9: #supervisor	
			// case 4: #los ao que seran supervisores
				redirect('Supervisor/ctrl_supervisor/inicio');
				break;
			case 16:#callcenter
				redirect('ctrl_admin/inicio');
				break;
			case 18:#administrativo postventa
				redirect('ctrl_admin/inicio');
				break;
			case 17:#JEFE postventa
				redirect('ctrl_admin/inicio');
				break;
			case 19:#contratista
				redirect('Callcenter/ctrl_calendarios/calendario_contratistas');
				break;
			default:
				redirect('inicio/error_perfil');
				break;
		}   

		
	}

	public function ingreso_plataforma()
	{
		$this->index();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		redirect(MASTER_LOGIN, 'refresh');
	}
}
