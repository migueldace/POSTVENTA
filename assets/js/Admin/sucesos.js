
const controlador = 'Admin/Ctrl_sucesos/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
    CategoriasActivas();
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
        '<th>Prioridad</th>' +
        '<th>Categoría</th>' +
        '<th>Estado</th>' +
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
                item.id_suceso,
                '\'' + item.suceso + '\'',
                '\'' + item.prioridad + '\'',
                item.id_categoria,
                item.estado
            );

            html += '<tr>';
            html += '<td>' + item.id_suceso + '</td>';
            html += '<td>' + item.suceso + '</td>';           

            if (item.prioridad == 1) {
                html += '<td><label class="badge badge-danger text-white rounded text-center">ALTA</label></td>';
            } else  if (item.prioridad == 2){
                html += '<td><label class="badge badge-warning text-white rounded text-center">MEDIA</label></td>';
            }else if (item.prioridad == 3){
                html += '<td><label class="badge badge-success text-white rounded text-center">BAJA</label></td>';
            }

            html += '<td>' + item.categoria + '</td>';

            if (item.estado == 1) {
                html += '<td><label class="badge badge-success text-white rounded text-center">ACTIVO</label></td>';
            } else {
                html += '<td><label class="badge badge-danger text-white rounded text-center">INACTIVO</label></td>';
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

function Editar(id, suceso, prioridad, categoria, estado) {
    invisible('alerta');
    $('#id_suceso').val(id);
    $('#suceso').val(suceso);
    $('#prioridad').val(prioridad);
    $('#categoria').val(categoria);
    $('#categoria').change();
    $('#estado').val(estado);
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
                    var mensaje = 'El Suceso "' + response.datos + '" ya esta registrado';
                    $('#mensaje').html(mensaje);
                    visible('alerta');
                    break;

                default:
                    break;
            }

        }
    });
}

function CategoriasActivas() {
    ObtenerActivos('categorias', function (datos) {
        var select;
        var response = $.parseJSON(datos);        
        $.each(response, function (i, item) {
            select += '<option value="' + item.id_categoria + '">' + item.categoria + '</option>';
        });
        $('#categoria').html(select).selectpicker("refresh");
    });
}
