<?php
class modelo extends CI_Model 
{ 
	public function __construct() 
	{
	    parent::__construct();
	}
	function ingresar_solicitud($data) {
      $this->db->insert('solicitudes', $data);
      return $this->db->insert_id();
    }
    function ingresar_solicitud_suceso($data) {
      $this->db->insert('solicitud_sucesos', $data);
      return $this->db->insert_id();
    }
    function ingresar_historial_solicitud($data) {
      $this->db->insert('estados_solicitud', $data);
      return $this->db->insert_id();
    }
}