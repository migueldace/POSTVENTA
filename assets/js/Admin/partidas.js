
const controlador = 'Admin/Ctrl_partidas/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
    categoriasActivas();
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
        '<th>Partida</th>' +
        '<th>Categoría</th>' +
        '<th>Precio</th>' +
        '<th>Unidad</th>' +
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
                item.id_partida,                
                '\'' + item.partida + '\'',
                item.id_categoria,
                item.precio,
                '\'' + item.unidad + '\'',
                item.estado
            );            

            html += '<tr>';
            html += '<td>' + item.id_partida + '</td>';
            html += '<td>' + item.partida + '</td>';
            html += '<td>' + item.categoria + '</td>';
            html += '<td>$ ' + formatoNumero(item.precio) + '</td>';
            html += '<td>' + item.unidad + '</td>';

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

function Editar(id, partida, categoria, precio, unidad, estado) {
    invisible('alerta');
    $('#id_partida').val(id);
    $('#partida').val(partida);
    $('#categoria').val(categoria); 
    $('#categoria').change();   
    $('#precio').val(precio); 
    $('#unidad').val(unidad); 
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
                    var mensaje = 'La Partida "' + response.datos + '" ya esta registrada';
                    $('#mensaje').html(mensaje);
                    visible('alerta');
                    break;

                default:
                    break;
            }

        }
    });
}

function categoriasActivas() {
    ObtenerActivos('categorias', function (datos) {
        var select;
        var response = $.parseJSON(datos);        
        $.each(response, function (i, item) {
            select += '<option value="' + item.id_categoria + '">' + item.categoria + '</option>';
        });
        $('#categoria').html(select).selectpicker("refresh");
    });
}
