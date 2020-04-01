<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="fa fa-sitemap" style="font-size:36px;color:greis"></i> CATEGORÍAS
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
                    <span class="font-weight-bold">FORMULARIO CATEGORÍA</span>
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
                            <input type="number" id="id_categoria" name="id_categoria" style="display:none">
                        </div>
                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Nombre:</strong></span>
                            <input type="text" class="form-control" id="categoria" name="categoria" required>
                        </div>
                        

                        <div class="col-md-12 form-group" style="display: none;" id="alerta">
                            <div class="alert alert-icon-right alert-warning alert-dismissible mb-2" role="alert">
                                <strong>Advertencia! </strong>
                                <span id="mensaje"></span>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Garantía:</strong></span>
                            <select name="garantia" id="garantia" class="form-control">                                
                                <option value="1">1 AÑOS</option>
                                <option value="3">3 AÑOS</option>
                                <option value="5">5 AÑOS</option>
                                <option value="10">10 AÑOS</option>
                            </select>
                        </div>   
                        
                        <div class="col-md-12 form-group">
                            <i class="fa fa-pencil"></i>
                            <span><strong>Estado:</strong></span>
                            <select name="estado" id="estado" class="form-control">                                
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>                               
                            </select>
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

<script src="<?= base_url() ?>assets/js/Admin/categorias.js" type="text/javascript"></script>