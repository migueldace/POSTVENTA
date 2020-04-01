
const controlador = 'Ctrl_obtener/';

$(document).ready(function () {
    datosTabla(data = null);
    ListarTabla();
    obtenerSupervisores();    
});

function ListarTabla() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "SolicitudesEstados",
        type: 'post',
        data: {
            'estado': 1
        },
        success: function (data) {
            datosTabla(data);
            cargaNoVisible();
        }
    });
}






