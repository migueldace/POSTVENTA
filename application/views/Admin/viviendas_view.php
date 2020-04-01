<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="fa fa-home" style="font-size:36px;color:greis"></i> VIVIENDAS
        </h2>
    </div>
</div>

<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">DATOS ACTUALES:
                        <div id="rut"><?= $rut; ?></div>
                    </h4>
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
                        <a href="<?= base_url() ?>/Admin/Ctrl_clientes" class="btn btn-link float-left" role="button" aria-disabled="true"><i class="fa fa-arrow-left"></i> VOLVER</a>                       
                        <button onclick="Nuevo()" class="btn btn-primary float-right col-md-1"><i class="fa fa-plus"></i> AGREGAR</button>
                        <div class="table-responsive" id="datos"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-edit"></i>
                    <span class="font-weight-bold">FORMULARIO VIVIENDAS</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_registro" action="javascript:Registro()">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" id="nombre_accion" style="display:none">
                            <input type="number" id="idvivienda" name="idvivienda" style="display:none">
                            <input type="text" id="viviendaClienterut" name="viviendaClienterut" style="display:none" value="<?= $rut; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Código Unysoft:</strong></span>
                            <input type="text" class="form-control" id="viviendaUnysoft" name="viviendaUnysoft" maxlength="12" onkeyup="formatoCliente(this)" required>
                        </div>

                        <div class="col-md-12 form-group" style="display: none;" id="alerta">
                            <div class="alert alert-icon-right alert-warning alert-dismissible mb-2" role="alert">
                                <strong>Advertencia! </strong>
                                <span id="mensaje"></span>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Proyecto:</strong></span>
                            <input type="text" class="form-control" id="viviendaProyecto" name="viviendaProyecto" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Dirección:</strong></span>
                            <input type="text" class="form-control" id="viviendaDireccion" name="viviendaDireccion" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Fecha recepción:</strong></span>
                            <input type="date" class="form-control" id="viviendaFecharecepcion" name="viviendaFecharecepcion" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Tipo Vivienda:</strong></span>
                            <input type="text" class="form-control" id="viviendaTipo" name="viviendaTipo" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Modelo Vivienda:</strong></span>
                            <input type="text" class="form-control" id="viviendaModelo" name="viviendaModelo" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Arrendatario:</strong></span>
                            <select name="viviendaArrendatario" id="viviendaArrendatario" class="form-control">
                                <option value="1">SI</option>
                                <option value="0">NO</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Nombre Arrendatario:</strong></span>
                            <input type="text" class="form-control" id="viviendaNombreAr" name="viviendaNombreAr">
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Telefóno Arrendatario:</strong></span>
                            <input type="text" class="form-control" id="viviendaTelefonoAr" name="viviendaTelefonoAr">
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Correo Arrendatario:</strong></span>
                            <input type="text" class="form-control" id="viviendaCorreoAr" name="viviendaCorreoAr">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                    <input type="submit" class="btn btn-outline-primary btn-sm" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/Admin/viviendas.js" type="text/javascript"></script>