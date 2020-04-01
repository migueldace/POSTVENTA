<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
		
		#establecer variables en la plantilla
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}
	
		#load principal, carga los datos como template
		function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
		{               
			$this->CI =& get_instance();
			$this->cargar_plataformas();
			$this->set('contenido', $this->CI->load->view($view, $view_data, TRUE));	
			return $this->CI->load->view($template, $this->template_data, $return);
		}

		#cargar menú  de plataformas
		function cargar_plataformas(){
			$this->CI =& get_instance();
			$this->CI->load->helper('api_sesion');
			$plataformas = _plataformas();
			$this->set('_menu', $plataformas);
		}

		# =======================CARGA DE TEMPLATES =============================

		//Para cargar template 
		function load_templateDinamico($view = '', $view_data = array(), $return = FALSE)
		{			
			$this->load('layout/template_dinamico', $view, $view_data, $return);
		}

		//Para cargar template 1
		function load_template1($view = '', $view_data = array(), $return = FALSE)
		{			
			$this->load('layout/template1', $view, $view_data, $return);
		}

		//Para cargar template 2
		function load_template2($view = '', $view_data = array(), $return = FALSE)
		{			
			$this->load('layout/menu', $view, $view_data, $return);
		}

		




}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */