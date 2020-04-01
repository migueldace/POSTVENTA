
const controlador = 'Ctrl_obtener/';

var listado_contratistas = [];

var contador_tabla = 0;

$(document).ready(function () {

    $("#example-tabs").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        enableFinishButton: false,
        enablePagination: false,
        enableAllSteps: true,
        titleTemplate: "#title#",
        cssClass: "tabcontrol"
    });

    datosTabla(data = null);
    ListarTabla();
    listadoContratistas();

    var fecha = moment().format("YYYY-MM-DD");
    let horario = [];
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
    });
    obtenerContratistas();
    calendarioContratistas(0);
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "SolicitudesEstados",
        type: 'post',
        data: {
            'estado': 3
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}

function listadoContratistas() {
    $.ajax({
        url: base_url + "Ctrl_obtener/obtenerContratistas",
        type: 'get',
        success: function (data) {

            var response = $.parseJSON(data);
            response = Object.create(response);

            listado_contratistas = response.datos;
        }
    });
}

function agendarContratistas() {

    let mensaje = 'Confirma agendar <br> a los Contratistas <br> detallados en los <br>Sucesos';

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

            for (let index = 0; index < contador_tabla; index++) {
                actualizarContratista(index);
            }
            
            $.ajax({
                url: base_url + "Ctrl_obtener/agendarContratistas",
                type: 'post',
                data: {
                    'id_solicitud': $('#id_solicitud').val(),
                    'rut_cliente' : $('#cliente_rut').val()
                },
                success: function (data) {
                    var response = $.parseJSON(data);
                    response = Object.create(response);

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
    })

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
                    '<th>ID</th>' +
                    '<th>Contratista</th>' +
                    '<th>Partida</th>' +
                    '<th>Unidad</th>' +
                    '<th>Fecha</th>' +
                    '<th>Hora</th>' +
                    '<th>Estado</th>' +
                    '</tr>' +
                    '</thead><tbody class="text-center">';

                $.each(item.partidas, function (i, row) {

                    var fecha = row.fecha_inicio;
                    /* var fecha_formato = fecha.replace(' ', 'T'); */
                    var fecha_formato = fecha.split(' ');

                    html += '<tr>';

                    html += '<td id="id_suceso_partidas_' + contador_tabla + '">' + row.id_suceso_partidas + '</td>'
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
                    /*  html += '<td>';
                     html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="actualizarContratista(' + contador_tabla + ', ' + row.id_suceso_partidas + ')" title="Actualizar Contratista"></button> ';                    
                     html += '</td>'; */
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

function actualizarContratista(contador) {

    var fecha = $('#nueva_fecha_' + contador).val();
    var hora = $('#nueva_hora_' + contador).val();
    var id_suceso_partidas = $('#id_suceso_partidas_' + contador).html();

    var fecha_formato = fecha + ' ' + hora;

    var id_contratista = $('#id_contratista_' + contador).val();

    $.ajax({
        url: base_url + "Ctrl_obtener/actualizarContratista",
        type: 'post',
        data: {
            'id_suceso_partidas': id_suceso_partidas,
            'id_contratista': id_contratista,
            'fecha_inicio': fecha_formato,
        },
        success: function (data) {

        }
    });

    /*  let mensaje = 'Confirma agendar <br> al Contratista: <br>' + $('#id_contratista_' + contador).find('option:selected').text() + '<br> para el día: <br>' + fecha_formato + '';
 
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
     }) */
}









