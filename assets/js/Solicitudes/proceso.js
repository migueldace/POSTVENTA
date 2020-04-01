
const controlador = 'Ctrl_obtener/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "SolicitudesEstados",
        type: 'post',
        data: {
            'estado': 4
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}
function detalle_solicitud_asignada(id, fecha_visita, hora_visita, id_s, estado, prioridad, fecha, dias, 
rut, nombre, telefono, comentario, rmo, cod_proyecto, proyecto, direccion, fecha_visita_contratista, estado2) { //ABRIR MODAL SUPERVISOR //LA FECHA NO ME SIRVE
    
    $.ajax({ //AQUI DEBO ABRIR OTRO MODAL
        url: base_url + "Supervisor/ctrl_supervisor/inspeccion_final",
        type: 'post',
        data: {
            'id_solicitud': id, 
            'fecha_visita': fecha_visita, 
            'hora_visita': hora_visita, 
            'estado': estado, 
            'prioridad': prioridad, 
            'rut': rut, 
            'nombre': nombre, 
            'telefono': telefono, 
            'comentario': comentario, 
            'rmo': rmo, 
            'cod_proyecto': cod_proyecto, 
            'proyecto': proyecto, 
            'direccion': direccion,
            'fecha_visita_contratista' : fecha_visita_contratista
        },
        success: function (data) {
            $("#modal_super").modal('show');
            $("#detalle").html(data);
        }
    });
}
function reagendar_contratista(id_solicitud) {
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



