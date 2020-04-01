<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="ft ft-play" style="font-size:36px;color:greis"></i> EEPP Supervisor
        </h2>
    </div>
</div>

<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buscar Contratista y fechas a filtrar</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <?php  
                    $contratistas_select = '<option value="">SELECCIONE CONTRATISTA</option>';
                    foreach ($contratistas as $c) {
                        $contratistas_select .= '<option value="'.$c->idusuario.'">'.$c->usuarioNombre.'</option>';
                    }
                ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <span><i class="ft ft-check"></i> Contratista: </span>
                            <select class=" form-control"  id="contratista" name="contratista" >
                                <?php echo $contratistas_select; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <span><i class="ft ft-check"></i> Fecha Inicio: </span>
                            <input type="date" class="form-control" id="fecha_inicio" name="" value="">
                        </div>
                        <div class="col-md-3">
                            <span><i class="ft ft-check"></i> Fecha Corte: </span>
                            <input type="date" class="form-control" id="fecha_corte" name="" value="">
                        </div>
                        <div class="col-md-1"><br>
                              <button class="btn btn-primary" type="button" onclick="buscar_proyectos()">BUSCAR</button>
                            </div>
                    </div><br>
                    <div class="row" id="info_proyectos"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="modal_eepp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-clipboard"></i>
                    <span class="font-weight-bold">RESUMEN EEPP </span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalle">
                
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                <!-- <button id="imprimir" type="button" class="btn btn-outline-default btn-sm">Imprimir</button> -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function buscar_proyectos() {
        contratista = $('#contratista').val();
        fecha_inicio = $('#fecha_inicio').val();
        fecha_corte = $('#fecha_corte').val();
        if (contratista == "" || fecha_inicio == "" || fecha_corte == "") {
            Swal.fire("Alerta","Faltan datos por ingresar!","warning");
        }
        else {
            var parametros = {
                "contratista" : contratista,
                "fecha_inicio" : fecha_inicio,
                "fecha_corte" : fecha_corte
            };
            $.ajax({
               type: "POST",
               url: '<?php echo base_url() ?>EEPP/ctrl_eepp/buscar_proyectos',
               data: parametros,
               success: function(respuesta)
               {
                    if (respuesta == "error") {
                        Swal.fire('Atención!','No se encontrarón datos en las fechas seleccionadas!','info');
                        $("#info_proyectos").html("");
                    }
                    else {
                        $("#info_proyectos").html(respuesta);
                    }
                }
            });
        }
    }
    function ver_eepp(contratista, fecha_inicio, fecha_corte, proyecto, nombre_proyecto) { //    
        // alert(contratista);alert(fecha_inicio);alert(fecha_corte);alert(proyecto);
        var parametros = {
            "contratista" : contratista,
            "fecha_inicio" : fecha_inicio,
            "fecha_corte" : fecha_corte,
            "proyecto" : proyecto,
            "nombre_proyecto" : nombre_proyecto
        };
        $.ajax({
           type: "POST",
           url: '<?php echo base_url() ?>EEPP/ctrl_eepp/buscar_eepp',
           data: parametros,
           beforeSend: function () {
                $("#detalle").html('<center><h2>Espere por favor....</h2></center><hr><center><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></center>');
           },
           success: function(respuesta)
           {
                if (respuesta == "error") {
                    Swal.fire('Atención!','No se encontrarón datos en las fechas seleccionadas!','info');
                    $("#info_proyectos").html("");
                }
                else {
                    //ABRIR MODAL
                    $("#modal_eepp").modal('show');
                    $("#detalle").html(respuesta);
                }
            }
        });
    }
</script>