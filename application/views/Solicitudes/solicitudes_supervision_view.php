<?php $this->load->view('Callcenter/librerias_calendario_view'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="ft ft-edit" style="font-size:36px;color:greis"></i> SOLICITUDES EN SUPERVISIÓN
        </h2>
    </div>
</div>
<?php $this->load->view('Solicitudes/solicitudes_resumen_view'); ?>

<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">DATOS ACTUALES</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="col-12 col-md-6">
                        <div class="form-inline" style="display: none;" id="carga">
                            <h4>
                                <i class="fa fa-spinner fa-spin" style="font-size:20px"></i> Cargando información...
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <button onclick="Nuevo()" class="btn btn-primary float-right col-md-1"><i class="fa fa-plus"></i> AGREGAR</button> -->
                        <div class="table-responsive" id="datos"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-edit"></i>
                    <span class="font-weight-bold">DETALLE DE LA SOLICITUD</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="example-tabs">

                    <?php $this->load->view('Solicitudes/solicitud_datos_generales_view'); ?>
                    <h3>Calendario Contratistas</h3>
                    <section class="scroll_modal">
                        <div class="row">
                            <div class="col-md-12">
                                <select onchange="calendarioContratistas(this.value)" class="selectpicker form-control col-md-6" id="contratista_agenda" name="contratista_agenda" data-container="body" data-live-search="true" data-size="10">
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="calendar" class="calendar"></div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                <button class="btn btn-outline-primary btn-sm" title="Guardar agenda de los Contratistas" onclick="agendarContratistas()">Guardar</button>
            </div>

        </div>
    </div>
</div>



<script src="<?= base_url() ?>assets/js/Solicitudes/supervision.js" type="text/javascript"></script>


