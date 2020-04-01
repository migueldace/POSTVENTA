
const controlador = 'Admin/Ctrl_viviendas/';

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
            'rut': $('#rut').html()
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
        '<th>ID</th>' +
        '<th>Código</th>' +
        '<th>Proyecto</th>' +
        '<th>Dirección</th>' +
        '<th>Fecha</th>' +
        '<th>Tipo</th>' +
        '<th>Modelo</th>' +
        '<th>Arrendatario</th>' +
        '<th>Acción</th>' +
        '</tr>' +
        '</thead><tbody class="text-center">';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {

        $.each(response.datos, function (i, item) {

            let datos = new Array(
                item.idvivienda,
                '\'' + item.viviendaUnysoft + '\'',
                '\'' + item.viviendaProyecto + '\'',
                '\'' + item.viviendaDireccion + '\'',
                '\'' + item.viviendaFecharecepcion + '\'',
                '\'' + item.viviendaTipo + '\'',
                '\'' + item.viviendaModelo + '\'',
                '\'' + item.viviendaArrendatario + '\'',
                '\'' + item.viviendaNombreAr + '\'',
                '\'' + item.viviendaTelefonoAr + '\'',
                '\'' + item.viviendaCorreoAr + '\'',
            );

            html += '<tr>';
            html += '<td>' + item.idvivienda + '</td>';
            html += '<td>' + item.viviendaUnysoft + '</td>';
            html += '<td>' + item.viviendaProyecto + '</td>';
            html += '<td>' + item.viviendaDireccion + '</td>';
            html += '<td>' + item.viviendaFecharecepcion + '</td>';
            html += '<td>' + item.viviendaTipo + '</td>';
            html += '<td>' + item.viviendaModelo + '</td>';

            if (item.viviendaArrendatario == 1) {
                html += '<td><label class="badge badge-success text-white rounded text-center">SI</label></td>';
            } else {
                html += '<td><label class="badge badge-danger text-white rounded text-center">NO</label></td>';
            }

            html += '<td>';
            html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="Editar(' + datos + ')" title="Editar"></button> ';
            html += '</td>';
            html += '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';
        $("#datos").html(html);
        tabla_exportar('tabla');
    }
}

function Editar(id, viviendaUnysoft, viviendaProyecto, viviendaDireccion, viviendaFecharecepcion, viviendaTipo, viviendaModelo, viviendaArrendatario, viviendaNombreAr, viviendaTelefonoAr, viviendaCorreoAr) {
    invisible('alerta');
    $('#idvivienda').val(id);
    $('#viviendaUnysoft').val(viviendaUnysoft);
    $('#viviendaProyecto').val(viviendaProyecto);
    $('#viviendaDireccion').val(viviendaDireccion);
    $('#viviendaFecharecepcion').val(viviendaFecharecepcion);
    $('#viviendaTipo').val(viviendaTipo);
    $('#viviendaModelo').val(viviendaModelo);
    $('#viviendaArrendatario').val(viviendaArrendatario);
    $('#viviendaNombreAr').val(viviendaNombreAr);
    $('#viviendaTelefonoAr').val(viviendaTelefonoAr);
    $('#viviendaCorreoAr').val(viviendaCorreoAr);
    $('#nombre_accion').val('editar');
    verModal('modal');
}

function Nuevo() {
    invisible('alerta');
    $('#nombre_accion').val('nuevo');
    verModal('modal');
}

function Registro() {
    let funcion_controlador = $('#nombre_accion').val();

    if (funcion_controlador == 'nuevo') {
        funcion_controlador = 'nuevoRegistro';
    } else if (funcion_controlador == 'editar') {
        funcion_controlador = 'editarRegistro';
    }

    var formData = new FormData($("#form_registro")[0]);

    $.ajax({
        url: base_url + controlador + funcion_controlador,
        type: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            var response = $.parseJSON(data);
            response = Object.create(response);

            switch (response.estatus) {

                case 200:
                    alerta(2);
                    ocultarModal('modal');
                    ListarTabla();
                    break;

                case 401:
                    var mensaje = 'El Código "' + response.datos + '" ya esta registrado';
                    $('#mensaje').html(mensaje);
                    visible('alerta');
                    break;

                default:
                    break;
            }

        }
    });
}
