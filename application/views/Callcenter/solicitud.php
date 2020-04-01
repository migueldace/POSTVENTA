<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <h2 class="content-header-title mb-0">
            <i class="fa fa-pencil-square-o" style="font-size:36px;color:greis"></i>NUEVA SOLICITUD DE ATENCIÓN POST-VENTA
        </h2>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card"> <!-- **** SECCION CLIENTE **** -->
                <div class="card-header">
                    <h4 class="card-title"><b>Rut del cliente</b></h4>
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
                        <div class="col-md-6">
                            <label for="userinput1"><strong>Rut</strong></label>
                            <input type="text" class="form-control" id="rut_buscar" name="rut_buscar" value="" placeholder="Rut sin punto ni guion" maxlength="9" minlength="8">
                            <p class="block-tag text-center">
                                <small class="badge badge-default badge-success">Rut sin puntos ni guión!</small>
                            </p>
                        </div>
                        <div class="col-md-6"><br>
                            <button type="button" class="btn btn-warning" id="boton_buscar">Buscar Cliente</button>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
                <div id="seccion_solicitud" class="container"></div>
            </div><!-- / card-->
        </div><!-- / col-12-->
    </div><!-- row -->
</div>
<script type="text/javascript">
    $("#boton_buscar").click(function(event){
        rut_cliente = $('#rut_buscar').val();
        if (rut_cliente.length == 8 || rut_cliente.length == 9) {
            var parametros = {
              "rut_cliente" : rut_cliente
            };
            $.ajax({
                data: parametros,
                url: '<?php echo base_url() ?>Callcenter/ctrl_callcenter/datos_solicitud',
                type:  'post',
                beforeSend: function () {
                    $('#seccion_solicitud').html('<center><h2>Espere por favor....</h2></center><hr><center><i class="fa fa-spinner fa-5x fa-spin" aria-hidden="true"></i></center>');
                },
                success:  function (response) {
                    $('#seccion_solicitud').html(response);
                }
            });
        }
        else {
            Swal.fire("Atención!", "El rut debe contener al menos 8 digitos", "warning");
        }
            
    });
    <?php
      if($this->session->flashdata('mensaje')){ ?>                    
        Swal.fire("Exito!", "<?php echo $this->session->flashdata('mensaje');?>", "success");
    <?php 
        }
    ?>
</script>

