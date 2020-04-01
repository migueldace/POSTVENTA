<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center" >RESUMEN DE LAS SOLICITUDES</h4>
                    <h4 class="card-title text-center" id="resumen_total"></h4>
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
                    
                    <div class="col-md-12 offset-md-1 form-inline">

                        <div class="col-md-2 col-sm-12">
                            <div class="card-body text-center border-info">
                                <div class="card-content">
                                    <span class="info"><i class="ft ft-alert-triangle"></i> Ingresadas</span>
                                    <h3 class="display-5 blue-grey darken-1" id="ingresadas">0</h3>
                                    <span class="info" id="porcentaje_ingresadas">0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="card-body text-center border-warning">
                                <div class="card-content">
                                    <span class="warning"><i class="ft ft-check-square"></i> Asignadas</span>
                                    <h3 class="display-5 blue-grey darken-1" id="asignadas">0</h3>
                                    <span class="warning" id="porcentaje_asignadas">0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="card-body text-center border-success">
                                <div class="card-content">
                                    <span class="success"><i class="ft ft-edit"></i> Inspeccionadas</span>
                                    <h3 class="display-5 blue-grey darken-1" id="supervision">0</h3>
                                    <span class="success" id="porcentaje_supervision">0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="card-body text-center border-danger">
                                <div class="card-content">
                                    <span class="danger"><i class="ft ft-play"></i> En Proceso</span>
                                    <h3 class="display-5 blue-grey darken-1" id="proceso">0</h3>
                                    <span class="danger" id="porcentaje_proceso">0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="card-body text-center border">
                                <div class="card-content">
                                    <span class="default"><i class="ft ft-unlock"></i> Finalizadas</span>
                                    <h3 class="display-5 blue-grey darken-1" id="finalizadas">0</h3>
                                    <span class="default" id="porcentaje_finalizadas">0%</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="col-md-12 offset-md-1 form-inline">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <div class="card-body text-center border-danger">
                                <div class="card-content">
                                    <span class="danger"><i class="ft ft-x-circle"></i> Rechazadas Supervisor</span>
                                    <h3 class="display-5 blue-grey darken-1" id="rechazadas_supervisor">0</h3>
                                    <span class="danger" id="porcentaje_supervisor">0%</span>
                                </div>
                            </div>
                        </div>                    
                        <div class="col-md-4"></div>
                    </div>

                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/Solicitudes/resumen.js" type="text/javascript"></script>