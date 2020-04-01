<h3>Datos Generales</h3>
<section>

    <input type="text" class="form-control" id="id_solicitud" style="display:none;" />

    <div class="row">
        <div class="col-md-12 text-center">
            <h3>DATOS GENERALES DE LA SOLICITUD</h3>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Estado Actual de la Solicitud: </span>
            <input type="text" class="form-control" id="estado" readonly />
        </div>
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Prioridad de la Solicitud: </span>
            <input type="text" class="form-control" id="prioridad" readonly />
        </div>
        <div class="col-md-2">
            <span><i class="ft ft-check"></i> Fecha de Registro: </span>
            <input type="text" class="form-control" id="fecha" readonly />
        </div>
        <div class="col-md-2">
            <span><i class="ft ft-check"></i> Días Transcurridos: </span>
            <input type="text" class="form-control" id="dias" readonly />
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Rut del Cliente: </span>
            <input type="text" class="form-control" id="cliente_rut" readonly />
        </div>
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Nombre del Cliente: </span>
            <input type="text" class="form-control" id="cliente_nombre" readonly />
        </div>
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Télefono del Cliente: </span>
            <input type="text" class="form-control" id="cliente_telefono" readonly />
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <span><i class="ft ft-check"></i> Comentarios del Cliente: </span>
            <textarea id="cliente_comentario" class="form-control" readonly></textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <span><i class="ft ft-check"></i> Fecha RMO: </span>
            <input type="text" class="form-control" id="vivienda_fecha" readonly />
        </div>
        <div class="col-md-2">
            <span><i class="ft ft-check"></i> C. Proyecto: </span>
            <input type="text" class="form-control" id="vivienda_codigo" readonly />
        </div>
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Nombre del Proyecto: </span>
            <input type="text" class="form-control" id="vivienda_nombre" readonly />
        </div>
        <div class="col-md-4">
            <span><i class="ft ft-check"></i> Dirección de la Vivienda: </span>
            <input type="text" class="form-control" id="vivienda_direccion" readonly />
        </div>
    </div>

</section>
<h3>Historial</h3>
<section class="scroll_modal">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>HISTORIAL DE LA SOLICITUD</h4>
        </div>
        <div class="table-responsive" id="datos_historial">
        </div>
    </div>
</section>
<h3>Sucesos</h3>
<section class="scroll_modal">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>SUCESOS DE LA SOLICITUD</h4>
        </div>
        <div id="datos_sucesos" class="col-md-12">
        </div>
    </div>
</section>

<style>
    .tabcontrol>.content>.body {
        overflow-y: auto;
    }
</style>