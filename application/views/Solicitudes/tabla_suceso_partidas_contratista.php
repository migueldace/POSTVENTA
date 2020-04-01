<?php  
$contador = 1;
$datos_tabla = "";
var_dump($materiales_partidas);
foreach ($sucesos as $s) {
	// var_dump($s);
	$id_solicitud_suceso = $s->id_solicitud_suceso;
	if ($s->id_estado == 12 or $s->id_estado == 13) { //si esta finalizado o pagado
		$datos_partidas = "";
		foreach ($partidas_suceso as $ps) {
            if ($id_solicitud_suceso == $ps->id_solicitud_suceso) {
            	$nombre_contratista= "";
            	$id_contratista = $ps->contratista;
            	foreach ($contratistas as $c) {
            		if ($c->idusuario == $id_contratista) {
            			$nombre_contratista = "<span class='badge badge-success'>$c->usuarioNombre</span>";
            			break;
            		}
            	}
        		$fecha_inicio = date('d-m-Y H:i',strtotime($ps->fecha_inicio));
        		$fecha_termino = date('d-m-Y H:i',strtotime($ps->fecha_termino));
        		$materiales = "";
        		$contador_materiales = 0;
        		foreach ($materiales_partidas as $mat) {
        			$buscar_en = "";
    				if ($mat->comprado_por == "malpo") {
    					$buscar_en = "Retirar en bodega";
    				}
    				else {
    					$buscar_en = "Se debe comprar";
    				}
        			if ($mat->id_suceso_partida == $ps->id_suceso_partida) {
        				if ($contador_materiales == 0) {
        					$materiales .= "<br><b>Materiales:</b><br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
        				}
        				else {
        					$materiales .= "<br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
        				}
        				$contador_materiales++;
        			}
        		}
        		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span>$materiales</label></div><br>";
            }
        }
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='5'>$s->observacion</textarea></td>
							<td><span class='badge badge-success'>$s->estado</span></td>
							<td>$datos_partidas</td>
						</tr>";
	}
	else if ($s->id_estado == 14) { //RECHAZADO
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='5'>$s->observacion</textarea></td>
							<td><span class='badge badge-danger'>$s->estado</span></td>
							<td></td>
						</tr>";
	}
	else if ($s->id_estado == 11) { //PENDIENTE
		$datos_partidas = "";
		foreach ($partidas_suceso as $ps) {
            if ($id_solicitud_suceso == $ps->id_solicitud_suceso) {
            	$nombre_contratista= "";
            	$id_contratista = $ps->contratista;
            	foreach ($contratistas as $c) {
            		if ($c->idusuario == $id_contratista) {
            			$nombre_contratista = "<span class='badge badge-primary'>$c->usuarioNombre</span>";
            			break;
            		}
            	}
            	if ($ps->id_estado == 20) {
            		$fecha_inicio = date('d-m-Y H:i',strtotime($ps->fecha_inicio));
            		$materiales = "";
	        		$contador_materiales = 0;
	        		foreach ($materiales_partidas as $mat) {
	        			if ($mat->id_suceso_partida == $ps->id_suceso_partida) {
	        				$buscar_en = "";
	        				if ($mat->comprado_por == "malpo") {
	        					$buscar_en = "Retirar en bodega";
	        				}
	        				else {
	        					$buscar_en = "Se debe comprar";
	        				}
	        				if ($contador_materiales == 0) {
	        					$materiales .= "<br><b>Materiales:</b><br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
	        				}
	        				else {
	        					$materiales .= "<br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
	        				}
	        				$contador_materiales++;
	        			}
	        		}
            		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida</label> <br>$nombre_contratista <span class='badge badge-primary'>$ps->estado</span> <span class='badge badge-primary'>Inicio: $fecha_inicio</span>$materiales</label></div><br>";
            	}
            	else {
            		$fecha_inicio = date('d-m-Y H:i',strtotime($ps->fecha_inicio));
            		$fecha_termino = date('d-m-Y H:i',strtotime($ps->fecha_termino));
            		$materiales = "";
	        		$contador_materiales = 0;
	        		foreach ($materiales_partidas as $mat) {
	        			if ($mat->id_suceso_partida == $ps->id_suceso_partida) {
	        				$buscar_en = "";
	        				if ($mat->comprado_por == "malpo") {
	        					$buscar_en = "Retirar en bodega";
	        				}
	        				else {
	        					$buscar_en = "Se debe comprar";
	        				}
	        				if ($contador_materiales == 0) {
	        					$materiales .= "<b>Materiales:</b><br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
	        				}
	        				else {
	        					$materiales .= "<br>- $mat->recurso_detalle | Cantidad/Cubicación: $mat->cantidad | $buscar_en";
	        				}
	        				$contador_materiales++;
	        			}
	        		}
            		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span>$materiales</label></div><br>";
            	}
            }
        }
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='5'>$s->observacion</textarea></td>
							<td><span class='badge badge-primary'>$s->estado</span></td>
							<td>$datos_partidas</td>
						</tr>";
	}
}
?>
<div class="overflow-auto">
	<table class="table table-hover table-striped" id="tabla_de_sucesos">
	    <thead class="text-center">
	        <tr class="thead-dark">
	            <th style="width: 30%">SUCESO - ORIGEN</th>
	            <th style="width: 15%">ESTADO</th>
	            <th style="width: 55%">PARTIDAS</th>
	        </tr>
	    </thead>
		<tbody class="">
			<?php echo $datos_tabla; ?>
		</tbody>
	</table>
</div>