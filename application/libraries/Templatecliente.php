<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templatecliente {
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
			$this->set('contenido', $this->CI->load->view($view, $view_data, TRUE));	
			return $this->CI->load->view($template, $this->template_data, $return);
		}

		

		# =======================CARGA DE TEMPLATES =============================


		//Para cargar template del cliente
		function load_template2($view = '', $view_data = array(), $return = FALSE)
		{			
			$this->load('layout/template2', $view, $view_data, $return);
		}
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */