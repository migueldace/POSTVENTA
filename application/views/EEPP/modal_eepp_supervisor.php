<form  method="post" action="<?php echo base_url() ?>EEPP/ctrl_eepp/pdf_eepp_supervisor" enctype="multipart/form-data">
	<div class="container card">
		<div class="row">
			<div class="col-md-3">
				<span><i class="ft ft-check"></i> CONTÁCTO: </span>
				<input type="text" name="contacto" class="form-control"  required>
			</div>
			<div class="col-md-3">
				<span><i class="ft ft-check"></i> ENCARGADO: </span>
				<input type="text" name="encargado" class="form-control"  required>
			</div>
			<div class="col-md-3">
				<span><i class="ft ft-check"></i> N° DE PAGO: </span>
				<input type="number" name="n_pago" class="form-control" min="1" required>
			</div>
			<div class="col-md-3">
				<span><i class="ft ft-check"></i> FECHA PAGO: </span>
				<input type="date" name="fecha_pago" class="form-control"  required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-4">
				<span><i class="ft ft-check"></i> DESCUENTOS: </span>
				<input type="number" name="descuentos" class="form-control" min="0" value="0" required>
			</div>
			<div class="col-md-4">
				<span><i class="ft ft-check"></i> ANTICIPO: </span>
				<input type="number" name="anticipo" class="form-control" min="0" value="0" required>
			</div>
			<div class="col-md-4">
				<span><i class="ft ft-check"></i> IVA: </span>
				<div class="checkbox">
				  <label><input type="checkbox" class="" name='iva' value="si"> Incluye IVA</label>
				</div>
			</div>
		</div><br><br>
		<?php  
		$ultima_solicitud = 0;
		$ultimo_suceso = 0;
		$ultima_partida = 0;
		$contador = 0;
		$contador_partidas = 1;
		echo "<input type='hidden' value='$contratista' id='contratista_eepp' name='contratista_eepp'>
				<input type='hidden' value='$fecha_inicio' id='fecha_inicio_eepp' name='fecha_inicio_eepp'>
				<input type='hidden' value='$fecha_corte' id='fecha_corte_eepp' name='fecha_corte_eepp'>
				<input type='hidden' value='$cod_proyecto' id='cod_proyecto_eepp' name='cod_proyecto_eepp'>
				<input type='hidden' value='$nombre_proyecto' id='nombre_proyecto_eepp' name='nombre_proyecto_eepp'>";
		foreach ($eepp as $ep) {
			if (!isset($ep->id_solicitud)) {
				# code...
			}
			else {
				$id_solicitud = $ep->id_solicitud;
				$id_solicitud_suceso = $ep->id_solicitud_suceso;
				$id_partida = $ep->id_suceso_partidas;
				$precio = $ep->precio;
				$cantidad = $ep->unidad_medida;
				$adicional = $ep->precio_adicional;
				$total = number_format(($precio*$cantidad)+$adicional, 0, '', '.');
				$justificacion = $ep->justificacion;
				$partida = "<b>$ep->partida</b><br><input type='hidden' value='$id_partida' id='partida_$contador_partidas'>
							<div class='input-group'>
								<input type='number' readonly class='form-control' value='$precio' id='precio_$contador_partidas' title='Precio'>
								<div class='input-group-append'>
		                          <input type='number' class='form-control' value='$cantidad' min='0' id='cantidad_$contador_partidas' onblur='calcular($contador_partidas)' title='Cantidad'>
		                          <input type='number' class='form-control' value='$adicional' min='0' id='adicional_$contador_partidas' onblur='calcular($contador_partidas)' title='Gasto adicional'>
		                        </div>
		                    </div>
		                    <div class='input-group'>
		                    	<textarea class='form-control' rows='3' placeholder='Comentario o justificación' id='justificacion_$contador_partidas'>$justificacion</textarea>
		                        <div class='input-group-append'>
		                            <input type='text' readonly class='form-control' value='$ $total' id='total_$contador_partidas' title='Total'>
		                        </div>
							</div>";
				$boton = "<div align='right'><button type='button' class='btn btn-warning' onclick='actualizar_partidas($contador_partidas)'>ACTUALIZAR PARTIDAS</button></div>";
				if ($contador == 0) { //SI ES EL PRIMER CICLO
					$cliente = $ep->cliente;
					$vivienda = $ep->vivienda;
					$nombre_c = $cliente->clienteNombre;
					$rut_c = $cliente->clienteRut;
					$viv_dir = $vivienda->viviendaDireccion;
					$datos_materiales = "";
					if (isset($ep->materiales)) {
						$materiales = $ep->materiales;
						if (empty($materiales)) {} 
						else {
							foreach ($materiales as $m) {
								if ($m->comprado_por == "contratista") {
									$datos_materiales .= "<div class='input-group'>
															<b>$m->recurso_detalle</b>
															<div class='input-group-append'>
																<input type='number' class='form-control' value='$m->cantidad' min='0' id='m_cantidad_$m->id_materiales' title='Cantidad'>
																<input type='number' class='form-control' value='$m->precio' min='0' id='m_precio_$m->id_materiales' title='Precio'>
																<button type='button' class='btn btn-sm btn-success' onclick='actualizar_material($m->id_materiales)'>ACT. MATERIAL</button>
															</div>
														  </div>";
								}
							}
						}
					}
					
					echo "<div class='row collapse-icon accordion-icon-rotate'>
							<div class='card-header bg-success col-md-12' id='headingCollapse$id_solicitud' >
								<a data-toggle='collapse' href='#collapse$id_solicitud' aria-expanded='false' aria-controls='collapse$id_solicitud' class='card-title lead white collapsed'>SOLICITUD N° $id_solicitud</a>
				            </div>
				            <div id='collapse$id_solicitud' role='tabpanel' aria-labelledby='headingCollapse$id_solicitud' class='border-success card-collapse collapse col-md-12' aria-expanded='false'>
				            	<div class='row'><br>
				            		<div class='col-md-4'>
				            			<span><b>Rut Cliente:</b></span>
				            			<input type='text' class='form-control' readonly value='$rut_c'>
				            		</div>
				            		<div class='col-md-4'>
				            			<span><b>Cliente:</b></span>
				            			<input type='text' class='form-control' readonly value='$nombre_c'>
				            		</div>
				            		<div class='col-md-4'>
				            			<span><b>Dirección vivienda:</b></span>
				            			<input type='text' class='form-control' readonly value='$viv_dir'>
				            		</div>
				            	</div>
								<br><h5><b>SUCESO - $ep->suceso</b></h5>
								<div class='col-md-12'>
									<table class='table table-hover table-striped'>
									    <thead class='text-center'>
									        <tr class='thead-dark'>
									            <th style='width: 50%'>PARTIDA</th>
									            <th style='width: 50%'>MATERIALES</th>
									        </tr>
									    </thead>
										<tbody>
											<tr>
												<td>$partida<br>$boton</td>
												<td>$datos_materiales</td>
											</tr>
				    ";
				    $ultima_solicitud = $id_solicitud;
				    $ultimo_suceso = $id_solicitud_suceso;
				    $ultima_partida = $id_partida;
					$contador++;
					$contador_partidas++;
				}
				else {
					$contador++;
					//PREGUNTAR PRIMERO SI ES LA MISMA SOLICITUD
					if ($id_solicitud == $ultima_solicitud) {
						//PREGUNTAR SI ES EL MISMO SUCESO
						if ($id_solicitud_suceso == $ultimo_suceso) {
							//PREGUNTAR SI LA PARTIDA ES LA MISMA
							if ($id_partida == $ultima_partida) {
								//NUNCA SE DARA ESTE CASO :V
							}
							//SI ES OTRA PARTIDA
							else {
								$datos_materiales = "";
								if (isset($ep->materiales)) {
									$materiales = $ep->materiales;
									if (empty($materiales)) {} 
									else {
										foreach ($materiales as $m) {
											if ($m->comprado_por == "contratista") {
												$datos_materiales .= "<div class='input-group'>
																		<b>$m->recurso_detalle</b>
																		<div class='input-group-append'>
																			<input type='number' class='form-control' value='$m->cantidad' min='0' id='m_cantidad_$m->id_materiales' title='Cantidad'>
																			<input type='number' class='form-control' value='$m->precio' min='0' id='m_precio_$m->id_materiales' title='Precio'>
																			<button type='button' class='btn btn-sm btn-success' onclick='actualizar_material($m->id_materiales)'>ACT. MATERIAL</button>
																		</div>
																	  </div>";
											}
										}
									}
								}
								echo "
									<tr>
										<td>$partida<br>$boton</td>
										<td>$datos_materiales</td>
									</tr>
								";
								$contador_partidas++;
							}
						}
						//SI NO ES EL MISMO, SE CIERRA LA TABLA Y EL DIV Y SE HACE OTRA TABLA
						else {
							$datos_materiales = "";
							if (isset($ep->materiales)) {
								$materiales = $ep->materiales;
								if (empty($materiales)) {} 
								else {
									foreach ($materiales as $m) {
										if ($m->comprado_por == "contratista") {
											$datos_materiales .= "<div class='input-group'>
																	<b>$m->recurso_detalle</b>
																	<div class='input-group-append'>
																		<input type='number' class='form-control' value='$m->cantidad' min='0' id='m_cantidad_$m->id_materiales' title='Cantidad'>
																		<input type='number' class='form-control' value='$m->precio' min='0' id='m_precio_$m->id_materiales' title='Precio'>
																		<button type='button' class='btn btn-sm btn-success' onclick='actualizar_material($m->id_materiales)'>ACT. MATERIAL</button>
																	</div>
																  </div>";
										}
									}
								}
							}
							echo "		</tbody>
									</table>
								</div><br>
								<br><h5><b>SUCESO - $ep->suceso</b></h5>
								<div class='col-md-12'>
									<table class='table table-hover table-striped'>
									    <thead class='text-center'>
									        <tr class='thead-dark'>
									            <th style='width: 50%'>PARTIDA</th>
									            <th style='width: 50%'>MATERIALES</th>
									        </tr>
									    </thead>
										<tbody>
											<tr>
												<td>$partida<br>$boton</td>
												<td>$datos_materiales</td>
											</tr>
							";
							$ultima_solicitud = $id_solicitud;
						    $ultimo_suceso = $id_solicitud_suceso;
						    $ultima_partida = $id_partida;
						    $contador_partidas++;
						}
					}
					//SI ES OTRA SOLICITUD
					else {
						$cliente = $ep->cliente;
						$vivienda = $ep->vivienda;
						$nombre_c = $cliente->clienteNombre;
						$rut_c = $cliente->clienteRut;
						$viv_dir = $vivienda->viviendaDireccion;
						$datos_materiales = "";
						if (isset($ep->materiales)) {
							$materiales = $ep->materiales;
							if (empty($materiales)) {} 
							else {
								foreach ($materiales as $m) {
									if ($m->comprado_por == "contratista") {
										$datos_materiales .= "<div class='input-group'>
																<b>$m->recurso_detalle</b>
																<div class='input-group-append'>
																	<input type='number' class='form-control' value='$m->cantidad' min='0' id='m_cantidad_$m->id_materiales' title='Cantidad'>
																	<input type='number' class='form-control' value='$m->precio' min='0' id='m_precio_$m->id_materiales' title='Precio'>
																	<button type='button' class='btn btn-sm btn-success' onclick='actualizar_material($m->id_materiales)'>ACT. MATERIAL</button>
																</div>
															  </div>";
									}
								}
							}
						}
							echo "			</tbody>
										</table>
									</div>
								</div>
							</div>
							</br>
							<div class='row collapse-icon accordion-icon-rotate'>
								<div class='card-header bg-success col-md-12' id='headingCollapse$id_solicitud'>
									<a data-toggle='collapse' href='#collapse$id_solicitud' aria-expanded='false' aria-controls='collapse$id_solicitud' class='card-title lead white collapsed'>SOLICITUD N° $id_solicitud</a>
					            </div>
					            <div id='collapse$id_solicitud' role='tabpanel' aria-labelledby='headingCollapse$id_solicitud' class='border-success card-collapse collapse col-md-12' aria-expanded='false'>
					            	<div class='row'><br>
					            		<div class='col-md-4'>
					            			<span><b>Rut Cliente:</b></span>
					            			<input type='text' class='form-control' readonly value='$rut_c'>
					            		</div>
					            		<div class='col-md-4'>
					            			<span><b>Cliente:</b></span>
					            			<input type='text' class='form-control' readonly value='$nombre_c'>
					            		</div>
					            		<div class='col-md-4'>
					            			<span><b>Dirección vivienda:</b></span>
					            			<input type='text' class='form-control' readonly value='$viv_dir'>
					            		</div>
					            	</div>
									<br><h5><b>SUCESO - $ep->suceso</b></h5>
									<div class='col-md-12'>
										<table class='table table-hover table-striped'>
										    <thead class='text-center'>
										        <tr class='thead-dark'>
										            <th style='width: 50%'>PARTIDA</th>
										            <th style='width: 50%'>MATERIALES</th>
										        </tr>
										    </thead>
											<tbody>
												<tr>
													<td>$partida<br>$boton</td>
													<td>$datos_materiales</td>
												</tr>
					    ";
					    $ultima_solicitud = $id_solicitud;
					    $ultimo_suceso = $id_solicitud_suceso;
					    $ultima_partida = $id_partida;
					    $contador_partidas++;
					}
				}
			}
		}
		echo "				</tbody>
						</table>
					</div>
				</div>
			</div>
			<br>
			<div class='col-md-12' align='right'>
				<input type='submit' class='btn btn-danger btn-lg' value='GENERAR PDF'>
				<button type='button' class='btn btn-success btn-lg' onclick='generar_eepp()' disabled>CONFIRMAR VB EEPP</button><br><br>
			</div>";
		?>
	</div>
</form>
<script type="text/javascript">
	function calcular(contador) {
		precio = $('#precio_'+contador).val();
		cantidad = $('#cantidad_'+contador).val();
		if (cantidad == "") {
			cantidad = 0;
			$('#cantidad_'+contador).val(cantidad);
		}
		adicional = $('#adicional_'+contador).val();
		if (adicional == "") {
			adicional = 0;
			$('#adicional_'+contador).val(adicional);
		}
		total = (parseFloat(precio)*parseFloat(cantidad))+parseFloat(adicional);
		// total = total.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
		// total = total.split('').reverse().join('').replace(/^[\.]/,'');
		total = String(total).replace(/\D/g, "");
  		total === '' ? total : Number(total).toLocaleString();

		$('#total_'+contador).val("$ "+total);
	}
	function actualizar_partidas(contador) {
		cantidad = $('#cantidad_'+contador).val();
		adicional = $('#adicional_'+contador).val();
		comentario = $('#justificacion_'+contador).val();
		partida = $('#partida_'+contador).val();
		if (adicional > 0 && comentario == "") {
			$('#justificacion_'+contador).focus();
			Swal.fire('Atención!','Debe justificar el gasto adicional!','info');
		}
		else {
			var parametros = {
				"id_partida" : partida,
	            "adicional" : adicional,
	            "comentario" : comentario,
	            "cantidad" : cantidad
	        };
	        $.ajax({
	           type: "POST",
	           url: '<?php echo base_url() ?>EEPP/ctrl_eepp/actualizar_partidas',
	           data: parametros,
	           success: function(respuesta)
	           {
	                if (respuesta == "error") {
	                    Swal.fire('Atención!','Ocurrio un error al actualizar!','info');
	                }
	                else {
	                	Swal.fire('Bien!','Valores de partida actualizados correctamente!','success');
	                }
	            }
	        });
	    }
	}
	function actualizar_material(id_material) {
		precio = $('#m_precio_'+id_material).val();
		if (precio == "") {
			precio = 0;
			$('#m_precio'+id_material).val(precio);
		}
		cantidad = $('#m_cantidad_'+id_material).val();
		if (cantidad == "") {
			cantidad = 0;
			$('#m_cantidad_'+id_material).val(cantidad);
		}
		var parametros = {
            "id_materiales" : id_material,
            "precio" : precio,
            "cantidad" : cantidad
        };
        $.ajax({
           type: "POST",
           url: '<?php echo base_url() ?>EEPP/ctrl_eepp/actualizar_material',
           data: parametros,
           success: function(respuesta)
           {
                if (respuesta == "error") {
                    Swal.fire('Atención!','Ocurrio un error al actualizar!','info');
                }
                else {
                	Swal.fire('Bien!','Material actualizado correctamente!','success');
                }
            }
        });
	}
	function generar_eepp() {
		contratista = $('#contratista_eepp').val();
		fecha_inicio = $('#fecha_inicio_eepp').val();
		fecha_corte = $('#fecha_corte_eepp').val();
		cod_proyecto = $('#cod_proyecto_eepp').val();
		var parametros = {
            "contratista" : contratista,
            "fecha_inicio" : fecha_inicio,
            "fecha_corte" : fecha_corte,
            "cod_proyecto" : cod_proyecto
        };
		Swal.fire({
          title: 'Atención',
          text: 'Se dará el VB para este EEPP, ¿desea continuar?.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, adelante!',
          showLoaderOnConfirm: true,
          cancelButtonText: 'Cancelar!'
            }).then((result) => {
              if (result.value) {
                $.ajax({                        
                    type: "POST",                 
                    url: '<?php echo base_url() ?>EEPP/ctrl_eepp/vb_eepp_supervisor',                     
                    data: parametros,
                    success: function(respuesta)             
                    {
                        if (respuesta == "error") {
                            Swal.fire('Atención!','Ocurrio un error!','info')
                        }
                        else if(respuesta == "ok"){
                            //MENSAJE CONFIRMANDO, AL APRETAR OK, ACTRUALIZAR LA PAGINA
                            Swal.fire({
                              title: 'Exito!',
                              text: "Visto bueno correcto!",
                              icon: 'success',
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'Genial!'
                            }).then((result) => {
                              if (result.value) {
                                //AQUI ACTUALIZAR LA PAG
                                setTimeout('document.location.reload()',500);
                              }
                              else {
                                //TAMBIEN ACTUALIZAR LA PAG
                                setTimeout('document.location.reload()',500);
                              }
                            })
                        }
                        else {
                            Swal.fire('Atención', respuesta, "warning");
                        }
                    }
                });
              }
              else {
              }
        })
	}
	function generar_pdf() {
		contratista = $('#contratista_eepp').val();
		fecha_inicio = $('#fecha_inicio_eepp').val();
		fecha_corte = $('#fecha_corte_eepp').val();
		cod_proyecto = $('#cod_proyecto_eepp').val();
		var parametros = {
            "contratista" : contratista,
            "fecha_inicio" : fecha_inicio,
            "fecha_corte" : fecha_corte,
            "cod_proyecto" : cod_proyecto
        };
        $.ajax({                        
	        type: "POST",                 
	        url: '<?php echo base_url() ?>EEPP/ctrl_eepp/pdf_eepp_supervisor',                     
	        data: parametros,
	        success: function(respuesta)             
	        {
	            if (respuesta == "error") {
	                Swal.fire('Atención!','Ocurrio un error!','info')
	            }
	            // else if(respuesta == "ok"){
	            //     //MENSAJE CONFIRMANDO, AL APRETAR OK, ACTRUALIZAR LA PAGINA
	            //     Swal.fire({
	            //       title: 'Exito!',
	            //       text: "Visto bueno correcto!",
	            //       icon: 'success',
	            //       confirmButtonColor: '#3085d6',
	            //       confirmButtonText: 'Genial!'
	            //     }).then((result) => {
	            //       if (result.value) {
	            //         //AQUI ACTUALIZAR LA PAG
	            //         setTimeout('document.location.reload()',500);
	            //       }
	            //       else {
	            //         //TAMBIEN ACTUALIZAR LA PAG
	            //         setTimeout('document.location.reload()',500);
	            //       }
	            //     })
	            // }
	            else {
	                // Swal.fire('Atención', respuesta, "warning");
	            }
	        }
	    });
	}
</script>