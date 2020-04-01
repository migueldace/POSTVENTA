<div class="table-responsive">
    <table class="table table-hover table-striped table-responsive" id="lista_recursos">
        <thead class="text-center">
            <tr class="thead-dark">
                <th>SOLICITUD</th>
                <th>SUCESO</th>
                <th>PARTIDA</th>
                <th>MATERIAL</th>
                <th>CANTIDAD</th>
                <th>MALPO/CONTRATISTA</th>
            </tr>
        </thead>
        <tbody class="">
            <?php 
            $quien = "";
                foreach ($materiales_partidas as $m) {
                    if ($m->comprado_por == "malpo") {
                        $quien = "Recurso Malpo";
                    }
                    else {
                        $quien = "Recurso Contratista";
                    }
                    echo "<tr>
                            <td>$m->id_solicitud</td>
                            <td>$m->suceso<br>$m->origen</td>
                            <td>$m->partida</td>
                            <td>$m->recurso_detalle</td>
                            <td>$m->cantidad</td>
                            <td>$quien</td>
                          </tr>";
                }
            ?>
        </tbody>
    </table>
</div>            
<script type="text/javascript">
    $(document).ready(function () {
        $('#lista_recursos').dataTable({
            responsive: true,
            dom: 'Bfrtip',
            "sPaginationType": "full_numbers",
            "pageLength" : 10,
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
            buttons: [{
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o fa-2x"></i>',
                autoFilter: true,
                sheetName: 'Materiales',
                exportOptions: {
                    columns: ':visible',
                }
            }]
        });
    }
</script>