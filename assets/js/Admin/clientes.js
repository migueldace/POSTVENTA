
const controlador = 'Admin/Ctrl_clientes/';

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
        '<th>Rut</th>' +
        '<th>Correo</th>' +
        '<th>Nombre</th>' +
        '<th>Teléfono</th>' +
        '<th>Dirección</th>' +
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
                item.idcliente,
                '\'' + item.clienteRut + '\'',
                '\'' + item.clienteCorreo + '\'',
                '\'' + item.clienteNombre + '\'',
                '\'' + item.clienteTelefono + '\'',
                '\'' + item.clienteDireccion + '\'',
            );

            html += '<tr>';
            html += '<td>' + item.idcliente + '</td>';
            html += '<td>' + item.clienteRut + '</td>';
            html += '<td>' + item.clienteCorreo + '</td>';
            html += '<td>' + item.clienteNombre + '</td>';
            html += '<td>' + item.clienteTelefono + '</td>';
            html += '<td>' + item.clienteDireccion + '</td>';

            html += '<td>';
            html += '<button class="btn btn-primary btn-sm fa fa-edit" onclick="Editar(' + datos + ')" title="Editar"></button> ';
            html += '<a class="btn btn-warning btn-sm fa fa-home" href="' + base_url + 'Admin/ctrl_viviendas/index/' + item.clienteRut + '" role="button"></a>';
            html += '</td>';
            html += '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';
        $("#datos").html(html);
        tabla_exportar('tabla');
    }
}

function Editar(id, clienteRut, clienteCorreo, clienteNombre, clienteTelefono, clienteDireccion) {
    invisible('alerta');
    $('#idcliente').val(id);
    $('#clienteRut').val(clienteRut);
    $('#clienteCorreo').val(clienteCorreo);
    $('#clienteNombre').val(clienteNombre);
    $('#clienteTelefono').val(clienteTelefono);
    $('#clienteDireccion').val(clienteDireccion);
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
                    var mensaje = 'El Rut "' + response.datos + '" ya esta registrado';
                    $('#mensaje').html(mensaje);
                    visible('alerta');
                    break;

                default:
                    break;
            }

        }
    });
}

function formatoCliente(cliente) {
    cliente.value = cliente.value.replace(/[.-]/g, '')
        .replace(/^(\d{1,2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4')
}

function buscarRut() {

    invisible('alerta_rut');

    $.ajax({
        url: base_url + controlador + 'buscarRut',
        type: 'post',
        data: {
            'rut': $('#buscar_rut').val()
        },
        success: function (data) {

            if (data === '') {

                var mensaje = 'El Rut ' + $('#buscar_rut').val() + ' no registra datos, verificar información';
                $('#mensaje_rut').html(mensaje);
                visible('alerta_rut');

            } else {

                var response = $.parseJSON(data);
                response = Object.create(response);

                $.each(response, function (i, item) {
                   
                    $('#clienteRut').val(item.rut_cliente);
                    $('#clienteCorreo').val(item.email);
                    $('#clienteNombre').val(item.razon_social);
                    $('#clienteTelefono').val(item.telefono_uno);                   

                });   
                          
                invisible('alerta');
                $('#nombre_accion').val('nuevo');
                verModal('modal');

            }

        }
    });
}
