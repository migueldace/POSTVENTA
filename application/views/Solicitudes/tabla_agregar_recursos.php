<div>
	<table class="table table-hover table-striped" id="lista_recursos">
	    <thead class="text-center">
	        <tr class="thead-dark">
	            <th style="width: 80%">RECURSO</th>
	            <th style="width: 20%">AGREGAR</th>
	        </tr>
	    </thead>
		<tbody class="">
		    <?php 
		    	foreach ($recursos as $r) {
		    		$onclick_boton = "";
		    		$nombre_recurso = str_replace('"', ' ', $r->recDescripcion);
		    		$nombre_recurso = str_replace("'", "'", $r->recDescripcion);
		    		$onclick_boton = '"'.$r->recCodigo.'","'.$nombre_recurso.'"';
		    		echo "<tr>
		    				<td style='width: 80%'>".$nombre_recurso." - ".$r->recUnidad."</td>
		    				<td style='width: 20%'>
		    					<button type='button' class='btn btn-warning' onclick='agregar_recurso(".$onclick_boton.")'>></button>
		    				</td>
		    			  </tr>";
		    	}
		    ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	$('#lista_recursos').dataTable({
        responsive: true,
        dom: 'Bfrtip',
        "sPaginationType": "full_numbers",
        "pageLength" : 4,
        "language": {
            "sProcessing": "Cargando...",
            "sLengthMenu": "Ver _MENU_ registros",
            "sZeroRecords": "No se produjo ningún resultado",
            "sEmptyTable": "No existen registros para mostrar",
            "sInfo": "Resultado _START_ - _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Registros 0 - 0 de 0 Entradas",
            "sInfoFiltered": "(Filtrado de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primero",
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Último"
            },
            "decimal": ",",
            "thousands": "."
        },
        buttons: []
    });
	function agregar_recurso(codigo, descripcion) {
		cantidad = $('#cantidad_recurso').val();
		es_malpo = $('input:radio[name=es_malpo]:checked').val();
		partida = $('#partida_material').val();
		nombre_partida = $('select[name="partida_material"] option:selected').text();
		nombre_partida = nombre_partida.replace('"', ' ');
		nombre_partida = nombre_partida.replace("'", " ");
		if(partida == "") {
			Swal.fire('Atención!','Debe seleccionar una partida!','warning');
			$('#partida_material').focus();
		}
		else if (cantidad == 0 || cantidad == "") {
			Swal.fire('Atención!','Debe agregar la cantidad!','warning');
			$('#cantidad_recurso').focus();
		}
		else {
			var parametros = {
	            "id_suceso_partida" : partida,
	            "cod_recurso" : codigo,
	            "recurso_detalle" : descripcion,
	            "cantidad" : cantidad,
	            "comprado_por" : es_malpo 
	        };
			Swal.fire({
	          title: 'Atención',
	          text: 'Se agregará el material seleccionado a la partida indicada, ¿desea continuar?.',
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
	                    url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/ingresar_materiales',                     
	                    data: parametros,
	                    success: function(respuesta)             
	                    {
	                        if (respuesta == "error") {
	                            Swal.fire('Atención!','Ocurrio un error, favor intente nuevamente!','info')
	                        }
	                        else if(respuesta == "ok"){
	                            Swal.fire({
	                              title: 'Exito!',
	                              text: "Material agregado correctamente!",
	                              icon: 'success',
	                              confirmButtonColor: '#3085d6',
	                              confirmButtonText: 'Genial!'
	                            }).then((result) => {
	                              if (result.value) {
	                                de_quien_es = "";
									if (es_malpo == "contratista") { de_quien_es = "Contratista"} 
									else {	de_quien_es = "Recurso Malpo" }
									fila = "<tr><td>"+nombre_partida+"</td><td>"+descripcion+"</td><td><span class='badge badge-default badge-primary'>"+de_quien_es+"</span></td></tr>";
									$("#body_recursos").append(fila);
	                              }
	                              else {
	                                de_quien_es = "";
									if (es_malpo == "contratista") { de_quien_es = "Contratista"} 
									else {	de_quien_es = "Recurso Malpo" }
									fila = "<tr><td>"+nombre_partida+"</td><td>"+descripcion+"</td><td><span class='badge badge-default badge-primary'>"+de_quien_es+"</span></td></tr>";
									$("#body_recursos").append(fila);
	                              }
	                            })
	                        }
	                        else {
	                            Swal.fire('Atención', "A ocurrido un error, intente nuevamente", "warning");
	                        }
	                    }
	                });
	              }
	        })
		}
	}
</script>