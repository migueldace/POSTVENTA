<?php $this->load->view('Callcenter/librerias_calendario_view'); ?>

<div class="container">
    <div class="col-12 col-md-6">
        <div class="form-inline" style="display: none;" id="carga">
            <h4>
                <i class="fa fa-spinner fa-spin" style="font-size:20px"></i> Cargando información...
            </h4>
        </div>
    </div>
    <div class="row">
        <h3>Horario de los Supervisores</h3>
    </div>
    <hr>
    <div class="row">
        <select onchange="calendarioSupervisores(this.value)" class="selectpicker form-control col-md-6" id="supervisores_agenda" name="supervisores_agenda" data-container="body" data-live-search="true" data-size="10">

        </select>
    </div>
    <hr>
    <div class="row">
        <div id="calendar" class="calendar col-md-12"></div>
    </div>
</div>

<?php $this->load->view('Solicitudes/solicitud_detalle_view'); ?>

<!-- <script src="<?= base_url() ?>assets/js/Solicitudes/ingresadas.js" type="text/javascript"></script> -->

<script>
    var fecha = moment().format("YYYY-MM-DD");    
    let horario = [];
    id_usuario = 0;
    perfil =  <?php echo $_SESSION["id_perfil"]; ?>;
    if(perfil == 9) { //SI ES SUPERVISOR
        id_usuario = <?php echo $this->session->userdata('idusuario'); ?>;
    }
    $(document).ready(function() {
        calendarioSupervisores(id_usuario);
        obtenerSupervisores();
        // if (perfil == 16 || perfil == 18 || perfil == 2) {
        //     $('#calendar').fullCalendar({

        //         timeFormat: 'hh:mm a',
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'month,agendaWeek,agendaDay,listWeek'
        //         },
        //         allDaySlot: false,
        //         defaultDate: fecha,
        //         displayEventTime: true,
        //         navLinks: true,
        //         eventLimit: true,
        //         weekNumbers: true,
        //         editable: true,
        //         events: horario,
        //         themeSystem: 'bootstrap4',
        //         eventDrop: function(event, delta, revertFunc) {

        //             Swal.fire({
        //                 title: '¿Desea actualizar fecha de Visita?',
        //                 text: "",
        //                 type: 'warning',
        //                 showCancelButton: true,
        //                 confirmButtonColor: '#3085d6',
        //                 cancelButtonColor: '#d33',
        //                 confirmButtonText: 'SI',
        //                 cancelButtonText: 'NO',
        //             }).then((result) => {
        //                 if (result.value) {                      
        //                     actualizarAgenda(event.id, event.start.format());
        //                 } else {
        //                     revertFunc();
        //                 }
        //             })
        //         },
        //         eventRender: function(event, element) {
        //             element.click(function() {
        //                 obtenerDetalle(event.id);
        //             });
        //         }
        //     });  
        // }
        // else if(perfil == 9) {
        //     $('#calendar').fullCalendar({

        //         timeFormat: 'hh:mm a',
        //         header: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'month,agendaWeek,agendaDay,listWeek'
        //         },
        //         allDaySlot: false,
        //         defaultDate: fecha,
        //         displayEventTime: true,
        //         navLinks: true,
        //         eventLimit: true,
        //         weekNumbers: true,
        //         editable: true,
        //         events: horario,
        //         themeSystem: 'bootstrap4',
        //         eventDrop: function(event, delta, revertFunc) {
        //             revertFunc();
        //         },
        //         eventRender: function(event, element) {
        //             element.click(function() {
        //                 obtenerDetalle(event.id);
        //             });
        //         }
        //     });
        // }    
    });

    function calendarioSupervisores(id_supervisor) {        
        $.ajax({
            url: base_url + "Ctrl_obtener/calendarioSupervisores",
            type: 'post',
            data: {
                'id_supervisor': id_supervisor
            },
            success: function(data) {

                $('#calendar').fullCalendar('removeEvents', function() {
                    return true;
                });

                let horario = [];

                let response = $.parseJSON(data);
                response = Object.create(response);

                if (response.registros != 0) {
                    $.each(response.datos, function(i, item) {

                        var hora_final;

                        switch (item.hora_visita) {

                            case '08:00':
                                hora_final = '08:30';
                                break;
                            case '08:30':
                                hora_final = '09:00';
                                break;
                            case '09:00':
                                hora_final = '09:30';
                                break;
                            case '09:30':
                                hora_final = '10:00';
                                break;
                            case '10:00':
                                hora_final = '10:30';
                                break;
                            case '10:30':
                                hora_final = '11:10';
                                break;
                            case '11:00':
                                hora_final = '11:30';
                                break;
                            case '11:30':
                                hora_final = '12:00';
                                break;
                            case '12:00':
                                hora_final = '12:30';
                                break;
                            case '12:30':
                                hora_final = '13:00';
                                break;
                            case '13:00':
                                hora_final = '13:30';
                                break;
                            case '15:00':
                                hora_final = '15:30';
                                break;
                            case '15:30':
                                hora_final = '16:00';
                                break;
                            case '16:00':
                                hora_final = '16:30';
                                break;
                            case '16:30':
                                hora_final = '17:00';
                                break;
                            case '17:00':
                                hora_final = '17:30';
                                break;
                            case '17:30':
                                hora_final = '18:00';
                                break;
                            case '18:00':
                                hora_final = '18:30';
                                break;
                            case '18:30':
                                hora_final = '19:00';
                                break;

                        }   

                        var hora = item.hora_visita;
                        var dia = new Date(item.fecha_visita + 'T' + hora);
                        var final = new Date(item.fecha_visita + 'T' + hora_final);

                        horario.push({
                            id: item.id_solicitud,
                            title: item.usuario.usuarioRut + '\n' + item.usuario.usuarioNombre,
                            start: dia,
                            end: final,
                        });
                    });
                } else {}

                $('#calendar').fullCalendar('addEventSource', horario, true);
                if (perfil == 16 || perfil == 18 || perfil == 2 || perfil == 17) {
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
                        editable: true,
                        events: horario,
                        themeSystem: 'bootstrap4',
                        eventDrop: function(event, delta, revertFunc) {

                            Swal.fire({
                                title: 'Desea actualizar fecha de Visita',
                                text: "",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'SI',
                                cancelButtonText: 'NO',
                            }).then((result) => {
                                if (result.value) {                                
                                    actualizarAgenda(event.id, event.start.format());
                                } else {
                                    revertFunc();
                                }
                            })
                        },
                        eventRender: function(event, element) {
                            element.click(function() {
                                obtenerDetalle(event.id);
                            });
                        }
                    });
                }
                else if (perfil == 9) {
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
                        editable: true,
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
            }
        });
    }

    function actualizarAgenda(id_solicitud, nueva_fecha) {

        var res = nueva_fecha.split("T");

        $.ajax({
            url: base_url + "Ctrl_obtener/actualizarAgenda",
            type: 'post',
            data: {
                'id_solicitud': id_solicitud,
                'fecha_visita': res[0],
                'hora_visita': res[1]
            },
            success: function(data) {
                var response = $.parseJSON(data);
                response = Object.create(response);

                switch (response.estatus) {
                    case 200:
                        alerta(2);
                        break;
                    default:
                        break;
                }
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

                        detalleSolicitud(
                            item.id_solicitud,
                            item.estado,
                            prioridad,
                            item.fecha,
                            item.dias,
                            item.cliente.clienteRut,
                            item.cliente.clienteNombre,
                            item.cliente.clienteTelefono,
                            item.comentario_cliente,
                            item.vivienda.viviendaFecharecepcion,
                            item.vivienda.viviendaProyecto,
                            item.vivienda.proyectoNombre,
                            item.vivienda.viviendaDireccion,
                            item.vivienda.viviendaDireccion,
                            item.id_estado
                        );
                    });

                }
            }
        });
    }
</script>