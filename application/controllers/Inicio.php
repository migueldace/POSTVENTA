<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* clase inicial para controlar login  
*/
class Inicio extends CI_Controller
{

	public function index()
	{	
		
		$CI =& get_instance();
		$usuario = $CI->session->userdata('is_logged');
	    if (!isset($usuario)){ #comprobar sesión 
	    	$this->error_sesion();
	    }else{
	    	//sesión iniciada correctamente
	    	//echo "hsdfjh";
	    	redirect('Ctrl_inicio/ingreso_plataforma');
		}

		print_r($CI->session->userdata());
	}

	//Error 401
	public function error_sesion(){
		$data=[];
		$this->load->view('layout/_401', $data, FALSE);
	}

	//Error 403
	public function error_perfil(){
		$data=[];
		$this->load->view('layout/_403', $data, FALSE);
	}

}
?>