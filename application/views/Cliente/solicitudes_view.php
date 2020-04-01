<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="fa fa-question" style="font-size:36px;color:greis"></i> MIS SOLICITUDES
        </h2>
    </div>
</div>

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
                        <a class="btn btn-primary float-right" href="<?= base_url(); ?>ctrl_cliente/solicitud" role="button"><i class="fa fa-plus"></i> Nueva Solicitud</a>
                        <div class="table-responsive" id="datos"></div>
                        <input type="text" value="<?= $_SESSION['id_cliente']; ?>" id="id_cliente" style="display:none;">
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
                    <i class="ft ft-clipboard"></i>
                    <span class="font-weight-bold">RESUMEN DE LA SOLICITUD</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_registro" action="javascript:Registro()">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Estado Actual: </span>
                            <input type="text" class="form-control" id="estado" readonly />
                        </div>
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Fecha de Registro: </span>
                            <input type="text" class="form-control" id="fecha" readonly />
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="fa fa-angle-right"></i> Información de la Vivienda</h4>
                        </div>
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Tipo Vivienda: </span>
                            <input type="text" class="form-control" id="viviendaTipo" readonly />
                        </div>
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Modelo: </span>
                            <input type="text" class="form-control" id="viviendaModelo" readonly />
                        </div>
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Año Recepción: </span>
                            <input type="text" class="form-control" id="viviendaFecharecepcion" readonly />
                        </div>
                        <div class="col-md-6">
                            <span><i class="ft ft-check"></i> Dirección: </span>
                            <input type="text" class="form-control" id="viviendaDireccion" readonly />
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="fa fa-angle-right"></i> Datos Adicionales</h4>
                        </div>
                        <div class="col-md-12">
                            <span><i class="ft ft-check"></i> Mis Comentarios: </span>
                            <textarea class="form-control" id="comentario_cliente" readonly> </textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="fa fa-angle-right"></i> Resumen de la Solicitud</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" id="datos_sucesos"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                    <button id="imprimir" type="button" class="btn btn-outline-default btn-sm">Imprimir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/Clientes/solicitudes.js" type="text/javascript"></script>

