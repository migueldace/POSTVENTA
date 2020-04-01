<div id="example-tabs" class="container card">
    <section>
        <?php //var_dump($sucesos); ?>
        <input type="text" class="form-control" id="id_solicitud" style="display:none;"/>

        <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS GENERALES DE LA SOLICITUD N° <?php echo $id_solicitud ?></b></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Estado Actual de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $estado ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Prioridad de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $prioridad ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Fecha de visita: </span>
                <input type="text" class="form-control" id='fecha_inspeccion' value="<?php echo $fecha_visita.' '.$hora_visita ?>" readonly />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Rut del Cliente: </span>
                <input type="text" class="form-control" id='rut' value="<?php echo $rut ?>" readonly />
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
    <section style="height: 100%;" >
        <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS DE LOS SUCESOS</b></h3>
            </div>
        </div>
        <div class="row" style="height: 100%;">
            <div class="col-md-12">
                <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $id_solicitud ?>">
                <div class="card collapse-icon accordion-icon-rotate">
                    <?php 
                    $contratistas_select = '<option value="">SELECCIONE CONTRATISTA</option>';
                    foreach ($contratistas as $c) {
                        if ($c->usuarioEstado == 1) {
                            $contratistas_select .= '<option value="'.$c->idusuario.'">'.$c->usuarioNombre.'</option>';
                        }
                        
                    }
                    $contador = 1;
                    foreach ($sucesos as $s) {
                        $dias_trabajo = 0;
                        $fecha = "";
                        $contratista_selec = "0";
                        $id_suceso = $s->id_suceso;
                        $categoria = $s->categoria;
                        $id_solicitud_suceso = $s->id_solicitud_suceso;
                        echo "<script> contador_filas".$id_solicitud_suceso." = 0;</script>";
                        $partidas_tabla = "";
                        foreach ($partidas as $p) {
                            if ($p->categoria == $categoria) {
                                $partidas_tabla .= '<option value="'.$p->id_partida.'" id="partida'.$id_solicitud_suceso."_".$p->id_partida.'">'.$p->partida.' - '.$p->unidad.'</option>';
                            }
                        }
                        $partidas_del_suceso = "";
                        $materiales_del_suceso = "";
                        $clase = ""; //PARA DEFINIR SI SE DEJA DISABLED O NO LOS ITEMS
                        $div_rechazo = "";
                        $esta_rechazado = "no";
                        $bg_head = "";
                        if (is_null($s->observacion)) { $comentario = ""; }else { $comentario = $s->observacion; } //COMENTARIO
                        if ($s->id_estado == 10 or $s->id_estado == 11) { //SI esta pendiente
                            $rechazo = '<select class="form-control " onchange="rechazar('.$id_solicitud_suceso.')" id="rechazo'.$id_solicitud_suceso.'">
                                            <option value="1" selected>NO RECHAZADO</option>
                                            <option value="0">RECHAZADO</option>
                                        </select>';
                            $bg_head = " bg-success";
                        }else {
                            $rechazo = '<select class="form-control" disabled>
                                            <option value="1">NO RECHAZADO</option>
                                            <option value="0" selected>RECHAZADO</option>
                                        </select>';
                            $clase = 'disabled';
                            $div_rechazo = '<div class="alert alert-warning">Suceso Rechazado</div>';
                            $esta_rechazado = "si";
                            $bg_head = " bg-danger";
                        }
                        $clase_head_acordion = "";
                        $clase_body_acordion = "show";
                        if ($contador >= 2) {
                            $clase_head_acordion = "collapsed";
                            $clase_body_acordion = "";
                        }
                        echo '<div id="heading'.$contador.'" class="card-header'.$bg_head.'" role="tab">
                                <a data-toggle="collapse" data-parent="#accordionWrapa'.$contador.'" href="#accordion'.$contador.'" aria-expanded="true"
                                aria-controls="accordion'.$contador.'" class="card-title lead '.$clase_head_acordion.'"><h4 class="form-section white">Suceso #'.$contador.'</h4></a>
                            </div>
                            <div id="accordion'.$contador.'" role="tabpanel" aria-labelledby="heading'.$contador.'" class="collapse '.$clase_body_acordion.'"><br>
                            <form method="post" id="formulario'.$id_solicitud_suceso.'" action="javascript: actualizar_partidas('.$id_solicitud_suceso.')">';

                        if($esta_rechazado == "no") {
                            if (empty($partidas_suceso)) { } //SI NO EXISTEN PARTIDAS SUCESO
                            else {
                                // $partidas_tabla = "";
                                foreach ($partidas_suceso as $ps) {
                                    if ($id_solicitud_suceso == $ps->id_solicitud_suceso) {
                                        $partidas_del_suceso .= "<tr><td colspan='2'><b>".$ps->partida."</b></td><td><b>".$ps->medida."</b></td></tr>";
                                        $contratista_selec = $ps->contratista;
                                        $dias_trabajo = $ps->dias;
                                        $fecha = str_replace(" ", "T", $ps->fecha);
                                    }
                                }

                                $contratistas_select = '<option value="">SELECCIONE CONTRATISTA</option>';
                                foreach ($contratistas as $c) {
                                    if ($c->idusuario == $contratista_selec) {
                                        $contratistas_select .= '<option value="'.$c->idusuario.'" selected>'.$c->usuarioNombre.'</option>';
                                    }
                                    else {
                                        if ($c->usuarioEstado == 1) {
                                            $contratistas_select .= '<option value="'.$c->idusuario.'">'.$c->usuarioNombre.'</option>';
                                        }
                                    }
                                }
                            }
                            if (empty($materiales_suceso)) { } //SI NO EXISTEN MATEARIALES DEL SUSCEOS
                            else {
                                foreach ($materiales_suceso as $ms) {
                                    if ($id_solicitud_suceso == $ms->id_solicitud_suceso) {
                                        $materiales_del_suceso .= "<tr><td colspan='2'>".$ms->recurso_detalle."</td><td><b>".$ms->comprado_por."</b></td></tr>";
                                    }
                                }
                            }

                            $sucesos_tabla = "";
                            foreach ($sucesos_all as $su) {
                                if ($su->id_suceso == $s->id_suceso) {
                                    $sucesos_tabla .= '<option value="'.$su->id_suceso.'" selected>'.$su->suceso.'</option>';
                                }
                                else {
                                    $sucesos_tabla .= '<option value="'.$su->id_suceso.'">'.$su->suceso.'</option>';
                                }
                            }
                            $origenes = "";
                            foreach ($origen as $o) {
                                if ($o->id_origen == $s->id_origen) {
                                    $origenes .= '<option value="'.$o->id_origen.'" selected>'.$o->origen.'</option>';
                                }
                                else {
                                    $origenes .= '<option value="'.$o->id_origen.'">'.$o->origen.'</option>';
                                }
                            }
                            $edmus = "";
                            foreach ($edmu as $e) {
                                if ($e->id_edmu == $s->edmu) {
                                    $edmus .= '<option value="'.$e->id_edmu.'" selected>'.$e->detalle.'</option>';
                                }
                                else {
                                    $edmus .= '<option value="'.$e->id_edmu.'">'.$e->detalle.'</option>';
                                }
                            }
                            $hora_visita = "";
                            if ($fecha != "") {
                                $fecha_visita = date("Y-m-d", strtotime($fecha));
                                $hora_visita = date("H:i", strtotime($fecha));
                            }
                            else {
                                $fecha_visita = "";
                                $hora_visita = "";
                            }
                            echo '
                            <input type="hidden" name="id_solicitud_suceso" id="id_solicitud_suceso" 
                            value="'.$id_solicitud_suceso.'">
                                <div class="row"><br>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Suceso: </span>
                                        <select class="form-control" style="width:100%;" id="suceso'.$id_solicitud_suceso.'" 
                                        name="suceso" '.$clase.' onchange="cargar_partidas('.$id_solicitud_suceso.')">'.$sucesos_tabla.'</select></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Origen: </span>
                                        <select class=" form-control" style="width:100%;" id="origen'.$id_solicitud_suceso.'" 
                                        name="origen" '.$clase.'>'.$origenes.'</select></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Edmu: </span>
                                        <select class=" form-control" style="width:100%;" id="edmu'.$id_solicitud_suceso.'" 
                                        name="edmu" '.$clase.'>'.$edmus.'</select></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Rechazo: </span>
                                        '.$rechazo.'</div>

                                    <div class="col-md-3"><br>
                                        <span><i class="ft ft-check"></i> Contratista: </span>
                                        <select class=" form-control" style="width:100%;" 
                                        id="contratista'.$id_solicitud_suceso.'" name="contratista" '.$clase.'>'.$contratistas_select.'</select></div>
                                    <div class="col-md-3"><br>
                                        <span><i class="ft ft-check"></i> Duración (días): </span>
                                        <input type="number" class="form-control" id="dias'.$id_solicitud_suceso.'" name="dias" min="1" '.$clase.' value="'.$dias_trabajo.'"></div>
                                    <br>
                                    <div class="col-md-3"><br>
                                        <span><i class="ft ft-check"></i> Fecha visita: </span>
                                        <input type="date" class="form-control" id="fecha'.$id_solicitud_suceso.'" name="fecha" min="'.date("Y-m-d").'" '.$clase.' value="'.$fecha_visita.'"></div>
                                    <br>
                                    <div class="col-md-3"><br>
                                        <span><i class="ft ft-check"></i> Hora visita: </span>
                                        <input type="time" class="form-control" id="hora'.$id_solicitud_suceso.'" name="hora" min="07:00" '.$clase.' value="'.$hora_visita.'"></div>
                                    <br>
                                    <div class="col-md-12"><br>
                                        <span><i class="ft ft-check"></i> Comentario: </span>
                                        <textarea class="form-control" rows="3" id="comentario'.$id_solicitud_suceso.'" 
                                        name="comentario" maxlenght="500" '.$clase.'>'.$comentario.'</textarea></div>

                                    <div class="col-md-6"><br>
                                        <span><i class="ft ft-check"></i> Partidas: </span>
                                        <div class="input-group">
                                            <select class=" form-control '.$clase.'"  id="partidas'.$id_solicitud_suceso.'" name="partidas'.$id_solicitud_suceso.'" >
                                                <option value="">SELECCIONE PARTIDA</option>
                                                '.$partidas_tabla.'
                                            </select>
                                            <div class="input-group-append">
                                                <input type="number" class="form-control" placeholder="Cubicación" id="metros'.$id_solicitud_suceso.'" min="1" '.$clase.' >
                                                
                                            </div>
                                            <button type="button" onclick="agregar('.$id_solicitud_suceso.')" class="btn btn-success input-group-append" id="boton_agregar'.$id_solicitud_suceso.'" '.$clase.' style="width: 20%;">Agregar</button>
                                        </div><br>
                                    </div>
                                    <div class="col-md-6 "><br>
                                        <span><i class="ft ft-check"></i> Resumen Partidas: </span>
                                        <div class="pre-scrollable" style="height: 50%;">
                                            <table id="tabla_sucesos" class="table  table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">
                                                <thead>
                                                  <tr style="display: none;">
                                                    <th style="text-align: center; width: 60%"></th>
                                                    <th style="text-align: center; width: 20%"></th>
                                                    <th style="text-align: center; width: 20%"></th>
                                                  </tr>
                                                </thead>
                                                <tbody id="body_partidas'.$id_solicitud_suceso.'">
                                                    '.$partidas_del_suceso.'
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>';
                            echo '        
                                    <div id="respuesta'.$id_solicitud_suceso.'" class="col-md-6">
                                        <input type="submit" class="btn btn-success" id="boton_actualizar'.$id_solicitud_suceso.'" disabled value="GUARDAR PARTIDAS" '.$clase.'>'.$div_rechazo.'
                                    </div>
                                </div>
                            </form></div><br><hr>';
                            $contador++;
                        }
                        else {
                            echo '<div class="row">
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Suceso: </span>
                                        <input type="text" class="form-control" value="'.$s->suceso.'" disabled></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Origen: </span>
                                        <input type="text" class="form-control" value="'.$s->origen.'" disabled></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Edmu: </span>
                                        <input type="text" class="form-control" value="'.$s->edmu_nombre.'" disabled></div>
                                    <div class="col-md-3">
                                        <span><i class="ft ft-check"></i> Rechazo: </span>
                                        '.$div_rechazo.'</div>
                                     <div class="col-md-12"><br>
                                        <span><i class="ft ft-check"></i> Comentario: </span>
                                        <textarea class="form-control" rows="3" disabled>'.$comentario.'</textarea></div>
                                </div></form></div>';
                                $contador++;
                        }
                    }
                    ?>
                </div>
                
            </div>

        </div>
        <br><br><br>
        <div class="row">
            <div align="left" class="col-md-6">
               <button type="button" onclick="cliente_ausente(<?php echo $id_solicitud ?>)" class="btn btn-warning" id="boton_ausencia" >Correo de ausencia</button> 
            </div>
            <div align="right" class="col-md-6">
                <button type="button" onclick="rechazar_solicitud(<?php echo $id_solicitud ?>)" class="btn btn-danger" id="boton_rechazar">Rechazar Solicitud</button>
                <button type="button" onclick="confirmar_solicitud(<?php echo $id_solicitud ?>)" class="btn btn-success" id="boton_finalizar" >Inspección Realizada</button>
            </div>
        </div>
        <!-- <div id="respuesta"></div> -->
    </section>
</div>
<script type="text/javascript">
    // $(document).ready(function() {

    //     $("#example-tabs").steps({
    //         headerTag: "h3",
    //         bodyTag: "section",
    //         transitionEffect: "slideLeft",
    //         enableFinishButton: false,
    //         enablePagination: false,
    //         enableAllSteps: true,
    //         titleTemplate: "#title#",
    //         cssClass: "tabcontrol"
    //     });
    // });
    // contador_filas = 0;
    $('#datos_sucesos').dataTable({
        responsive: true,
        dom: 'Bfrtip',
        "sPaginationType": "full_numbers",
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
                "sLast": "Ultimo"
            },
            "decimal": ",",
            "thousands": "."
        },
        buttons: [{
            extend: 'colvis',
            text: '<i class="ft-check-square"></i> Mostrar/Ocultar',
        }, {
            extend: 'excel',
            text: '<i class="fa fa-file-excel-o fa-2x"></i>',
            autoFilter: true,
            sheetName: 'Solicitudes',
            exportOptions: {
                columns: visible,
            }
        }, {
            extend: 'print',
            text: '<i class="fa fa-print fa-2x"></i>',
            exportOptions: {
                columns: ':visible'
            },
            customize: function (win) {
                $(win.document.body)
                    .css('font-size', '10pt')
                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }
        }],
    });

    function agregar(id) {
        metros = $('#metros'+id).val();
        partida = $('#partidas'+id).val();
        nombre_partida = $('select[name="partidas'+id+'"] option:selected').text();
        if (metros == "" || partida == "") {
            Swal.fire('Atención!','Debe seleccionar una partida valida e ingresar la cubicación correspondientes!','warning');
        }
        else {
            var actual_contador = eval("contador_filas"+id+"+="+1);
            $("#rechazo"+id).attr('disabled', true);
            // contador_filas++;
            fila = "<tr id='fila"+id+"_"+actual_contador+"'><td><b>"+nombre_partida+"</b></td><td><b>"+metros+"</b><input type='hidden' name='sucesos_partidas[]' id='sucesos_partidas[]' value='"+id+"---"+partida+"---"+metros+"' ></td><td style='text-align: center;'><a class='btn btn-danger'  onclick='eliminar_fila("+actual_contador+","+id+","+partida+")'> <i class='fa fa-trash'></i> </a></td></tr>";
            $("#body_partidas"+id).append(fila);
            $("#boton_actualizar"+id).attr('disabled', false);
            $("#partida"+id+"_"+partida).attr('disabled', true);
            $("#partidas"+id).val("");
        }
    }
    function eliminar_fila(contador, id_suceso, id_partida) {
        $('#fila'+id_suceso+"_"+contador).remove();
        var actual_contador = eval("contador_filas"+id_suceso+"-="+1);
        // contador_filas--;
        if (actual_contador == 0) {
          $("#boton_actualizar"+id_suceso).attr('disabled', true);
          $("#rechazo"+id_suceso).attr('disabled', false);
          $("#partida"+id_suceso+"_"+id_partida).attr('disabled', false);
        }
    }
    function actualizar_partidas(id) {
        //VALIDACIONES
        edmu = $('#edmu'+id).val();
        comentario = $('#comentario'+id).val();
        contratista = $('#contratista'+id).val();
        dias = $('#dias'+id).val();
        fecha = $('#fecha'+id).val();
        hora = $('#hora'+id).val();
        if (edmu == 5) {
            Swal.fire('Atención!','Debe seleccionar el EDMU correspondiente!','warning');
        }
        else if(contratista == "") {
            Swal.fire('Atención!','Debe seleccionar un contratista!','warning');
        }
        else if(dias == "" || dias == 0) {
            Swal.fire('Atención!','Debe ingresar los días de trabajo estimado!','warning');
        }
        else if(comentario.trim() == "") {
            Swal.fire('Atención!','Debe ingresar un comentario del suceso!','warning');
        }
        else if(fecha.trim() == "" || fecha == null) {
            Swal.fire('Atención!','Debe ingresar una fecha valida!','warning');
        }
        else if(hora.trim() == "" || hora == null) {
            Swal.fire('Atención!','Debe ingresar una hora valida!','warning');
        }
        else {
            formData = new FormData($("#formulario"+id)[0]);
            $.ajax({                        
               type: "POST",                 
               url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/actualizar_ingresar_partidas',                     
               data: formData, 
               cache: false,
               contentType: false,
               processData: false,
               success: function(data)             
               {
                  // $('#respuesta').html(data);
                  $("#boton_actualizar"+id).attr('disabled', true);
                  $("#boton_agregar"+id).attr('disabled', true);
                  $('#respuesta'+id).append("<div class='alert alert-success'>Suceso Listo!</div>");
                  Swal.fire('Exito!','Suceso y partidas ingresadas/actualizadas de forma correcta!','success');
               }
           });
        }
    }
    function rechazar(id) {
        Swal.fire({
          title: 'Atención',
          text: '¿Está seguro(a) de rechazar este suceso? Esta acción no puede cancelarse. \n Recuerde agregar el motivo del rechazo en el cajon de comentarios!',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Rechazarlo!',
          showLoaderOnConfirm: true,
          cancelButtonText: 'Cancelar!'
        }).then((result) => {
          if (result.value) {
            //ENVIARLO POR AJAX Y RECHAZARLO
            comentario = $("#comentario"+id).val();
            origen = $("#origen"+id).val();
            edmu = $("#edmu"+id).val();
            if(comentario.trim() == "") {
                Swal.fire('Atención!','Debe ingresar un comentario del suceso!','warning');
                $("#rechazo"+id).val("1");
            }
            else {
                var parametros = {
                    "id_solicitud_suceso" : id,
                    "comentario" : comentario,
                    "origen" : origen,
                    "edmu" : edmu
                };
                $.ajax({                        
                   type: "POST",                 
                   url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/rechazar_suceso',                     
                   data: parametros,
                   success: function(respuesta)             
                   {
                        $('#respuesta'+id).append('<div class="alert alert-warning">Suceso Rechazado</div>');
                        $("#boton_actualizar"+id).attr('disabled', true);
                        $("#rechazo"+id).attr('disabled', true);
                        $("#contratista"+id).attr('disabled', true);
                        $("#dias"+id).attr('disabled', true);
                        $("#comentario"+id).attr('disabled', true);
                        $("#partidas"+id).attr('disabled', true);
                        $("#boton_agregar"+id).attr('disabled', true);
                        Swal.fire('Exito!','Suceso rechazado!','success')
                   }
                });
            }
          }
          else {
            $("#rechazo"+id).val("1");
          }
        })
    }
    function confirmar_solicitud(id) {
        id_solicitud = id;
        var parametros = {
            "id_solicitud" : id_solicitud
        };
        Swal.fire({
          title: 'Atención',
          text: 'Se dará por inspeccionada esta solicitud, ¿desea continuar?.',
          type: 'question',
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
                    url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/confirmar_inspeccion',                     
                    data: parametros,
                    success: function(respuesta)             
                    {
                        if (respuesta == "error") {
                            Swal.fire('Atención!','Faltan sucesos por gestionar, favor verificar!','info')
                        }
                        else if(respuesta == "rechazo") {
                            Swal.fire('Atención!','Todos los sucesos se rechazaron, favor rechazar la solicitud!','info')
                        }
                        else if(respuesta == "tamos ready"){
                            //MENSAJE CONFIRMANDO, AL APRETAR OK, ACTRUALIZAR LA PAGINA
                            Swal.fire({
                              title: 'Exito!',
                              text: "Solicitud Inspeccionada correctamente!",
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
                        else {
                            Swal.fire('Atención', "A ocurrido un error, intente nuevamente", "warning");
                        }
                    }
                });
              }
              else {
              }
        })
    }
    function rechazar_solicitud(id) {
        id_solicitud = id;
        rut_cliente = $('#rut').val();
        var parametros = {
            "id_solicitud" : id_solicitud,
            "rut_cliente" : rut_cliente

        };
        Swal.fire({
          title: 'Atención',
          text: 'Se rechazara la solicitud, ¿desea continuar?.',
          type: 'question',
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
                    url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/rechazar_solicitud',                     
                    data: parametros,
                    success: function(respuesta)             
                    {
                        if (respuesta == "error") {
                            Swal.fire('Atención!','Faltan sucesos por gestionar, favor verificar!','info')
                        }
                        else if(respuesta == "error_listos") {
                            Swal.fire('Atención!','Tiene uno o más sucesos inspeccionados o pendientes, la solicitud no se puede rechazar!','info')
                        }
                        else if(respuesta == "tamos ready")  {
                            //MENSAJE CONFIRMANDO, AL APRETAR OK, ACTRUALIZAR LA PAGINA
                            Swal.fire({
                              title: 'Exito!',
                              text: "Solicitud Rechazada!",
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
                        else {
                            Swal.fire('Atención', "A ocurrido un error, intente nuevamente", "warning");
                        }
                    }
                });
              }
              else {
              }
        })
    }
    function cargar_partidas(id) {
        id_suceso = $("#suceso"+id+" option:selected").val();
        $.post("<?php echo base_url(); ?>Supervisor/ctrl_supervisor/cargar_partidas", { 
          id_suceso : id_suceso,
          id : id
        }, function(data) {
          $("#partidas"+id).html("<option value=''>SELECCIONE PARTIDA</option>"+data);
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
            fecha_inspeccion = $('#fecha_inspeccion').val();
            var parametros = {
                "id_solicitud" : id_solicitud,
                "rut_cliente" : rut_cliente,
                "fecha_inspeccion" : fecha_inspeccion
            };
            $.ajax({                        
               type: "POST",                 
               url: '<?php echo base_url() ?>Supervisor/ctrl_supervisor/correo_ausencia',                     
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
