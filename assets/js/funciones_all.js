const base_url = 'http://localhost/POSTVENTA/';
var perfil = 0;

var contador;

$(document).ready(function () {
    tabla_exportar();

    $('#imprimir').on('click', function () {
        if ($('.modal').is(':visible')) {
            var modalId = $(event.target).closest('.modal').attr('id');
            $('body').css('visibility', 'hidden');
            $("#" + modalId).css('visibility', 'visible');
            $('#' + modalId).removeClass('modal');
            window.print();
            $('body').css('visibility', 'visible');
            $('#' + modalId).addClass('modal');
        } else {
            window.print();
        }
    });
});

function cargaVisible() {
    document.getElementById('carga').style.display = 'inherit';
}

function cargaNoVisible() {
    document.getElementById('carga').style.display = 'none';
}

function visible(elemento) {
    document.getElementById('' + elemento + '').style.display = "block";
}

function invisible(elemento) {
    document.getElementById('' + elemento + '').style.display = "none";
}

function inhabilitar(elemento) {
    document.getElementById('' + elemento + '').disabled = true;
}

function habilitar(elemento) {
    document.getElementById('' + elemento + '').disabled = false;
}

function verModal(elemento) {
    $('#' + elemento + '').appendTo('body').modal('show');
}

function ocultarModal(elemento) {
    $('#' + elemento + '').appendTo('body').modal('hide');
}

function formatoNumero(elemento) {
    return new Intl.NumberFormat("de-DE").format(elemento);
}

function estiloEstados(elemento) {
    var estilo;

    switch (elemento) {
        case '1':
            estilo = 'info';
            break;
        case '2':
        case '3':
        case '11':
            estilo = 'warning';
            break;
        case '5':
            estilo = 'success';
            break;
        case '4':
        case '6':
        case '14':
            estilo = 'danger';
            break;
        default:
            estilo = 'success';
            break;
    }

    return estilo;
}

function estiloPrioridad(elemento) {
    var estilo;

    switch (elemento) {
        case '1':
            estilo = 'danger';
            break;
        case '2':
            estilo = 'warning';
            break;
        case '3':
            estilo = 'success';
            break;
    }

    return estilo;
}

function nombrePrioridad(elemento) {

    var prioridad;

    switch (elemento) {
        case '1':
            prioridad = 'ALTA';
            break;
        case '2':
            prioridad = 'MEDIA';
            break;
        case '3':
            prioridad = 'BAJA';
            break;
    }

    return prioridad;
}


function tabla_exportar(tabla) {
    $('#' + tabla + '').dataTable({
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
                "sLast": "Último"
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
                columns: ':visible',
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
}

function alerta(valor) {
    var type;
    var title;
    var text;
    switch (valor) {
        case 1:
            type = 'info';
            title = 'ok';
            text = 'Bien';
            break;
        case 2:
            type = 'success';
            title = 'Bien';
            text = 'Operación realizada con exito';
            break;
        case 3:
            type = 'warning';
            title = 'Advertencia';
            text = 'Debe seleccionar el centro de costo';
            break;
        case 4:
            type = 'error';
            title = 'Alerta';
            text = '';
            break;
    }
    Swal.fire({
        type: type,
        title: title,
        text: text,
        showConfirmButton: false,
    });
}

function ObtenerActivos(tabla, callback) {
    $.ajax({
        url: base_url + "Ctrl_obtener/ObtenerActivos",
        type: 'post',
        data: {
            'tabla': tabla
        },
        success: function (data) {
            var response = JSON.parse(data);
            response = JSON.stringify(response.datos);
            callback(response);
        }
    });
}

function datosTabla(data) {
    var html = '<table class="table table-hover table-striped" id="tabla">' +
        '<thead class="text-center">' +
        '<tr class="thead-dark">' +
        '<th>ID</th>' +
        '<th>Rut</th>' +
        '<th>Nombre</th>' +
        '<th>Teléfono</th>' +
        '<th>Código</th>' +
        '<th>Proyecto</th>' +
        '<th>Dirección</th>' +
        '<th>Fecha Supervisor</th>' +
        '<th>Fecha prox./últ. visita</th>' +
        '<th>Días</th>' +
        '<th>Prioridad</th>' +
        '<th>Estado</th>' +
        '<th>Acción</th>' +
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {
        var funcion = "";
        $.each(response.datos, function (i, item) {
            var prioridad = nombrePrioridad(item.prioridad.prioridad);
            fecha_visita = ""; //ESTA ES LA DEL CONTRATISTA
            if (item.fecha_prox_visita != "No registra") {
                fecha_visita = item.fecha_prox_visita;
            }
            else {
                fecha_prox_visita = item.fecha_ultima_visita;
            }
            let datos = new Array(
                item.id_solicitud,
                '\'' + item.estado + '\'',
                '\'' + prioridad + '\'',
                '\'' + item.fecha + '\'',
                '\'' + item.dias + '\'',
                '\'' + item.cliente.clienteRut + '\'',
                '\'' + item.cliente.clienteNombre + '\'',
                '\'' + item.cliente.clienteTelefono + '\'',
                '\'' + item.comentario_cliente + '\'',
                '\'' + item.vivienda.viviendaFecharecepcion + '\'',
                '\'' + item.vivienda.viviendaProyecto + '\'',
                '\'' + item.vivienda.proyectoNombre + '\'',
                '\'' + item.vivienda.viviendaDireccion + '\'',
                '\'' + fecha_visita + '\'',
                item.id_estado
            );

            html += '<tr>';
            html += '<td>' + item.id_solicitud + '</td>';
            html += '<td>' + item.cliente.clienteRut + '</td>';
            html += '<td>' + item.cliente.clienteNombre + '</td>';
            html += '<td>' + item.cliente.clienteTelefono + '</td>';
            html += '<td>' + item.vivienda.viviendaProyecto + '</td>';
            html += '<td>' + item.vivienda.proyectoNombre + '</td>';
            html += '<td>' + item.vivienda.viviendaDireccion + '</td>';
            if (perfil == 9) {
                html += '<td>' + item.fecha_visita.split('-').reverse().join('/') + ' - ' + item.hora_visita + '</td>';
            }
            else {
                if (item.fecha_visita == null || item.fecha_visita == "") {
                    html += "<td></td>"
                }
                else {
                    html += '<td>' + item.fecha_visita.split('-').reverse().join('/') + ' - ' + item.hora_visita + '</td>';
                }
            }
            html += '<td>' + fecha_visita + '</td>';
            html += '<td>' + item.dias + '</td>';
            html += '<td><label class="badge badge-' + estiloPrioridad(item.prioridad.prioridad) + ' text-white rounded text-center">' + prioridad + '</label></td>';
            html += '<td><label class="badge badge-' + estiloEstados(item.id_estado) + ' text-white rounded text-center">' + item.estado + '</label></td>';
            html += '<td>';
            let funcion;
            /* 
            PERFILES :
            ADMIN = 2
            CALLCENTER = 16
            SUPERVISOR = 9
            JEFE PV = 17
            ADMINISTRATIVO PV = 18
            */
            pdf_conformidad = '<form  method="post" action="http://localhost/POSTVENTA/Supervisor/ctrl_supervisor/pdf_conformidad_supervisor"><input type="hidden" name="id_solicitud_pdf" value="' 
            + item.id_solicitud + '"><input type="hidden" name="rut_pdf" value="' + item.cliente.clienteRut 
            + '"><input type="hidden" name="nombre_pdf" value="' + item.cliente.clienteNombre 
            + '"><input type="hidden" name="telefono_pdf" value="' + item.cliente.clienteTelefono 
            + '"><input type="hidden" name="proyecto_pdf" value="' + item.vivienda.proyectoNombre
            + '"><input type="hidden" name="direccion_pdf" value="' + item.vivienda.viviendaDireccion 
            + '"><input type="submit" class="btn btn-danger btn-sm" value="PDF CONF."></form>';

            if (item.id_estado == 1) {

                funcion = "detalleSolicitud(" + datos + ");";

                switch (perfil) {
                    case 2:
                    case 16:
                    case 17:
                    case 18:
                        html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="' + funcion + '" title="Editar"></button> ';
                        break;

                }

            } else if (item.id_estado == 2) {

                funcion = "detalle_solicitud_asignada(" + item.id_solicitud + ",'" + item.fecha_visita.split('-').reverse().join('/') + "','" + item.hora_visita + "'," + datos + ");";
                switch (perfil) {
                    case 2:
                    case 9:
                        html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="' + funcion + '" title="Editar"></button> ';
                        break;
                }

            } else if (item.id_estado == 3) {

                funcion = "detalleSolicitud(" + datos + ");";

                switch (perfil) {
                    case 2:
                    case 16:
                    case 17:
                        html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="' + funcion + '" title="Editar"></button> ';
                        break;
                }
            }
            else if (item.id_estado == 4) {
                funcion = "detalle_solicitud_asignada(" + item.id_solicitud + ",'" + item.fecha_visita.split('-').reverse().join('/') + "','" + item.hora_visita + "'," + datos + ");";
                switch (perfil) {
                    case 9:
                        html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="' + funcion + '" title="Editar"></button>';
                        break;
                    case 16:
                    case 17:
                        html+= '<button class="btn btn-primary btn-sm fa fa-asterisk" onclick="reagendar_contratista('+item.id_solicitud+')" title="Re agendar contratista"></button>';
                        break;
                    case 2:
                        html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="' + funcion + '" title="Editar"></button>';
                        html+= '<button class="btn btn-primary btn-sm fa fa-asterisk" onclick="reagendar_contratista('+item.id_solicitud+')" title="Re agendar contratista"></button>';
                    break;
                }
            }
            else if (item.id_estado == 5 || item.id_estado == 6) {
                switch (perfil) {
                    case 2:
                    case 9:
                    case 16:
                    case 17:
                    case 18:
                        html+= '<button class="btn btn-primary btn-sm fa fa-asterisk" onclick="ver_detalle('+item.id_solicitud+')" title="Ver detalle"></button>';

                        if (item.id_estado == 5) {
                            html += pdf_conformidad;
                        }
                    break;
                }
            }

            html += '</td>';
            html += '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';
        $("#datos").html(html);
        tabla_exportar('tabla');
    }
}

function detalleSolicitud(a, b, c, d, e, f, g, h, i, j, k, l, m, n, o) {

    $('#id_solicitud').val(a);
    $('#solicitud_numero').html("DATOS GENERALES DE LA SOLICITUD N° "+a);
    $('#estado').val(b)
    $('#prioridad').val(c);
    $('#fecha').val(d);
    $('#dias').val(e);
    $('#cliente_rut').val(f);
    $('#cliente_nombre').val(g);
    $('#cliente_telefono').val(h);
    $('#cliente_comentario').val(i);
    $('#vivienda_fecha').val(j);
    $('#vivienda_codigo').val(k);
    $('#vivienda_nombre').val(l);
    $('#vivienda_direccion').val(m);

    if (o == 1 || o == 2 || o == 5 || o == 6) {
        obtenerSucesos(a);
        obtenerHistorial(a);
    } else if (o == 3) {
        obtenerHistorial(a);
        sucesosContratista(a);
    }

    verModal('modal');
}

function obtenerSucesos(id_solicitud) {
    $.ajax({
        url: base_url + "Clientes/Ctrl_solicitudes/Sucesos",
        type: 'post',
        data: {
            'id': id_solicitud
        },
        success: function (data) {
            ListarSucesos(data);
        }
    });
}

function ListarSucesos(data) {

    contador = 1;

    var html = '<table class="table table-hover table-striped" id="sucesos">' +
        '<thead class="text-center">' +
        '<tr class="thead-dark">' +
        '<th>#</th>' +
        '<th>Suceso</th>' +
        '<th>Origen</th>' +
        '<th>Prioridad</th>' +
        '<th>Estado</th>' +
        /* '<th>Observación</th>' +
        '<th>Motivo Rechazo</th>' + */
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);
    console.log(response);
    if (response.registros === 0) {
        html += '';
    } else {

        $.each(response.datos, function (i, item) {

            html += '<tr>';
            html += '<td>' + contador + '</td>';
            html += '<td>' + item.suceso + '</td>';
            html += '<td>' + item.origen + '</td>';
            html += '<td><label class="badge badge-' + estiloPrioridad(item.prioridad) + ' text-white rounded text-center">' + nombrePrioridad(item.prioridad) + '</label></td>';
            html += '<td><label class="badge badge-' + estiloEstados(item.id_estado) + ' text-white rounded text-center">' + item.estado + '</label></td>';
            /*  html += '<td>' + item.observacion + '</td>';
             html += '<td>' + item.otro_motivo_rechazo + '</td>'; */
            html += '</tr>';

            contador++;
        });
        html += '</tbody></table>';
        $("#datos_sucesos").html(html);
        tabla_exportar('sucesos');

    }
}

function obtenerHistorial(id_solicitud) {

    $.ajax({
        url: base_url + "Clientes/Ctrl_solicitudes/Historial",
        type: 'post',
        data: {
            'id': id_solicitud
        },
        success: function (data) {
            ListarHistorial(data);
        }
    });

}

function ListarHistorial(data) {

    contador = 1;

    var html = '<table class="table table-hover table-striped" id="historial">' +
        '<thead class="text-center">' +
        '<tr class="thead-dark">' +
        '<th>#</th>' +
        '<th>Rut</th>' +
        '<th>Nombre</th>' +
        '<th>Correo</th>' +
        '<th>Fecha</th>' +
        '<th>Estado</th>' +
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {

        $.each(response.datos, function (i, item) {

            html += '<tr>';
            html += '<td>' + contador + '</td>';

            if (item.usuario == null) {

                html += '<td>' + item.cliente.clienteRut + '</td>';
                html += '<td>' + item.cliente.clienteNombre + '</td>';
                html += '<td>' + item.cliente.clienteCorreo + '</td>';

            } else if (item.cliente == null) {

                html += '<td>' + item.usuario.usuarioRut + '</td>';
                html += '<td>' + item.usuario.usuarioNombre + '</td>';
                html += '<td>' + item.usuario.usuarioEmail + '</td>';
            }

            html += '<td>' + item.fecha + '</td>';
            html += '<td><label class="badge badge-' + estiloEstados(item.id_estado) + ' text-white rounded text-center">' + item.estado + '</label></td>';
            html += '</tr>';

            contador++;
        });
        html += '</tbody></table>';
        $("#datos_historial").html(html);
        tabla_exportar('historial');
    }

}


//FUNCIONES PARA AGENDAR VISITA DE SUPERVISOR POR CALLCENTER

function obtenerSupervisores() {
    $.ajax({
        url: base_url + "Ctrl_obtener/obtenerSupervisores",
        type: 'get',
        success: function (data) {

            var select;
            var select2;
            var response = $.parseJSON(data);
            response = Object.create(response);
            select2 = '<option value="0">Todos los Supervisores</option>';
            $.each(response.datos, function (i, item) {
                if (item.usuarioEstado == 1) {
                    select += '<option value="' + item.idusuario + '">' + item.usuarioNombre + '</option>';
                    select2 += '<option value="' + item.idusuario + '">' + item.usuarioNombre + '</option>';
                }
            });
            $('#supervisores').html(select).selectpicker("refresh");
            $('#supervisores_agenda').html(select2).selectpicker("refresh");
        }
    });
}

function buscarAgendaSupervisor() {

    $.ajax({
        url: base_url + "Ctrl_obtener/buscarAgendaSupervisor",
        type: 'post',
        data: {
            'id_supervisor': $('#supervisores').val(),
            'fecha_visita': $('#buscar_fecha').val()
        },
        success: function (data) {

            var response = $.parseJSON(data);
            response = Object.create(response);

            let fecha_seleccionada = $('#buscar_fecha').val();

            $('#fecha_seleccionada').html(fecha_seleccionada);

            let mensaje;

            if (fecha_seleccionada == '') {
                mensaje = 'Seleccione un día para ver horario del Supervisor';
                inhabilitar('boton_guardar');
            } else {
                mensaje = 'Seleccione una hora disponible para la visita para el día ' + $('#buscar_fecha').val() + ' y presione GUARDAR';
                /* habilitar('boton_guardar'); */
            }
            $('#mensaje').html(mensaje);

            if (response.registros === 0) {

            } else {

                $.each(response.datos, function (i, item) {

                    switch (item.hora_visita) {

                        case '08:00':
                            /* CheckSi('08:00'); */
                            inhabilitar('08:00');
                            break;
                        case '08:30':
                            /* CheckSi('08:30'); */
                            inhabilitar('08:30');
                            break;
                        case '09:00':
                            /* CheckSi('09:00'); */
                            inhabilitar('09:00');
                            break;
                        case '09:30':
                            /* CheckSi('09:30'); */
                            inhabilitar('09:30');
                            break;
                        case '10:00':
                            /* CheckSi('10:00'); */
                            inhabilitar('10:00');
                            break;
                        case '10:30':
                            /* CheckSi('10:00'); */
                            inhabilitar('10:30');
                            break;
                        case '11:00':
                            /* CheckSi('11:00'); */
                            inhabilitar('11:00');
                            break;
                        case '11:30':
                            /* CheckSi('11:30'); */
                            inhabilitar('11:30');
                            break;
                        case '12:00':
                            /* CheckSi('12:00'); */
                            inhabilitar('12:00');
                            break;
                        case '12:30':
                            /* CheckSi('12:30'); */
                            inhabilitar('12:30');
                            break;
                        case '13:00':
                            /* CheckSi('13:00'); */
                            inhabilitar('13:00');
                            break;
                        case '15:00':
                            /* CheckSi('15:00'); */
                            inhabilitar('15:00');
                            break;
                        case '15:30':
                            /* CheckSi('15:30'); */
                            inhabilitar('15:30');
                            break;
                        case '16:00':
                            /* CheckSi('16:00'); */
                            inhabilitar('16:00');
                            break;
                        case '16:30':
                            /* CheckSi('16:30'); */
                            inhabilitar('16:30');
                            break;
                        case '17:00':
                            /* CheckSi('17:00'); */
                            inhabilitar('17:00');
                            break;
                        case '17:30':
                            /* CheckSi('17:30'); */
                            inhabilitar('17:30');
                            break;
                        case '18:00':
                            /* CheckSi('18:00'); */
                            inhabilitar('18:00');
                            break;
                        case '18:30':
                            /* CheckSi('18:30'); */
                            inhabilitar('18:30');
                            break;

                    }
                });

            }
        }
    });
}

function limpiarFecha() {
    $('#buscar_fecha').val('');
    limpiarHorario();
}

function limpiarHorario() {
    document.getElementById("form_horario").reset();
    habilitar('08:00');
    habilitar('08:30');
    habilitar('09:00');
    habilitar('09:30');
    habilitar('10:00');
    habilitar('10:30');
    habilitar('11:00');
    habilitar('11:30');
    habilitar('12:00');
    habilitar('12:30');
    habilitar('13:00');
    habilitar('15:00');
    habilitar('15:30');
    habilitar('16:00');
    habilitar('16:30');
    habilitar('17:00');
    habilitar('17:30');
    habilitar('18:00');
    habilitar('18:30');
    inhabilitar('boton_guardar');

    buscarAgendaSupervisor();
}

function agendarSupervisor() {

    let fecha = $('#buscar_fecha').val();

    let mensaje = 'Confirma agendar al Supervisor ' + $('#supervisores').find('option:selected').text() + '<br> para el día ' + fecha + '<br> hora ' + valor_checkbox + '';

    Swal.fire({
        title: mensaje,
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI',
        cancelButtonText: 'NO',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "Ctrl_obtener/agendarSupervisor",
                type: 'post',
                data: {
                    'id_solicitud': $('#id_solicitud').val(),
                    'id_supervisor': $('#supervisores').val(),
                    'rut_cliente' : $('#cliente_rut').val(),
                    'fecha_visita': fecha,
                    'hora_visita': valor_checkbox
                },
                success: function (data) {
                    var response = $.parseJSON(data);
                    response = Object.create(response);
                    $.ajax({
                        url: base_url + "Ctrl_obtener/correo_de_asignacion",
                        type: 'post',
                        data: {
                            'id_solicitud': $('#id_solicitud').val(),
                            'id_supervisor': $('#supervisores').val(),
                            'rut_cliente' : $('#cliente_rut').val(),
                            'fecha_visita': fecha,
                            'hora_visita': valor_checkbox
                        },
                        success: function (respuesta) {
                            switch (response.estatus) {
                                case 200:
                                    alerta(2);
                                    ocultarModal('modal');
                                    setTimeout(location.reload(), 3000);
                                    break;
                                default:
                                    break;
                            }
                        }
                    });
                }
            });
        }
    })

    /*  alert(valor_checkbox);
 
     alert($('#supervisores').val());
     alert($('#buscar_fecha').val()); */
}

//FUNCIONES PARA AGENDAR VISITA DE SUPERVISOR POR CALLCENTER

//FUNCIONES PARA AGENDAR CONTRATISTA POR CALLCENTER

function obtenerContratistas() {
    $.ajax({
        url: base_url + "Ctrl_obtener/obtenerContratistas",
        type: 'get',
        success: function (data) {

            var select;
            var response = $.parseJSON(data);
            response = Object.create(response);
            select = '<option value="0">Todos los Contratistas</option>';
            $.each(response.datos, function (i, item) {
                select += '<option value="' + item.idusuario + '">' + item.usuarioNombre + '</option>';
            });
            $('#contratista_agenda').html(select).selectpicker("refresh");
        }
    });
}

function sucesosContratista(id_solicitud) {

    $.ajax({
        url: base_url + "Ctrl_obtener/sucesosContratista",
        type: 'post',
        data: {
            'id_solicitud': id_solicitud
        },
        success: function (data) {

            var response = $.parseJSON(data);
            response = Object.create(response);

            var contador = 1;
            var contador_tabla = 0;
            var html = '';

            $.each(response.datos, function (i, item) {

                html += '<div class="accordion md-accordion" id="accordionEx' + contador + '" role="tablist" aria-multiselectable="true">';
                html += '<div class="card collapse-icon accordion-icon-rotate border">';
                html += '<div class="card-header bg-' + estiloPrioridad(item.prioridad) + '" role="tab" id="heading' + contador + '">';
                html += '<a class="collapsed" data-toggle="collapse" data-parent="#accordionEx' + contador + '" href="#collapse' + contador + '" aria-expanded="false" aria-controls="collapse' + contador + '">';
                html += '<h6 class="mb-0 text-white">SUCESO #' + contador + ' / ' + item.suceso + ' / PRIORIDAD: ' + nombrePrioridad(item.prioridad) + '</h6>';
                html += '</a>';
                html += '</div>';
                html += '<div id="collapse' + contador + '" class="collapse" role="tabpanel" aria-labelledby="heading' + contador + '" data-parent="#accordionEx' + contador + '">';
                html += '<div class="card-body">';

                html += '<div class="row">';

                html += '<div class="col-md-3">';
                html += '<span><i class="ft ft-check"></i> Estado: </span>';
                html += '<input type="text" class="form-control" readonly value="' + item.estado + '" />';
                html += '</div>';

                html += '<div class="col-md-3">';
                html += '<span><i class="ft ft-check"></i> Suceso: </span>';
                html += '<input type="text" class="form-control" readonly value="' + item.suceso + '" />';
                html += '</div>';

                html += '<div class="col-md-3">';
                html += '<span><i class="ft ft-check"></i> Origen: </span>';
                html += '<input type="text" class="form-control" readonly value="' + item.origen + '" />';
                html += '</div>';

                html += '<div class="col-md-3">';
                html += '<span><i class="ft ft-check"></i> Edmu: </span>';
                html += '<input type="text" class="form-control" readonly value="' + item.detalle + '" />';
                html += '</div>';

                html += '<div class="col-md-12">';
                html += '<span><i class="ft ft-check"></i> Observación: </span>';
                html += '<textarea class="form-control" readonly>' + item.observacion + '</textarea>';
                html += '</div>';

                html += '</div>';

                html += '<br>';

                html += '<div class="row">';

                html += '<div class="col-md-3">';
                html += '<h6><i class="ft ft-check"></i> Partidas</h6>';
                html += '</div>';

                html += '<div class="col-md-12">';

                html += '<table class="table table-hover table-striped">' +
                    '<thead class="text-center">' +
                    '<tr class="thead-dark">' +
                    '<th>Contratista</th>' +
                    '<th>Partida</th>' +
                    '<th>Unidad</th>' +
                    '<th>Fecha</th>' +
                    '<th>Hora</th>' +
                    '<th>Estado</th>' +
                    '<th>Acción</th>' +
                    '</tr>' +
                    '</thead><tbody class="text-center">';

                $.each(item.partidas, function (i, row) {

                    var fecha = row.fecha_inicio;
                    /* var fecha_formato = fecha.replace(' ', 'T'); */
                    var fecha_formato = fecha.split(' ');

                    html += '<tr>';

                    html += '<td><select class="form-control form-control-sm" id="id_contratista_' + contador_tabla + '">';
                    html += '<option value="' + row.id_contratista + '">' + row.contratista.usuarioNombre + '</option>';
                    $.each(listado_contratistas, function (i, value) {
                        html += '<option value="' + value.idusuario + '">' + value.usuarioNombre + '</option>';
                    });
                    html += '<select/></td>';

                    html += '<td>' + row.partida + '</td>';
                    html += '<td>' + row.unidad + '</td>';

                    /* html += '<td><input type="datetime-local" class="form-control form-control-sm" value="' + fecha_formato + '" id="nueva_fecha_' + contador_tabla + '"></td>'; */

                    html += '<td><input type="date" class="form-control form-control-sm" value="' + fecha_formato[0] + '" id="nueva_fecha_' + contador_tabla + '"></td>';
                    html += '<td><input type="time" class="form-control form-control-sm" value="' + fecha_formato[1] + '" id="nueva_hora_' + contador_tabla + '"></td>';

                    html += '<td>' + row.estado + '</td>';
                    html += '<td><button class="btn btn-primary btn-sm fa fa-edit" onclick="actualizarContratista(' + contador_tabla + ', ' + row.id_suceso_partidas + ')" title="Actualizar Contratista"></button></td>';
                    html += '</tr>';

                    contador_tabla++;
                });

                html += '</tbody></table>';

                html += '</div>';

                html += '</div>';

                html += '</br>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                contador++;
            });

            $('#datos_sucesos').html(html);
        }
    });

}

function actualizarContratista(contador, id_suceso_partidas) {

    var fecha = $('#nueva_fecha_' + contador).val();
    var hora = $('#nueva_hora_' + contador).val();
    var fecha_formato = fecha + ' ' + hora;

    var id_contratista = $('#id_contratista_' + contador).val();

    let mensaje = 'Confirma agendar <br> al Contratista: <br>' + $('#id_contratista_' + contador).find('option:selected').text() + '<br> para el día: <br>' + fecha_formato + '';

    Swal.fire({
        title: mensaje,
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI',
        cancelButtonText: 'NO',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "Ctrl_obtener/actualizarContratista",
                type: 'post',
                data: {
                    'id_suceso_partidas': id_suceso_partidas,
                    'id_contratista': id_contratista,
                    'fecha_inicio': fecha_formato,
                },
                success: function (data) {
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
    })
}



//FUNCIONES PARA AGENDAR CONTRATISTA POR CALLCENTER




