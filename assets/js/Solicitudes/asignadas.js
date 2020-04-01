
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
            'estado': 2
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}
function detalle_solicitud_asignada(id, fecha_visita, hora_visita, id_s, estado, prioridad, fecha, dias, 
rut, nombre, telefono, comentario, rmo, cod_proyecto, proyecto, direccion, fecha_visita_contratista, estado2) { //ABRIR MODAL SUPERVISOR //LA FECHA NO ME SIRVE
    
    $.ajax({
        url: base_url + "Supervisor/ctrl_supervisor/detalle_ingresadas",
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

