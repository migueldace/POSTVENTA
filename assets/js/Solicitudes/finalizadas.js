
const controlador = 'Ctrl_obtener/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();

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
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "SolicitudesEstados",
        type: 'post',
        data: {
            'estado': 5
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}
function ver_detalle(id_solicitud) {
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
                        url: base_url + "Callcenter/ctrl_callcenter/reagendar_contratista",
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
                });

            }
        }
    });
}