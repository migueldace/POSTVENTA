<?php $this->load->view('Callcenter/librerias_calendario_view'); ?>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php 
                    if ($_SESSION["id_perfil"] != 19) {
                    ?>
                    <h4 class="card-title">Horario de los Contratistas</h4>
                    <?php 
                    }
                    else {
                    ?>
                    <h4 class="card-title">Mi Calendario</h4>
                    <?php 
                    }   
                    ?>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="col-md-12 col-md-6">
                        <div class="form-inline" style="display: none;" id="carga">
                            <h4>
                                <i class="fa fa-spinner fa-spin" style="font-size:20px"></i> Cargando información...
                            </h4>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <?php 
                        if ($_SESSION["id_perfil"] != 19) {
                        ?>
                        <select onchange="calendarioContratistas(this.value)" class="selectpicker form-control col-md-6" id="contratista_agenda" name="contratista_agenda" data-container="body" data-live-search="true" data-size="10">
                        </select>
                        <?php 
                        }   
                        ?>
                    </div>

                    <hr>
                    <br>

                    <div class="col-md-12">
                        <div id="example-tabs">
                            <h3>Datos Generales</h3>
                            <section>
                                <div id="calendar" class="calendar"></div>
                            </section>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="modal_super" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-clipboard"></i>
                    <span class="font-weight-bold">RESUMEN DE LA SOLICITUD</span>
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
<script>
    var fecha = moment().format("YYYY-MM-DD");    
    let horario = [];
    id_usuario = 0;
    perfil =  <?php echo $_SESSION["id_perfil"]; ?>;
    if(perfil == 19) { //SI ES CONTRATISTA
        id_usuario = <?php echo $this->session->userdata('idusuario'); ?>;
    }
    $(document).ready(function() {
        calendarioContratistas(id_usuario);
        // $("#example-tabs").steps({
        //     headerTag: "h3",
        //     bodyTag: "section",
        //     transitionEffect: "slideLeft",
        //     enableFinishButton: false,
        //     enablePagination: false,
        //     enableAllSteps: true,
        //     titleTemplate: "#title#",
        //     cssClass: "tabcontrol"
        // });

        // $('#calendar').fullCalendar({

        //     timeFormat: 'hh:mm a',
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'month,agendaWeek,agendaDay,listWeek'
        //     },
        //     allDaySlot: false,
        //     defaultDate: fecha,
        //     displayEventTime: true,
        //     navLinks: true,
        //     eventLimit: true,
        //     weekNumbers: true,
        //     editable: true,
        //     events: horario,
        //     themeSystem: 'bootstrap4',
        //     eventDrop: function(event, delta, revertFunc) {
        //         revertFunc();
        //         // Swal.fire({
        //         //     title: '¿Desea actualizar fecha de Visita?',
        //         //     text: "",
        //         //     type: 'warning',
        //         //     showCancelButton: true,
        //         //     confirmButtonColor: '#3085d6',
        //         //     cancelButtonColor: '#d33',
        //         //     confirmButtonText: 'SI',
        //         //     cancelButtonText: 'NO',
        //         // }).then((result) => {
        //         //     if (result.value) {
        //         //         revertFunc();
        //         //         // actualizarAgenda(id_solicitud, event.start.format());
        //         //     } else {
        //         //         revertFunc();
        //         //     }
        //         // })
        //     },
        //     eventRender: function(event, element) {
        //         element.click(function() {
        //             obtenerDetalle(event.id);
        //         });
        //     }
        // });

        obtenerContratistas();
        
        calendarioContratistas(id_usuario);
    });
    function calendarioContratistas(id_contratista) {
        $.ajax({
            url: base_url + "Ctrl_obtener/calendarioContratistas",
            type: 'post',
            data: {
                'id_contratista': id_contratista
            },
            success: function (data) {
                $('#calendar').fullCalendar('removeEvents', function () {
                    return true;
                });

                let horario = [];

                let response = $.parseJSON(data);
                response = Object.create(response);

                if (response.registros != 0) {
                    $.each(response.datos, function (i, item) {

                        var fecha_formato = item.fecha_inicio.replace('T', ' ');

                        horario.push({
                            id: item.solicitud,
                            title: item.usuario.usuarioNombre + '\n' + item.partida,
                            start: fecha_formato,
                            end: false,
                        });

                    });
                } else { }

                $('#calendar').fullCalendar('addEventSource', horario, true);
                $('#calendar').fullCalendar({

                    timeFormat: 'hh:mm a',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay,listWeek'
                    },
                    allDaySlot: false,
                    defaultDate: fecha,
                    displayEventTime: true,
                    navLinks: true,
                    eventLimit: true,
                    weekNumbers: true,
                    editable: false,
                    events: horario,
                    themeSystem: 'bootstrap4',
                    eventDrop: function(event, delta, revertFunc) {
                        revertFunc();   
                    },
                    eventRender: function(event, element) {
                        element.click(function() {
                            obtenerDetalle(event.id);
                        });
                    }
                });
            }
        });
    }
    function obtenerDetalle(id_solicitud) {

        $.ajax({
            url: base_url + "Solicitudes/Ctrl_solicitudes/obtenerDetalle",
            type: 'post',
            data: {
                'id': id_solicitud
            },
            success: function(data) {

                var response = $.parseJSON(data);
                response = Object.create(response);
                

                if (response.registros === 0) {

                } else {

                    $.each(response.datos, function(i, item) {
                        var prioridad = nombrePrioridad(item.prioridad.prioridad);
                        $.ajax({ //AQUI DEBO ABRIR OTRO MODAL
                            url: base_url + "Contratista/ctrl_contratista/resumen_solicitud",
                            type: 'post',
                            data: {
                                'id_solicitud': item.id_solicitud, 
                                'estado': item.estado, 
                                'prioridad': prioridad, 
                                'rut': item.cliente.clienteRut, 
                                'nombre': item.cliente.clienteNombre, 
                                'telefono': item.cliente.clienteTelefono, 
                                'comentario': item.comentario_cliente, 
                                'rmo': item.vivienda.viviendaFecharecepcion, 
                                'cod_proyecto': item.vivienda.viviendaProyecto, 
                                'proyecto': item.vivienda.proyectoNombre, 
                                'direccion': item.vivienda.viviendaDireccion
                            },
                            success: function (data) {
                                $("#modal_super").modal('show');
                                $("#detalle").html(data);
                            }
                        });


                        // detalleSolicitud(
                        //     item.id_solicitud,
                        //     item.estado,
                        //     prioridad,
                        //     item.fecha,
                        //     item.dias,
                        //     item.cliente.clienteRut,
                        //     item.cliente.clienteNombre,
                        //     item.cliente.clienteTelefono,
                        //     item.comentario_cliente,
                        //     item.vivienda.viviendaFecharecepcion,
                        //     item.vivienda.viviendaProyecto,
                        //     item.vivienda.proyectoNombre,
                        //     item.vivienda.viviendaDireccion,
                        //     item.vivienda.viviendaDireccion,
                        //     item.id_estado
                        // );
                    });

                }
            }
        });
    }
</script>

<style>
    .tabcontrol>.content {
        height: 1200px;
    }
</style>