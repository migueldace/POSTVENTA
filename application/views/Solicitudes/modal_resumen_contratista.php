<div id="example-tabs" class="container card">
	<section>
    	<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $id_solicitud ?>">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS GENERALES DE LA SOLICITUD N° <?php echo $id_solicitud ?></b></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <span><i class="ft ft-check"></i> Estado Actual de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $estado ?>" readonly />
            </div>
            <div class="col-md-6">
                <span><i class="ft ft-check"></i> Prioridad de la Solicitud: </span>
                <input type="text" class="form-control" value="<?php echo $prioridad ?>" readonly />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Rut del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $rut ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Nombre del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $nombre ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Teléfono del Cliente: </span>
                <input type="text" class="form-control" value="<?php echo $telefono ?>" readonly />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <span><i class="ft ft-check"></i> Comentarios del Cliente: </span>
                <textarea class="form-control" readonly><?php echo $comentario ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                <span><i class="ft ft-check"></i> Fecha RMO: </span>
                <input type="text" class="form-control" value="<?php echo $rmo ?>" readonly />
            </div>
            <div class="col-md-2">
                <span><i class="ft ft-check"></i> Código del Proyecto: </span>
                <input type="text" class="form-control" value="<?php echo $cod_proyecto ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Nombre del Proyecto: </span>
                <input type="text" class="form-control" value="<?php echo $proyecto ?>" readonly />
            </div>
            <div class="col-md-4">
                <span><i class="ft ft-check"></i> Dirección de la Vivienda: </span>
                <input type="text" class="form-control" value="<?php echo $direccion ?>" readonly />
            </div>
        </div>

    </section><br>
    <section id="seccion_sucesos">
      <div class="row">
            <div class="col-md-12 text-center">
                <h3><b><i class="fa fa-angle-right"></i> DATOS DE LOS SUCESOS</b></h3>
            </div>
        </div>
    	<?php  $this->load->view("Solicitudes/tabla_suceso_partidas_contratista"); ?>
    	
    </section>
</div>