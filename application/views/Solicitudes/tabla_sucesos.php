<?php  
$contador = 1;
$datos_tabla = "";
foreach ($sucesos as $s) {
	$id_solicitud_suceso = $s->id_solicitud_suceso;
	if ($s->id_estado == 12 or $s->id_estado == 13) { //si esta finalizado o pagado
		$datos_partidas = "";
		foreach ($partidas_suceso as $ps) {
			$nombre_contratista= "";
        	$id_contratista = $ps->contratista;
        	foreach ($contratistas as $c) {
        		if ($c->idusuario == $id_contratista) {
        			$nombre_contratista = "<span class='badge badge-primary'>$c->usuarioNombre</span>";
        			break;
        		}
        	}
            if ($id_solicitud_suceso == $ps->id_solicitud_suceso) {
        		$fecha_inicio = date('d-m-Y H:i',strtotime($ps->fecha_inicio));
        		$fecha_termino = date('d-m-Y H:i',strtotime($ps->fecha_termino));
        		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span></label></div><br>";
            }
        }
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='4'>$s->observacion</textarea></td>
							<td><span class='badge badge-success'>$s->estado</span></td>
							<td>$datos_partidas</td>
						</tr>";
	}
	else if ($s->id_estado == 14) { //RECHAZADO
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='4'>$s->observacion</textarea></td>
							<td><span class='badge badge-danger'>$s->estado</span></td>
							<td></td>
						</tr>";
	}
	else if ($s->id_estado == 11) { //PENDIENTE
		$edmus = "";
        foreach ($edmu as $e) {
        	if ($e->id_edmu != 5) {
	            if ($e->id_edmu == $s->edmu) {
	                $edmus .= '<option value="'.$e->id_edmu.'" selected>'.$e->detalle.'</option>';
	            }
	            else {
	                $edmus .= '<option value="'.$e->id_edmu.'">'.$e->detalle.'</option>';
	            }
	        }
        }

		$select_edmu = "<select class='form-control' id='edmu_$id_solicitud_suceso' name='edmu_$id_solicitud_suceso' >$edmus</select>";
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
            		$datos_partidas .= "<div class='form-check'><label class='form-check-label'><input class='form-check-input' type='checkbox' value='$ps->id_suceso_partida' name='partidas".$ps->id_solicitud_suceso."[]'>$ps->partida</label> <br>$nombre_contratista <span class='badge badge-primary'>$ps->estado</span> <span class='badge badge-primary'>Inicio: $fecha_inicio</span></div><br>";
            	}
            	else {
            		$fecha_inicio = date('d-m-Y H:i',strtotime($ps->fecha_inicio));
            		$fecha_termino = date('d-m-Y H:i',strtotime($ps->fecha_termino));
            		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span></label></div><br>";
            	}
            }
        }
        $datos_partidas .= "<button type='button' class='btn btn-primary' 
        						onclick='confirmar_partidas($id_solicitud_suceso)'>Confirmar Partidas</button>";
		$datos_tabla.= "<tr>
							<td><b>$s->suceso</b><br><b>ORIGEN:</b> $s->origen<br><textarea class='form-control' readonly colspan='4'>$s->observacion</textarea></td>
							<td><span class='badge badge-primary'>$s->estado</span><br><br>$select_edmu</td>
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