<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function setCurl($url,$metodo, $parametros){
	$ch = curl_init($url);   
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($parametros));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: MASTER")); #la clave de la api que esta en la bdd
	$response = curl_exec($ch);
	curl_close($ch);
	if(!$response) {
		return false;
	}else{
		return $response;
	}
}