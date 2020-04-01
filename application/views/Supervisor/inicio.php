
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="fa fa-pencil-square-o" style="font-size:36px;color:greis"></i>Inspecciones Supervisor
        </h2>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url() ?>ctrl_cliente/ingresar_solicitud" method="post" id="formulario_solicitud">
                <div class="card"> <!-- **** SECCION CLIENTE **** -->
                    <div class="card-header">
                        <h4 class="card-title"><b>Solicitudes</b></h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="row col-md-12">
                                
                            <?php  
                            // if ($estado_actual == 2) {
                           	// 	//$this->load->view('supervisor/tabla_pendientes');
                            // }
                            // else {
                            // 	//$this->load->view('supervisor/tabla_contratistas');
                            // }
                            ?>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div><!-- / card-->
            </form>
        </div>
    </div>
</div>
