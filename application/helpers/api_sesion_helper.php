<?php 
	#Validación de Sesión a través de API REST
	#Parámetro a enviar es el token de acceso de la sesión actual
	function sesion(){

		$CI =& get_instance();
		if(!$CI->session->userdata('is_logged')){
			return false;
		}else{

			$data['token'] = $_SESSION['token'];
			$data['idplataforma'] = ID_PLATAFORMA;
			$url = API_MAESTRA.'sesion';

			$ch = curl_init($url);   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: master"));
			$response = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($response);

			if ($response->estatus!=200){			
				return false;
			}else{
				return true;
			}
		}

	}

	#Función para cargar menú de plataformas de usuario
	function _plataformas(){
			$data=[];
			$CI =& get_instance();
			$url = API_MAESTRA.'usuario_deptos_plataformas/'.$CI->session->userdata('idusuario');
			$ch = curl_init($url);   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: master"));
			$response = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($response);


			if ($response->estatus==200){
				$data=$response->datos;
			}

			return $data;
		

	}


 ?>