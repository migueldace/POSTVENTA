
const controlador = 'Admin/Ctrl_estados/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "ListarTabla",
        type: 'get',
        data: {},
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
        '<th>Nombre</th>' +
        '<th>Detalle</th>' +        
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
                item.id_estado,
                '\'' + item.estado + '\'',
                '\'' + item.categoria_estado + '\'',               
            );            

            html += '<tr>';
            html += '<td>' + item.id_estado + '</td>';
            html += '<td>' + item.estado + '</td>';
            html += '<td>' + item.categoria_estado + '</td>';           

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

function Editar(id, estado, categoria_estado) {
    invisible('alerta');
    $('#id_estado').val(id);
    $('#estado').val(estado);
    $('#categoria_estado').val(categoria_estado);      
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
                    var mensaje = 'El Estado "' + response.datos + '" ya esta registrado';
                    $('#mensaje').html(mensaje);
                    visible('alerta');
                    break;

                default:
                    break;
            }

        }
    });
}
