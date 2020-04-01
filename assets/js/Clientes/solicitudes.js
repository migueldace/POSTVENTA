
const controlador = 'Clientes/Ctrl_solicitudes/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "ListarTabla",
        type: 'post',
        data: {
            'id': $('#id_cliente').val()
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}

function datosTabla(data) {
    var html = '<table class="table table-hover table-striped" id="tabla">' +
        '<thead class="text-center">' +
        '<tr class="thead-dark">' +
        '<th>ID Solicitud</th>' +
        '<th>Tipo Viv.</th>' +
        '<th>Modelo Viv.</th>' +
        '<th>Dirección</th>' +
        '<th>Estado</th>' +
        '<th>Fecha</th>' +
        // '<th>Comentario</th>' +
        '<th>Detalle</th>' +
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {

        $.each(response.datos, function (i, item) {

            let datos = new Array(
                item.id_solicitud,
                '\'' + item.viviendas.viviendaTipo + '\'',
                '\'' + item.viviendas.viviendaModelo + '\'',
                '\'' + item.viviendas.viviendaDireccion + '\'',
                '\'' + item.viviendas.viviendaFecharecepcion + '\'',
                '\'' + item.estado + '\'',
                '\'' + item.fecha + '\'',
                '\'' + item.comentario_cliente + '\'',
            );           

            html += '<tr>';
            html += '<td>' + item.id_solicitud + '</td>';
            html += '<td>' + item.viviendas.viviendaTipo + '</td>';
            html += '<td>' + item.viviendas.viviendaModelo + '</td>';
            html += '<td>' + item.viviendas.viviendaDireccion + '</td>';
            html += '<td><label class="badge badge-' + estiloEstados(item.id_estado) + ' text-white rounded text-center">' + item.estado + '</label></td>';
            if (item.fecha == null || item.fecha == undefined) {
                html += '<td>Visita aún no programada</td>';
            }
            else {
                html += '<td>' + item.fecha + '</td>';
            }
            // html += '<td>' + item.comentario_cliente + '</td>';
            html += '<td>';
            html += '<button class="btn btn-warning btn-sm fa fa-eye" onclick="detalle(' + datos + ')" title="Editar"></button> ';
            html += '</td>';
            html += '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';
        $("#datos").html(html);
        tabla_exportar('tabla');
    }
}

function detalle(id_solicitud, viviendaTipo, viviendaModelo, viviendaDireccion, viviendaFecharecepcion, estado, fecha, comentario_cliente) {

    $('#estado').val(estado);
    $('#fecha').val(fecha);

    $('#viviendaTipo').val(viviendaTipo);
    $('#viviendaModelo').val(viviendaModelo);
    $('#viviendaDireccion').val(viviendaDireccion);
    $('#viviendaFecharecepcion').val(viviendaFecharecepcion);
    if (comentario_cliente == null || comentario_cliente == "null") {
        comentario_cliente = "";
    }
    $('#comentario_cliente').text(comentario_cliente);

    $.ajax({
        url: base_url + controlador + "Sucesos",
        type: 'post',
        data: {
            'id': id_solicitud
        },
        success: function (data) {
            ListarSucesos(data);
        }
    });

    $.ajax({
        url: base_url + controlador + "Historial",
        type: 'post',
        data: {
            'id': id_solicitud
        },
        success: function (data) {

        }
    });

    verModal('modal');
}

function ListarSucesos(data) {
    var html = '<table class="table table-hover table-striped" id="sucesos">' +
        '<thead class="text-center">' +
        '<tr class="thead-dark">' +
        '<th>ID Suceso</th>' +
        '<th>Suceso</th>' +
        '<th>Origen</th>' +
        '<th>Estado</th>' +
        '<th>Observación Supervisor</th>' +        
        '<th>Motivo Rechazo</th>' +        
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {

        $.each(response.datos, function (i, item) {            

            html += '<tr>';
            html += '<td>' + item.id_solicitud_suceso + '</td>';
            html += '<td>' + item.suceso + '</td>';
            html += '<td>' + item.origen + '</td>';
            html += '<td><label class="badge badge-' + estiloEstados(item.id_estado) + ' text-white rounded text-center">' + item.estado + '</label></td>';                    
            html += '<td>' + item.observacion + '</td>';
            otro_motivo_rechazo = "";
            if (item.otro_motivo_rechazo == null ||  item.otro_motivo_rechazo == "null") {
                otro_motivo_rechazo = "Suceso Vigente";
            }
            html += '<td>' + otro_motivo_rechazo + '</td>';            
            html += '</tr>';
        });
        html += '</tbody></table>';
        $("#datos_sucesos").html(html);
        
    }
}

