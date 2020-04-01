<div id="example-tabs" class="container card">
    <section>
    	<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $id_solicitud ?>">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS GENERALES DE LA SOLICITUD N° <?php echo $id_solicitud ?></b></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <span><i class="ft ft-check"></i> Estado Actual de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $estado ?>" readonly />
            </div>
            <div class="col-md-3">
                <span><i class="ft ft-check"></i> Prioridad de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $prioridad ?>" readonly />
            </div>
            <div class="col-md-3">
                <span><i class="ft ft-check"></i> Fecha de visita Supervisor: </span>
                <input type="text" class="form-control" value="<?php echo $fecha_visita.' '.$hora_visita ?>" readonly />
            </div>
            <div class="col-md-3">
                <span><i class="ft ft-check"></i> Fecha Prox./Últ. Trabajos: </span>
                <input type="text" class="form-control" value="<?php echo date("d/m/Y H:i",strtotime($fecha_visita_contratista)) ?>" readonly />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Rut del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $rut ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Nombre del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $nombre ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Teléfono del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $telefono ?>" readonly />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span><i class="ft ft-check"></i> Comentarios del Cliente: </span>
                <textarea class="form-control" readonly><?php echo $comentario ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                <span><i class="ft ft-check"></i> Fecha RMO: </span>
                <input type="text" class="form-control" value="<?php echo $rmo ?>" readonly />
            </div>
            <div class="col-md-2">
                <span><i class="ft ft-check"></i> Código del Proyecto: </span>
                <input type="text" class="form-control" value="<?php echo $cod_proyecto ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Nombre del Proyecto: </span>
                <input type="text" class="form-control" value="<?php echo $proyecto ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Dirección de la Vivienda: </span>
                <input type="text" class="form-control" value="<?php echo $direccion ?>" readonly />
            </div>
        </div>

    </section>
    <hr>
    <section>
      <div class="row">
          <div class="col-md-12 text-center">
              <h3><b><i class="fa fa-angle-right"></i> ASIGNACIÓN DE MATERIALES</b></h3>
          </div>
      </div><br>
      <div class="row">
        
        <div class="col-md-3"><br>
          <select class="form-control" id="sucesos_asignar">
            <option value="">SELECCIONE SUCESO</option>
            <?php 
            foreach ($sucesos as $s) {
              $id_solicitud_suceso = $s->id_solicitud_suceso;
              if ($s->id_estado == 12 or $s->id_estado == 13) { //si esta finalizado o pagado
                echo "<option disabled>$s->suceso - $s->origen - FINALIZADO</option>";
              }
              else if ($s->id_estado == 14) { //RECHAZADO
                echo "<option disabled>$s->suceso - $s->origen - RECHAZADO</option>";
              }
              else if ($s->id_estado == 11) { //PENDIENTE
                echo "<option value='$id_solicitud_suceso'>$s->suceso - $s->origen</option>";
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-3"><br>
          <select class="form-control"  id="partida_material" name="partida_material">
            <option value="">SELECCIONE PARTIDA</option>
          </select>
        </div>
        <div class="col-md-2"><br>
          <input type="number" min="1" class="form-control" placeholder="Cantidad" id="cantidad_recurso">
        </div>
        <div class="col-md-4"><br> <!-- Recursos -->
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Material" id='recurso_a_buscar'>
            <button type="button" onclick="buscar_recurso()" class="btn btn-info input-group-append">Buscar Material</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12"><br>
          <div class="input-group">
            <div class="col-md-3">
              <label class="radio-inline" >
                <input type="radio" class="form-control input-group-append" checked name="es_malpo"  value="malpo" style="font-size: 120%">Material Malpo
              </label>
            </div>
            <div class="col-md-3">
              <label class="radio-inline" >
                <input type="radio" class="form-control input-group-append" name="es_malpo" value="contratista" style="font-size: 120%">Material Contratista
              </label>
            </div>
          </div>
        </div>
      </div><br>
      <div class="row">
        <div id="tabla_recursos" class="col-md-12"><br>
        </div>
        <div class="col-md-12"><br>
          <span><i class="ft ft-check"></i><b> Resumen Materiales: </b></span>
          <div class="pre-scrollable" style="height: 70%;">
            <table id="tabla_sucesos" class="table  table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr >
                  <th style="text-align: center; width: 30%">Partida</th>
                  <th style="text-align: center; width: 50%">Material - Cantidad</th>
                  <th style="text-align: center; width: 20%">Malpo/Contratista</th>
                </tr>
              </thead>
              <tbody id="body_recursos">
                <?php  
                  foreach ($materiales_partidas as $mp) {
                    $quien_compra = "";
                    if ($mp->comprado_por == "malpo") {
                      $quien_compra = "Recurso Malpo";
                    }
                    else {
                      $quien_compra = "Contratista";
                    }
                    echo "<tr>
                            <td>$mp->partida</td>
                            <td>$mp->recurso_detalle - $mp->cantidad</td>
                            <td><span class='badge badge-default badge-primary'>$quien_compra</span></td>
                          </tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section id="seccion_sucesos">
      <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS DE LOS SUCESOS</b></h3>
            </div>
        </div>
    	<?php  $this->load->view("Solicitudes/tabla_sucesos"); ?>
    	
    </section>
    <section>
      <div class="row">
          <div align="left" class="col-md-6">
            <form  method="post" action="<?php echo base_url() ?>Supervisor/ctrl_supervisor/pdf_conformidad_supervisor">
              <input type="hidden" name="id_solicitud_pdf" id="id_solicitud_pdf" value="<?php echo $id_solicitud ?>">
              <input type="hidden" name="rut_pdf" id="rut_pdf" value="<?php echo $rut ?>">
              <input type="hidden" name="nombre_pdf" id="nombre_pdf" value="<?php echo $nombre ?>">
              <input type="hidden" name="telefono_pdf" id="telefono_pdf" value="<?php echo $telefono ?>">
              <input type="hidden" name="proyecto_pdf" id="proyecto_pdf" value="<?php echo $proyecto ?>">
              <input type="hidden" name="direccion_pdf" id="direccion_pdf" value="<?php echo $direccion ?>">
              <input type='submit' class='btn btn-danger btn-lg' value='GENERAR PDF'>
            </form>
          </div>
          <div align="right" class="col-md-6">
            <button type="button" onclick="cliente_ausente(<?php echo $id_solicitud ?>)" class="btn btn-warning" id="boton_ausencia">Correo de ausencia</button> 
            <button type='button' class='btn btn-success btn-lg' onclick='finalizar_solicitud(<?php echo $id_solicitud ?>)'>Finalizar Solicitud</button>
          </div>
      </div>   
    </section>
</div>
<script type="text/javascript">
  function buscar_recurso() {
      recurso = $('#recurso_a_buscar').val();
      if (recurso == "") {
          Swal.fire("Alerta","Debe ingresar el recurso a buscar!","warning");
      }
      else {
          var parametros = {
              "recurso_buscado" : recurso
          };
          $.ajax({
             type: "POST",                 
             url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/obtener_recursos',                     
             data: parametros,
             success: function(respuesta)             
             {
                  $("#tabla_recursos").html(respuesta);
             }
          });
      }
  }
  $(document).ready(function() { 
    $("#sucesos_asignar").change(function() {
      $("#sucesos_asignar option:selected").each(function() { //CADA VEZ QUE CAMBIE LA EL SUCESO
        suceso = $('#sucesos_asignar').val();
        if (suceso == "") {
          $("#partida_material").html("");
        }
        else {
          $.post("<?php echo base_url(); ?>Supervisor/ctrl_supervisor/buscar_partidas", { 
            id_solicitud_suceso : suceso
          }, function(data) {
            $("#partida_material").html("<option value=''>SELECCIONE PARTIDA</option>"+data);
          });
        }
      });
    });
  });
	function confirmar_partidas(id_solicitud_suceso) {
		id_solicitud = $("#id_solicitud").val();
    edmu = $("#edmu_"+id_solicitud_suceso).val();
		// var arr = $('[name="partidas'+id_solicitud_suceso+'[]"]:checked').map(function(){
	 //      return this.value;
	 //    }).get();
	    let valoresCheck = [];

		$('[name="partidas'+id_solicitud_suceso+'[]"]:checked').each(function(){
		    valoresCheck.push(this.value);
		});
		var parametros = {
            "id_solicitud" : id_solicitud,
            "id_solicitud_suceso" : id_solicitud_suceso,
            "edmu" : edmu,
            "partidas_realizadas" : valoresCheck
        };
        $.ajax({
           type: "POST",                 
           url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/inspeccion_final_partidas',                     
           data: parametros,
           success: function(respuesta)             
           {
           		if (respuesta == "error") {
           			Swal.fire('Atención!', "Se actualizo EDMU, pero ninguna partida fue concluida!",'warning');
           		}
           		else {
	                Swal.fire('Exito!', "Partidas completadas!",'success');
	                $("#seccion_sucesos").html(respuesta);
	            }
           }
        });
	}
	function finalizar_solicitud(id_solicitud) {
		var parametros = {
            "id_solicitud" : id_solicitud
        };
        $.ajax({
           type: "POST",                 
           url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/finalizar_solicitud',                     
           data: parametros,
           success: function(respuesta)             
           {
           		if (respuesta == "error") {
           			Swal.fire('Atención!', "Ocurrio un error, verifique todos los sucesos e intente nuevamente!",'warning');
           		}
           		else {
           			Swal.fire({
                      title: 'Exito!',
                      text: "Solicitud Concluida!",
                      type: 'success',
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
           }
        });
	}
  function cliente_ausente(id_solicitud) {
        Swal.fire({
          title: 'Atención',
          text: 'Se enviará un correo al cliente avisando que no se encontró a nadie en su vivienda \n ¿Desea continuar?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, enviar correo!',
          showLoaderOnConfirm: true,
          cancelButtonText: 'Cancelar!'
        }).then((result) => {
          if (result.value) {
            //ENVIARLO POR AJAX 
            rut_cliente = $('#rut').val();
            var parametros = {
                "id_solicitud" : id_solicitud,
                "rut_cliente" : rut_cliente
            };
            $.ajax({                        
               type: "POST",                 
               url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/correo_ausencia_trabajos',                     
               data: parametros,
               success: function(respuesta)
               {
                    Swal.fire('Exito!','Correo enviado!','success')
               }
            });
          }
          else {
          }
        })
  }
</script>
