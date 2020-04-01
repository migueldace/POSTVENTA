<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="ft ft-play" style="font-size:36px;color:greis"></i> SOLICITUDES EN PROCESO
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
<div class="modal fade text-left" id="modal_super" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-clipboard"></i>
                    <span class="font-weight-bold">RESUMEN DE LA SOLICITUD</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detalle">
                
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                <!-- <button id="imprimir" type="button" class="btn btn-outline-default btn-sm">Imprimir</button> -->
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/Solicitudes/proceso.js" type="text/javascript"></script>