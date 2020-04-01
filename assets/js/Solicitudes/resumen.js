
$(document).ready(function () {
    ListarResumen();
});

function ListarResumen() {
    cargaVisible();
    $.ajax({
        url: base_url + controlador + "SolicitudesEstados",
        type: 'post',
        data: {
            'estado': 0
        },
        success: function (data) {
            datosResumen(data);
            cargaNoVisible();
        }
    });
}

function datosResumen(data) {

    var html = '';

    var response = $.parseJSON(data);
    response = Object.create(response);

    if (response.registros === 0) {
        html += '';
    } else {

        var total_solicitudes = 0;

        $.each(response.datos, function (i, item) {

            total_solicitudes = parseInt(item.total) + total_solicitudes;
        });

        $.each(response.datos, function (i, item) {

            switch (item.id_estado) {

                case '1':
                    $('#ingresadas').html(item.total);
                    $('#porcentaje_ingresadas').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
                case '2':
                    $('#asignadas').html(item.total);
                    $('#porcentaje_asignadas').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
                case '3':
                    $('#supervision').html(item.total);
                    $('#porcentaje_supervision').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
                case '4':
                    $('#proceso').html(item.total);
                    $('#porcentaje_proceso').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
                case '5':
                    $('#finalizadas').html(item.total);
                    $('#porcentaje_finalizadas').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
                case '6':
                    $('#rechazadas_supervisor').html(item.total);
                    $('#porcentaje_supervisor').html(Math.round((item.total * 100) / total_solicitudes) + '%');
                    break;
            }

        });
        $('#resumen_total').html("TOTAL: "+total_solicitudes);
    }
}