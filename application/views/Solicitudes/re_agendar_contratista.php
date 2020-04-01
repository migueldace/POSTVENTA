<?php  
$contador = 1;
$datos_tabla = "";
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
        		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span></label></div><br>";
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
            	if ($ps->id_estado == 20) {
            		$id_contratista = $ps->contratista;
            		$contratistas_select = '';
                    foreach ($contratistas as $c) {
                        if ($c->idusuario == $id_contratista) {
                            $contratistas_select .= '<option value="'.$c->idusuario.'" selected>'.$c->usuarioNombre.'</option>';
                        }
                        else {
                            if ($c->usuarioEstado == 1) {
                                $contratistas_select .= '<option value="'.$c->idusuario.'">'.$c->usuarioNombre.'</option>';
                            }
                        }
                    }

            		$fecha_visita = date("Y-m-d", strtotime($ps->fecha_inicio));
                    $hora_visita = date("H:i", strtotime($ps->fecha_inicio));
            		$datos_partidas .= "<div>
            								<label class='form-check-label'>$ps->partida</label> <br><span class='badge badge-primary'>$ps->estado</span><br><span>¿REAGENDAR? </span>
            								<div class='col-md-12 input-group'>
            									<select class='form-control' id='contratista_$ps->id_suceso_partida' name='contratista_$ps->id_suceso_partida'>
            										$contratistas_select
            									</select>
                                        		<input type='date' class='form-control' id='fecha_$ps->id_suceso_partida' name='fecha_$ps->id_suceso_partida' min='".date("Y-m-d")."' value='".$fecha_visita."'>
                                        		<input type='time' class='form-control' id='hora_$ps->id_suceso_partida' name='hora_$ps->id_suceso_partida' min='07:00' 
                                        		value='".$hora_visita."'>
                                        		<button type='button' class='btn btn-warning' onclick='actualizar_horario($ps->id_suceso_partida)'>Act. horario</button>
                                        	</div>
                                        </div><br>";
            	}
            	else {
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
            		$datos_partidas .= "<div class='form-check'><label class='form-check-label'>$ps->partida <br>$nombre_contratista <span class='badge badge-success'>$ps->estado</span> <span class='badge badge-success'>Inicio: $fecha_inicio</span> <span class='badge badge-success'>Termino: $fecha_termino</span></label></div><br>";
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
<script type="text/javascript">
	function actualizar_horario(id_suceso_partida) {
		contratista = $('#contratista_'+id_suceso_partida).val();
		fecha = $('#fecha_'+id_suceso_partida).val();
		hora = $('#hora_'+id_suceso_partida).val();
		var parametros = {
            "id_suceso_partida" : id_suceso_partida,
            "contratista" : contratista,
            "fecha" : fecha,
            "hora" : hora
        };
        // console.log(parametros);
		$.ajax({                        
           type: "POST",                 
           url: '<?php echo base_url() ?>Callcenter/ctrl_callcenter/actualizar_partida',                     
           data: parametros,
           success: function(respuesta)             
           {
                Swal.fire('Exito!','Partida reasignada correctamente!','success')
           }
        });
	}
</script>