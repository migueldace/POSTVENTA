<?php
defined('BASEPATH') or exit('No direct script access allowed');

function menu($id = '', $ids = '')
{
	$menu = array();

	$menu[] = array(
		"id" => 1,
		"ctrl" => "ctrl_Admin/inicio",
		"nombre" => "Admin",
		"icono" => "fa fa-home",
		"activo" => FALSE,
		"submenu" => submenu(2, $ids)
	);
	// CLIENTE
	$menu[] = array(
		"id" => 2,
		"ctrl" => "ctrl_cliente/inicio",
		"nombre" => "Menú",
		"icono" => "fa fa-home",
		"activo" => FALSE,
		"submenu" => submenu(1, $ids)
	);
	//CALLCENTER
	$menu[] = array(
		"id" => 3,
		"ctrl" => "callcenter/ctrl_callcenter/inicio",
		"nombre" => "Call-Center",
		"icono" => "fa fa-home",
		"activo" => FALSE,
		"submenu" => submenu(3, $ids)
	);

	//SOLICITUDES
	$menu[] = array(
		"id" => 4,
		"ctrl" => "solicitudes/ctrl_solicitudes/ingresadas",
		"nombre" => "Solicitudes",
		"icono" => "fa fa-clipboard",
		"activo" => FALSE,
		"submenu" => submenu(4, $ids)
	);
	//EEPP
	$menu[] = array(
		"id" => 5,
		"ctrl" => "EEPP/ctrl_eepp",
		"nombre" => "Estados de Pago",
		"icono" => "ft ft-book",
		"activo" => FALSE,
		"submenu" => submenu(6, $ids)
	);
	//CALENDARIOS
	$menu[] = array(
		"id" => 6,
		"ctrl" => "EEPP/ctrl_eepp",
		"nombre" => "Calendarios",
		"icono" => "ft ft-calendar",
		"activo" => FALSE,
		"submenu" => submenu(7, $ids)
	);


	for ($i = 0; $i < count($menu); $i++) {
		if ($menu[$i]['id'] == $id) {
			$menu[$i]["activo"] = TRUE;
			break;
		}
	}
	if (isset($_SESSION["id_perfil"])) { //SI EXISTE LA VARIABLE SESSION
		if ($_SESSION["id_perfil"]== 2) { //SI ES ADMIN MAESTRO
			unset($menu[1]); //CLIENTE
		}
		else if ($_SESSION["id_perfil"]== 16) { //SI ES CALLCENTER, NO LE MUESTRO EL MENU ADMIN, NI CLIENTE
			unset($menu[0]); //MENU ADMIN
			unset($menu[1]); //CLIENTE
			unset($menu[4]); //EEPP
			unset($menu[5]); //CALENDARIOS
		}
		else if ($_SESSION["id_perfil"]== 18) { //ADMINISTRATIVO
			unset($menu[1]); //CLIENTE
			unset($menu[5]); //CALENDARIOS
		}
		else if ($_SESSION["id_perfil"]== 9) { //SI ES SUPERVISOR, NO LE MUESTRO EL MENU ADMIN, NI CLIENTE, NI CALLCENTER
			unset($menu[0]); //ADMIN 
			unset($menu[1]); //CLIENTE
			unset($menu[2]); //CALLCENTER
		}
		else if ($_SESSION["id_perfil"]== 19) { //SI ES CONTRATISTA, NMO LE MUESTRO NI UNA WA
			unset($menu[0]); //ADMIN 
			unset($menu[1]); //CLIENTE
			unset($menu[2]); //CALLCENTER
			unset($menu[3]); //SOLICITUDES
			unset($menu[4]); //EEPP
		}
	}
	else { //SI ES CLIENTE, SE LE QUITA TODO MENOS SU PERFIL
		unset($menu[0]);//ADMIN
		unset($menu[2]);//CALLCENTER
		unset($menu[3]);//SOLICITUDES
		unset($menu[4]);//EEPP
		unset($menu[5]);//CALENDARIOS
	}
	return $menu;
}

function submenu($id, $ids = '')
{
	$submenu = array();
	if ($id == 2) {

		$submenu[] = array(
			"id" => 1,
			"ctrl" => "Admin/ctrl_categorias",
			"nombre" => "Categorias",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 2,
			"ctrl" => "Admin/ctrl_sucesos",
			"nombre" => "Sucesos",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 3,
			"ctrl" => "Admin/ctrl_partidas",
			"nombre" => "Partidas",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 4,
			"ctrl" => "Admin/ctrl_preguntas",
			"nombre" => "Encuestas",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 5,
			"ctrl" => "Admin/ctrl_origenes",
			"nombre" => "Tipos de Origen",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 6,
			"ctrl" => "Admin/ctrl_edmu",
			"nombre" => "Tipos de Edmu",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 7,
			"ctrl" => "Admin/ctrl_tipo_trabajo",
			"nombre" => "Tipos de Trabajo",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		// $submenu[] = array(
		// 	"id" => 8,
		// 	"ctrl" => "Admin/ctrl_estados",
		// 	"nombre" => "Estados",
		// 	"icono" => "ft ft-plus-circle",
		// 	"activo" => FALSE,
		// 	"submenu" => array()
		// );

		$submenu[] = array(
			"id" => 9,
			"ctrl" => "Admin/ctrl_clientes",
			"nombre" => "Clientes",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);
	} 
	else if ($id == 1) {
		// $submenu[] = array(
		// 	"id" => 21,
		// 	"ctrl" => "ctrl_cliente/inicio",
		// 	"nombre" => "Inicio",
		// 	"icono" => "ft ft-plus-circle",
		// 	"activo" => FALSE,
		// 	"submenu" => array()
		// );

		$submenu[] = array(
			"id" => 22,
			"ctrl" => "ctrl_cliente/solicitud",
			"nombre" => "Nueva Solicitud",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 23,
			"ctrl" => "Clientes/ctrl_solicitudes",
			"nombre" => "Mis Solicitudes",
			"icono" => "ft ft-edit",
			"activo" => FALSE,
			"submenu" => array()
		);
	} 
	else if ($id == 3) { //CALLCENTER
		
		$submenu[] = array(
			"id" => 31,
			"ctrl" => "Callcenter/ctrl_callcenter/solicitud",
			"nombre" => "Nueva Solicitud",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);
		$submenu[] = array(
            "id" => 32,
            "ctrl" => "Callcenter/ctrl_calendarios/calendario_supervisores",
            "nombre" => "Calendario S.",
            "icono" => "ft ft-calendar",
            "activo" => FALSE,
            "submenu" => array()
        );
 
        $submenu[] = array(
            "id" => 33,
            "ctrl" => "Callcenter/ctrl_calendarios/calendario_contratistas",
            "nombre" => "Calendario C.",
            "icono" => "ft ft-calendar",
            "activo" => FALSE,
            "submenu" => array()
        );
	}
	else if ($id == 4){ //SOLICITUDES
		$submenu[] = array(
			"id" => 41,
			"ctrl" => "Solicitudes/ctrl_solicitudes/ingresadas",
			"nombre" => "S. Ingresadas",
			"icono" => "ft ft-alert-triangle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 42,
			"ctrl" => "Solicitudes/ctrl_solicitudes/asignadas",
			"nombre" => "S. Asignadas",
			"icono" => "ft ft-check-square",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 43,
			"ctrl" => "Solicitudes/ctrl_solicitudes/supervision",
			"nombre" => "S. Inspeccionadas",
			"icono" => "ft ft-edit",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 44,
			"ctrl" => "Solicitudes/ctrl_solicitudes/proceso",
			"nombre" => "S. en Proceso",
			"icono" => "ft ft-play",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 45,
			"ctrl" => "Solicitudes/ctrl_solicitudes/finalizadas",
			"nombre" => "S. Finalizadas",
			"icono" => "ft ft-unlock",
			"activo" => FALSE,
			"submenu" => array()
		);
		// $submenu[] = array(
		// 	"id" => 46,
		// 	"ctrl" => "solicitudes/ctrl_solicitudes/rechazadasCallcenter",
		// 	"nombre" => "R. CallCenter",
		// 	"icono" => "ft ft-x-circle",
		// 	"activo" => FALSE,
		// 	"submenu" => array()
		// );

		$submenu[] = array(
			"id" => 47,
			"ctrl" => "Solicitudes/ctrl_solicitudes/rechazadasSupervisor",
			"nombre" => "R. Supervisor",
			"icono" => "ft ft-x-circle",
			"activo" => FALSE,
			"submenu" => array()
		);
		// if (isset($_SESSION["id_perfil"])) { //SI EXISTE LA VARIABLE SESSION
		// 	if ($_SESSION["id_perfil"]== 2) { //SI ES ADMIN MAESTRO
				
		// 	}
		// 	else if ($_SESSION["id_perfil"]== 16 or $_SESSION["id_perfil"]== 18) { //SI ES CALLCENTER 
		// 	}
		// 	else if ($_SESSION["id_perfil"]== 9) { //SI ES SUPERVISOR,
		// 		unset($submenu[0]); //SE SACA LAS INGRESADAS
		// 		unset($submenu[5]); //SE SACA LAS RECHAZADAS POR CALLCENTER
		// 	}
		// }
	}
	else if ($id == 5) { //SUPERVISOR
		$submenu[] = array(
			"id" => 50,
			"ctrl" => "solicitudes/ctrl_solicitudes/asignadas",
			"nombre" => "Mis inspecciones",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);

		$submenu[] = array(
			"id" => 51,
			"ctrl" => "Supervisor/ctrl_supervisor/mi_calendario",
			"nombre" => "Mi calendario",
			"icono" => "ft ft-plus-circle",
			"activo" => FALSE,
			"submenu" => array()
		);
	}
	else if ($id == 6) { //EEPP
		$submenu[] = array(
			"id" => 60,
			"ctrl" => "EEPP/ctrl_eepp/eepp_supervisor",
			"nombre" => "EEPP Inspector",
			"icono" => "fa fa-book",
			"activo" => FALSE,
			"submenu" => array()
		);
		$submenu[] = array(
			"id" => 61,
			"ctrl" => "EEPP/ctrl_eepp/listado_materiales",
			"nombre" => "Listado Materiales",
			"icono" => "fa fa-bath",
			"activo" => FALSE,
			"submenu" => array()
		);
		
	}
	else if ($id == 7) {
		if (isset($_SESSION["id_perfil"])) { //SI EXISTE LA VARIABLE SESSION
			if ($_SESSION["id_perfil"]!= 19) { //SI ES ADMIN MAESTRO
				$submenu[] = array(
		            "id" => 70,
		            "ctrl" => "Callcenter/ctrl_calendarios/calendario_supervisores",
		            "nombre" => "Mi calendario",
		            "icono" => "ft ft-calendar",
		            "activo" => FALSE,
		            "submenu" => array()
		        );
		        $submenu[] = array(
		            "id" => 71,
		            "ctrl" => "Callcenter/ctrl_calendarios/calendario_contratistas",
		            "nombre" => "Contratistas",
		            "icono" => "ft ft-calendar",
		            "activo" => FALSE,
		            "submenu" => array()
		        );
			}
			else {
				$submenu[] = array(
		            "id" => 71,
		            "ctrl" => "Callcenter/ctrl_calendarios/calendario_contratistas",
		            "nombre" => "Mi calendario",
		            "icono" => "ft ft-calendar",
		            "activo" => FALSE,
		            "submenu" => array()
		        );
			}
		}
		
        
	}
	for ($i = 0; $i < count($submenu); $i++) {
		if ($submenu[$i]['id'] == $ids) {
			$submenu[$i]["activo"] = TRUE;
			break;
		}
	}

	return $submenu;

}
