<?php var_dump($solicitudes); ?>
<table class="table table-striped table-bordered column-rendering" id="tabla_pendientes">
  <thead class="table-dark text-center">
    <tr>
    	<td></td>
    	<td>N° Solicitud</td>
    	<td>Fecha Visita</td>
    	<td>Cliente</td>
    	<td>Proyecto</td>
    	<td>Direccion</td>
    	<td>Acción</td>
    </tr>
  </thead>
  <tbody>
  	<?php 
  		foreach ($solicitudes as $s) {
  			echo "<tr>
  					<td></td>
  					<td class='text-right'>".$s->id_solicitud."</td>
  					<td class='text-center'>".$s->fecha_visita."</td>
  					<td>".$s->cliente->clienteNombre."</td>
  					<td>".$s->vivienda->proyectoNombre."</td>
  					<td>".$s->vivienda->viviendaDireccion."</td>
  					<td class='text-center'><button type='button' class='btn btn-info'><i class='fa fa-eye' onclick='detalle_solicitud(".$s->id_solicitud.");'></i></button></td>
  				  </tr>";
  		}
  	?>
  </tbody>
</table>
<script type="text/javascript">

  $(document).ready(function() {
      $('#tabla_pendientes').DataTable({
        "pageLength": 5,
          "language": {
            "lengthMenu": "Mostrar _MENU_ Registros",
            "zeroRecords": "No hay Registros",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "No se encotraron registros",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "sSearch":"Buscar : ",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            buttons: {
                print: 'Imprimir',
                excel: 'Excel'
            }
        },
        "aoColumnDefs": [{ 
            "bVisible": false, 
            "aTargets": [0,0,0] 
        }],
        dom: 'Bfrtip',
        buttons: [
            'print' ,'excel'
        ]
      });
  } );
</script>