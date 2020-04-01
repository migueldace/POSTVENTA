<form action="<?php echo base_url() ?>Callcenter/ctrl_callcenter/ingresar_solicitud" method="post" id="formulario_solicitud">
    <div class="card"> <!-- **** SECCION CLIENTE **** -->
        <div class="card-header">
            <h4 class="card-title"><b>Datos del solicitante</b></h4>
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
                    <?php 
                    $id_cliente = 0;
                    $rut_cliente = $nombre_cliente = $fono_cliente = $correo_cliente = $direccion_cliente = "";
                    foreach ($cliente as $c) {
                        $id_cliente = $c->idcliente;
                        $rut_cliente = $c->clienteRut;
                        $nombre_cliente = $c->clienteNombre;
                        $fono_cliente = $c->clienteTelefono;
                        $correo_cliente = $c->clienteCorreo;
                        $direccion_cliente = $c->clienteDireccion;
                    }
                    ?>
                    <input type="text" class="form-control" readonly id="mi_rut" name="mi_rut" value="<?php echo $rut_cliente?>">
                    <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $id_cliente ?>">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Nombre</strong></label>
                    <input type="text" class="form-control" id="mi_nombre" name="mi_nombre" value="<?php echo $nombre_cliente?>">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Teléfono contacto</strong></label>
                    <input type="text" class="form-control" id="mi_telefono" name="mi_telefono" value="<?php echo $fono_cliente ?>">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Correo Eléctronico</strong></label>
                    <input type="email" class="form-control" id="mi_correo" name="mi_correo" value="<?php echo $correo_cliente; ?>">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Dirección Particular</strong></label>
                    <input type="text" class="form-control" name="mi_direccion" id="mi_direccion" value="<?php echo $direccion_cliente ?>">
                </div><br>
                <div class="col-md-6" align="right"><br>
                    <button type="button" class="btn btn-warning" id="boton_actualizar">Actualizar datos de contacto</button>
                    <br>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div><!-- / card-->
    <div class="card"> <!-- **** SECCION VIVIENDA **** -->
        <div class="card-header">
            <h4 class="card-title"><b>Datos de la vivienda afectada</b></h4>
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
                <div class="form-group col-md-6">
                    <label for="userinput1"><strong>Proyecto</strong></label>
                    <select class="select2 form-control" id="proyecto" name="proyecto" data-live-search="true">
                        <option value="" id="proyecto_vacio">Seleccione su Proyecto</option>
                        <?php 
                        foreach ($proyectos as $p) {
                            $proyecto = $p->proyectoCentrocosto;
                            foreach ($vivienda as $v) {
                                $proyecto_v = $v->viviendaProyecto;
                                if ($proyecto == $proyecto_v) {
                                    echo '<option id="'.$v->viviendaProyecto.'" value="'.$v->viviendaProyecto.'">
                                      <strong>'.$p->proyectoNombre.'</strong></option>';
                                      break;
                                }
                            }
                        }
                            
                        ?> 
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="userinput1"><strong>Vivienda Afectada</strong></label>
                    <select class="select2 form-control" id="vivienda" name="vivienda" data-live-search="true">
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Dirección de su vivienda</strong> <small class="badge badge-default badge-success">Si la dirección esta incompleta, puede actualizarla aqui!</small></label>
                    <input type="text" class="form-control" id="direccion_real" name="direccion_real" value="">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Fecha de Garantía</strong></label>
                    <input type="text" class="form-control" id="garantia" name="garantia"  readonly value="">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Tipo de Vivienda</strong></label>
                    <input type="text" class="form-control" id="tipo_vivienda"  name="tipo_vivienda" readonly value="">
                </div>
                <div class="col-md-6">
                    <label for="userinput1"><strong>Modelo de Vivienda</strong></label>
                    <input type="email" class="form-control" id="modelo_vivienda" name="modelo_vivienda" readonly value="">
                </div>
                <br><br>
            </div>
        </div>
        <div class="card-footer"></div>
    </div><!-- / card-->
    <div class="card"> <!-- **** SECCION SUCESOS **** -->
        <div class="card-header"> 
            <h4 class="card-title"><b>Datos de los sucesos ocurridos en su vivienda</b></h4><br>
            <div class="alert alert-info">A continuación debe seleccionar un <b>suceso</b> y su respectivo <b>origen</b>, luego debe presionar el boton <b>"agregar"</b> para añadirlo a la lista inferior. <b>Repetir este procedimiento para agregar otro suceso a la lista</b></div>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="container">
                <table class="table  table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="text-align: center; width: 30%">CATEGORÍA</th>
                        <th style="text-align: center; width: 30%">SUCESO</th>
                        <th style="text-align: center; width: 25%">ORIGEN</th>
                        <th style="text-align: center; width: 15%">AGREGAR</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="select2 form-control" id="categoria" name="categoria" data-live-search="true">
                                </select>
                            </td>
                            <td>
                                <select class="select2 form-control" id="suceso" name="suceso" data-live-search="true">
                                </select>
                            </td>
                            <td>
                                <select class="select2 form-control" id="origen" name="origen" data-live-search="true">
                                    <option value="">Seleccione donde ocurrio el suceso</option>
                                    <?php 
                                    foreach ($origen as $o) {
                                        echo '<option value="'.$o->id_origen.'"><b>'.$o->origen.'</b></option>';
                                    }  
                                    ?> 
                                </select>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-success" id="boton_agregar">AGREGAR</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <table id="tabla_sucesos" style="display: none" class="table  table-bordered table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                      <tr style="display: none;">
                        <th style="text-align: center; width: 30%"></th>
                        <th style="text-align: center; width: 30%"></th>
                        <th style="text-align: center; width: 25%"></th>
                        <th style="text-align: center; width: 15%"></th>
                      </tr>
                    </thead>
                    <tbody id="body_sucesos">
                    </tbody>
                </table>
            </div>
            <br>
            <div class="row" style="display: none" id="row_comentario">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="alert alert-info">Para finalizar, agregue un breve comentario de lo sucedido en su vivienda!</div>
                    <!-- FALTA PONER EN MAYUSCULAS EL TEXTO -->
                    <textarea class="form-control" id="comentario" name="comentario" rows="6" maxlength="500"></textarea></div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div><!-- / card-->
    <div class="col-md-12" align="right">
        <button type="button btn-success" id="boton_guardar" class="btn btn-success" disabled>ENVIAR SOLICITUD</button>
    </div>
</form>
<script type="text/javascript">
    contador_filas = 0;
    $(document).ready(function() {
        $("#proyecto").change(function() {
          $("#proyecto option:selected").each(function() { //CADA VEZ QUE CAMBIE EL PROYECTO
            proyecto = $('#proyecto').val(); //SE OBTIENE EL VALOR DEL PROYECTO
            if (proyecto == "") { //si selecciona la opcion de seleecionar :V
                $("#vivienda").html("");
            }
            else { //si selecciona algun proyecto
                viviendas = "";
                <?php 
                foreach ($vivienda as $vv) {
                    $proyecto_vivienda = $vv->viviendaProyecto;
                ?>
                    proyecto_vivienda = "<?php echo $proyecto_vivienda ?>";
                    if (proyecto == proyecto_vivienda) {
                        viviendas += "<option value='<?php echo $vv->idvivienda ?>' id='vivienda_<?php echo $vv->idvivienda ?>'><?php echo $vv->viviendaDireccion ?></option>";
                    }
                <?php
                }
                ?>
                <?php  
                  foreach ($proyectos as $p) {
                    $proyecto_ss = $p->proyectoCentrocosto;
                    ?>
                    pyt = '<?php echo $proyecto_ss ?>';
                    if (proyecto != pyt) {
                      $("#"+pyt).attr('disabled', true);
                    }
                    <?php
                  }
                ?>
                $("#proyecto_vacio").attr('disabled', true);
                $("#vivienda").html("<option value='' id='vivienda_vacia'>Seleccione su vivienda afectada</option>"+viviendas);
                $("#vivienda").focus();
            }
          });
        });
    });
    $(document).ready(function() {
        $("#vivienda").change(function() {
          $("#vivienda option:selected").each(function() { //CADA VEZ QUE CAMBIE LA VIVIENDA
            vivienda = $('#vivienda').val(); //SE OBTIENE EL VALOR DE OLA VIVIWNDA
            if (vivienda == "") { //si selecciona la opcion de seleecionar :V
                $("#direccion_real").val("");
                $("#garantia").val("");
                $("#tipo_vivienda").val("");
                $("#modelo_vivienda").val("");
            }
            else { //si selecciona alguna vivienda
                <?php  
                  foreach ($vivienda as $v) {
                    $vivienda_ss = $v->idvivienda;
                    ?>
                    vvd = <?php echo $vivienda_ss ?>;
                    if (vvd != vivienda) {
                      $("#vivienda_"+vvd).attr('disabled', true);
                    }
                    <?php
                  }
                ?>
                $("#vivienda_vacia").attr('disabled', true);
                rut_cliente = $('#mi_rut').val();
                var parametros = {
                  "id_vivienda" : vivienda,
                  "rut_cliente" : rut_cliente
                };
                $.ajax({
                    data: parametros,
                    url: '<?php echo base_url() ?>ctrl_cliente/datos_vivienda_categorias',
                    type:  'post',
                    success:  function (response) {
                        // console.log(response);
                        var respuesta = JSON.parse(response);
                        // alert(respuesta[0].direccion_real);
                        $("#direccion_real").val(respuesta[0].direccion_real);
                        $("#garantia").val(respuesta[0].garantia);
                        $("#tipo_vivienda").val(respuesta[0].tipo_vivienda);
                        $("#modelo_vivienda").val(respuesta[0].modelo_vivienda);
                        var categorias_cat = "";
                        <?php 
                            $categorias_cat = "";
                            foreach ($categorias as $c) {
                                $años_garantia = $c->garantia;
                                $fecha_hoy = date("d-m-Y");
                                ?>
                                var f1 = respuesta[0].garantia;
                                var f2 = '<?php echo $fecha_hoy ?>';
                                años_garantia = <?php echo $años_garantia ?>;
                                dias_garantia = años_garantia*365;
                                diferencia =  restar_fechas(f1,f2);
                                en_garantia = "";
                                // alert("dias de garantia = "+dias_garantia+" dias vivienda = "+diferencia);
                                if (diferencia < dias_garantia) { //SI ESTA DENTRO DE GAARANTIA
                                    categorias_cat += '<option id="'+<?php echo "'".$c->id_categoria."'"; ?>+'" value="'+<?php echo "'".$c->id_categoria."'"; ?>+'"><b>'+<?php echo "'".$c->categoria."'"; ?>+' - '+<?php echo "'".$años_garantia."'"; ?>+' años de garantia</b></option>';
                                }
                                else { //SI ESTA FUERA DE GARANTIA
                                    categorias_cat += '<option disabled><b>'+<?php echo "'".$c->categoria."'"; ?>+' - '+<?php echo "'".$años_garantia."'"; ?>+' años de garantia - FUERA DE GARANTIA</b></option>';
                                }
                                <?php
                            }
                        ?>
                        categorias = categorias_cat;
                        // dias = '<?php //echo $dias ?>';
                        // alert(dias);
                        $("#categoria").html('<option value="">Seleccione categoria</option>'+categorias);
                        $("#direccion_real").focus();
                    }
                });
            }
          });
        });
    });
    function restar_fechas(fecha1, fecha2) {
        var aFecha1 = fecha1.split('-');
        var aFecha2 = fecha2.split('-');
        var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
        var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
        var dif = fFecha2 - fFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
        return dias;
    }
    $(document).ready(function() {
        $("#categoria").change(function() {
          $("#categoria option:selected").each(function() { //CADA VEZ QUE CAMBIE LA CATEGORIA
            categoria = $('#categoria').val(); //SE OBTIENE EL VALOR DE LA CATEGORIA
            if (categoria == "") { //si selecciona la opcion de seleecionar :V
                $("#suceso").html("");
            }
            else { //si selecciona alguna categoria
                sucesosselect = "";
                <?php 
                foreach ($sucesos as $s) {
                    $disabled = 0;
                    $id_categoria_suceso = $s->categoria;
                    ?>
                    categoria_suceso = <?php echo $id_categoria_suceso ?>;
                    if (categoria == categoria_suceso) { //SI LA CATEGORIA DEL SUCESO COINCIDE CON LA CATEGORIA BUSCADA, SETEO LOS CAMPOS
                        <?php
                            if (isset($sucesos_pendientes)) {
                                foreach ($sucesos_pendientes as $as) { 
                                    if ($as->id_suceso == $s->id_suceso) {
                                        $disabled = 1;
                                        break;
                                    }
                                }
                            }
                        ?>
                        inhabilitar = <?php echo $disabled ?>;
                        if (inhabilitar == 0) {
                            sucesosselect += "<option value='<?php echo $s->id_suceso ?>'><?php echo $s->suceso ?></option>";
                        }
                        else {
                            sucesosselect += "<option value='<?php echo $s->id_suceso ?>' disabled><?php echo $s->suceso ?> - Pendiente en solicitud previa</option>";
                        }
                        
                    }
                    <?php
                    $disabled = 0;
                }
                ?>
                $("#suceso").html("<option value=''>Seleccione el suceso</option>"+sucesosselect);
            }
            });
        });
    });
    $("#boton_agregar").click(function(event){
        agregar();
    });
    $("#boton_actualizar").click(function(event){
        actualizar_cliente();
    });
    function agregar() {
        suceso = $('#suceso').val(); //valor
        nombre_suceso = $('select[name="suceso"] option:selected').text(); //el contenido
        origen = $('#origen').val();
        nombre_origen = $('select[name="origen"] option:selected').text();
        categoria = $('#categoria').val();
        nombre_categoria = $('select[name="categoria"] option:selected').text();
        if (suceso == "" || suceso == null) {
            Swal.fire('Atención!','Debe seleccionar el suceso para agregarlo!','warning');
            $('#suceso').focus();
        }
        else if(origen == "" || origen == null) {
            Swal.fire('Atención!','Debe seleccionar el origen del suceso para agregarlo!','warning');
            $('#origen').focus();
        }
        else {
            contador_filas++;
            suceso_origen = suceso+"#"+origen;
            fila = "<tr id='fila"+contador_filas+"'><td><b>"+nombre_categoria+"</b></td><td><b>"+nombre_suceso+"</b><input type='hidden' name='suceso_origen[]' id='suceso_origen[]' value='"+suceso_origen+"' ></td><td><b>"+nombre_origen+"</b></td><td style='text-align: center;'><a class='btn btn-danger'  onclick='eliminar_fila("+contador_filas+")'> <i class='fa fa-trash'></i> </a></td></tr>";
            $("#body_sucesos").append(fila);
            $("#tabla_sucesos").show();
            $("#boton_guardar").attr('disabled', false);
            $('#suceso').html("");
            $('#categoria').val("");
            $('#origen').val("");
            $("#row_comentario").show();
        }
    }
    function eliminar_fila(id) {
        Swal.fire({
          title: 'Atención',
          text: "¿Está seguro(a) de borrar este suceso?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, borrarlo!',
          cancelButtonText: 'Cancelar!'
        }).then((result) => {
          if (result.value) {
            $('#fila'+id).remove();
            contador_filas--;
            if (contador_filas == 0) {
              $("#boton_guardar").attr('disabled', true);
            }
            Swal.fire(
              'Exito!',
              'Suceso eliminado, puede agregar más desde la parte superior!',
              'success'
            )
          }
        })
    }
    function enviar_formulario() {
        $('#formulario_solicitud').submit();
        $("#boton_guardar").attr('disabled', true);

    }
    function actualizar_cliente() {
        id_cliente = $('#id_cliente').val();
        rut_cliente = $('#mi_rut').val();
        nombre_cliente = $('#mi_nombre').val();
        telefono_cliente = $('#mi_telefono').val();
        correo_cliente = $('#mi_correo').val();
        direccion_cliente = $('#mi_direccion').val();
        //VALIDAR VACIOS
        if (rut_cliente == "" || nombre_cliente == "" || telefono_cliente == "" || correo_cliente == "" || direccion_cliente == "") {
            Swal.fire("Atención!", "Debe completar todos los campos para actualizar sus datos!", "warning");
        }
        else {
            Swal.fire({
                title: 'Atención',
                text: "Recuerde que su correo es su clave de acceso a la plataforma! ¿Desea continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Continuar!',
                cancelButtonText: 'Cancelar!'
            }).then((result) => {
                if (result.value) {
                    var parametros = {
                      "id_cliente" : id_cliente,
                      "rut_cliente" : rut_cliente,
                      "nombre_cliente" : nombre_cliente,
                      "telefono_cliente" : telefono_cliente,
                      "correo_cliente" : correo_cliente,
                      "direccion_cliente" : direccion_cliente
                    };
                    $.ajax({
                        data: parametros,
                        url: '<?php echo base_url() ?>ctrl_cliente/actualizar_datos_cliente',
                        type:  'post',
                        success:  function (response) {
                            console.log(response);
                            Swal.fire("Exito!", "Sus datos fueron actualizados correctamente!", "success"); 
                        }
                    });
                }
            })   
        }        
    }
</script>