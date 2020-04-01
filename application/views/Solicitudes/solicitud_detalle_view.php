<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title">
                    <i class="ft ft-edit"></i>
                    <span class="font-weight-bold" >DETALLE DE LA SOLICITUD</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="example-tabs">
                    <h3>Datos Generales</h3>
                    <section>

                        <input type="text" class="form-control" id="id_solicitud" style="display:none;" />

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3 id='solicitud_numero'>DATOS GENERALES DE LA SOLICITUD</h3>
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
                                <span><i class="ft ft-check"></i> Código: </span>
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
                            <div class="table-responsive" id="datos_sucesos">
                            </div>
                        </div>
                    </section>
                    <?php 
                        if ($this->session->userdata('id_perfil') == 2 or $this->session->userdata('id_perfil') == 16 or $this->session->userdata('id_perfil') == 18) {
                    ?>
                        <h3>Agendar Visita</h3>
                        <section class="scroll_modal">

                            <form id="form_registro" action="javascript:buscarAgendaSupervisor()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Seleccione Supervisor</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6>Seleccione Fecha</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <select onchange="limpiarFecha()" class="selectpicker form-control" id="supervisores" name="supervisores" data-container="body" data-live-search="true" data-size="10">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input onchange="limpiarHorario()" type="date" name="buscar_fecha" id="buscar_fecha" class="form-control" required>
                                        <!--  <div class="input-group input-append date" id="datePicker">
                                            <input type="text" class="form-control" name="buscar_fecha" id="buscar_fecha" required/>
                                            <span class="input-group-addon add-on"></span>
                                        </div> -->
                                    </div>
                                    <!-- <div class="col-md-2">
                                        <button class="btn btn-success"><i class="ft ft-search"></i> Buscar Agenda</button>
                                    </div> -->
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="alert alert-icon-right alert-warning alert-dismissible mb-2" role="alert">
                                            <strong>Advertencia! </strong>
                                            <span id="mensaje"> Seleccione un día para ver horario del Supervisor</span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <br>
                            <hr>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5>HORARIO SUPERVISOR: <strong><span id="fecha_seleccionada"></span></strong></h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <label class="custom-control-label">Disponible</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" disabled>
                                                <label class="custom-control-label">No Disponible</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="checked">
                                                <label class="custom-control-label">Asignado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <form id="form_horario" action="javascript:agendarSupervisor()">

                                <div class="row">
                                    <div class="col-md-6 border-success">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5>MAÑANA</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="08:00" value="08:00" name=type>
                                                    <label class="custom-control-label" for="08:00">08:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="08:30" value="08:30" name=type>
                                                    <label class="custom-control-label" for="08:30">08:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="09:00" value="09:00" name=type>
                                                    <label class="custom-control-label" for="09:00">09:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="09:30" value="09:30" name=type>
                                                    <label class="custom-control-label" for="09:30">09:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="10:00" value="10:00" name=type>
                                                    <label class="custom-control-label" for="10:00">10:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="10:30" value="10:30" name=type>
                                                    <label class="custom-control-label" for="10:30">10:30</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="11:00" value="11:00" name=type>
                                                    <label class="custom-control-label" for="11:00">11:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="11:30" value="11:30" name=type>
                                                    <label class="custom-control-label" for="11:30">11:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="12:00" value="12:00" name=type>
                                                    <label class="custom-control-label" for="12:00">12:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="12:30" value="12:30" name=type>
                                                    <label class="custom-control-label" for="12:30">12:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="13:00" value="13:00" name=type>
                                                    <label class="custom-control-label" for="13:00">13:00</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-6 border-primary">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5>TARDE</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="15:00" value="15:00" name=type>
                                                    <label class="custom-control-label" for="15:00">15:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="15:30" value="15:30" name=type>
                                                    <label class="custom-control-label" for="15:30">15:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="16:00" value="16:00" name=type>
                                                    <label class="custom-control-label" for="16:00">16:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="16:30" value="16:30" name=type>
                                                    <label class="custom-control-label" for="16:30">16:30</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="17:00" value="17:00" name=type>
                                                    <label class="custom-control-label" for="17:00">17:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="17:30" value="17:30" name=type>
                                                    <label class="custom-control-label" for="17:30">17:30</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="18:00" value="18:00" name=type>
                                                    <label class="custom-control-label" for="18:00">18:00</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="18:30" value="18:30" name=type>
                                                    <label class="custom-control-label" for="18:30">18:30</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="submit" class="btn btn-success btn-sm" value="Guardar" id="boton_guardar" disabled>
                                </div>

                            </form>

                        </section>
                    <?php } ?>
                </div>

            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" value="Cerrar">
                <!--  <input type="submit" class="btn btn-outline-primary btn-sm" value="Guardar"> -->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var valor_checkbox;

    $(document).ready(function() {

        $("#example-tabs").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            titleTemplate: "#title#",
            cssClass: "tabcontrol"
        });

        $("input:checkbox").on('click', function() {
            var $box = $(this);

            valor_checkbox = $(this).val();

            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
                habilitar('boton_guardar');
            } else {
                $box.prop("checked", false);
            }
        });

        /* $('#datePicker').datepicker(); */
    });
</script>

<style>
    .scroll_modal {
        max-height: auto;
        overflow-y: scroll;
    }
    .custom-control-input:disabled~.custom-control-label::before {
        background-color: #D76060;
    }
</style>
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script> -->