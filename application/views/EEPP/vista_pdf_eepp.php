<!DOCTYPE html>
<html>
<head>
	<style>
		div.page_break {
		    page-break-before: always;
		}
	    #borde {
	        border: 1px solid black;
	        border-collapse: collapse;
	    }
	    #bordelados {
	        border-left: 1px solid black;
	        border-right: 1px solid black;
	    }
	    #bordearriba {
	        border-top: 1px solid black;
	    }
	    #bordeabajo {
	    	border-bottom: 1px solid black;
	    }
	    #contenedor {
	        width: 100%;
	    }
	    th, td { 
	        padding: 4px;
	    }
	    .row {
		  margin-right: -15px;
		  margin-left: -15px;
		}
		.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
		  position: relative;
		  min-height: 1px;
		  padding-right: 15px;
		  padding-left: 15px;
		}
		.col-lg-12 {
		    width: 100%;
		}
		.text-center {
		  text-align: center;
		}
		body {
		  font-family: Helvetica, Arial, sans-serif;
		  font-size: 12px;
		  line-height: 1.42857143;
		  color: #333;
		  background-color: #fff;
		}
	</style>
</head>
<body>

	<?php  
		//******CALCULOS Y DETALLE**********
		$total_pago = 0;
		$total_adicional = 0;
		$total_materiales = 0;
		$partidas = "";
		foreach ($eepp as $ep) {
			if (!isset($ep->id_solicitud)) {
				# code...
			}
			else {
				$materiales_pagar = 0;
				if (isset($ep->materiales)) {
					$materiales = $ep->materiales;
					if (empty($materiales)) {} 
					else {
						foreach ($materiales as $m) {
							$materiales_pagar = $materiales_pagar+($m->precio*$m->cantidad);
						}
					}
				}
				$unidades = $ep->unidad_medida; //CANTIDAD
				$precio = $ep->precio;
				$pago_adicional = $ep->precio_adicional;
				$total = round(($unidades*$precio));
				$total_adicional += $pago_adicional;
				$total_materiales += $materiales_pagar;
				$total_pago = $total_pago+$total;
				//********TABLA DETALLE*******
				$id_solicitud = $ep->id_solicitud;
				$suceso = $ep->suceso;
				$partida = $ep->partida;
				$unidad = $ep->unidad;//TIPO DE MEDIDA
				$partidas .= "
					<tr >
						<td id='bordeabajo' style='text-align: center;'>$id_solicitud</td>
						<td id='bordeabajo'>$suceso</td>
						<td id='bordeabajo'>$partida</td>
						<td id='bordeabajo'>$unidad</td>
						<td id='bordeabajo' style='text-align: right;'>$unidades</td>
						<td id='bordeabajo' style='text-align: right;'>$precio</td>
						<td id='bordeabajo' style='text-align: right;'>$pago_adicional</td>
						<td id='bordeabajo' style='text-align: right;'>$materiales_pagar</td>
						<td id='bordeabajo' style='text-align: right;'>$total</td>
					</tr>";
				//*********FIN**********
			}
		}
		//**CALCULOS FINALES***
		$total_bruto = $total_pago-$descuentos-$anticipo;
		$iva_calculado = round($total_pago*0.19);
		$iva_retenido_porcentaje = "19%";
		$iva_retenido = 0;
		if ($iva == "si") {
			$total_mas_iva = $total_pago+$iva_calculado+$total_adicional+$total_materiales;
			$iva_retenido_porcentaje = "0%";
			$iva_retenido = 0;
		}
		else {
			$total_mas_iva = $total_pago+$total_adicional+$total_materiales;
			$iva_retenido = $iva_calculado;
		}
	?>
    <div style='text-align: center;'>
        <center><h2>ESTADO DE PAGO</h2></center>
    </div><hr>
    <table style="width: 100%">
        <tr>
            <td><b>CONTRATISTA: </b><?php echo $nombre_contratista ?></td>
            <td style='text-align: right;'><b>EMPRESA CONSTRUCTORA MALPO SPA</b></td>
        </tr>
        <tr>
            <td><b>RUT: </b><?php echo $rut_contratista ?></td>
            <td style='text-align: right;'><b>N° DE PAGO: </b><?php echo $n_pago ?></td>
        </tr>
        <tr>
            <td><b>CONTÁCTO: </b><?php echo $contacto ?></td>
            <td style='text-align: right;'><b>OBRA/DEPTO: </b>POSTVENTA</td>
        </tr>
        <tr>
            <td ><b>ENCARGADO: </b><?php echo strtoupper($encargado) ?></td>
            <td style='text-align: right;'><b>PAGO AL: </b><?php echo date("d/m/Y", strtotime($fecha_pago)) ?></td>
        </tr>
    </table>
    <br>
    <div>
        <table id='borde' style="width: 100%">
            <thead>
              <tr>
                <th id='borde' colspan='2' style='text-align: center;'>ACTIVIDADES</th>
                <th id='borde' colspan='3' style='text-align: center;'>TOTAL CONTRATO</th>
                <th id='borde' style='text-align: center;'>TOTAL A PAGO</th>
              </tr>
              <tr>
                <th id='borde' ></th>
                <th id='borde' style='text-align: center;'>UNIDAD</th>
                <th id='borde' style='text-align: center;'>Q</th>
                <th id='borde' style='text-align: center;'>UNITARIO</th>
                <th id='borde' style='text-align: center;'>TOTAL</th>
                <th id='borde' style='text-align: center;'>TOTAL</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td id='borde'>
                        <b><?php echo $nombre_proyecto ?><br>CC. <?php echo substr($cod_proyecto, 0, 4) ?>
                    </td>
                    <td id='borde'>uni</td>
                    <td id='borde' style='text-align: center;'>1</td>
                    <td style='text-align: right;' id='borde' ><b><?php echo number_format($total_pago, 0, '', '.') ?></b></td>
                    <td style='text-align: right;' id='borde' ><b><?php echo number_format($total_pago, 0, '', '.') ?></b></td>
                    <td style='text-align: right;' id='borde' ><b><?php echo number_format($total_pago, 0, '', '.') ?></b></td>
                </tr>
                <tr>
                    <td colspan='4' id='borde' ><b>TOTAL CONTRATO</b></td>
                    <td style='text-align: right;' id='borde' ><b><?php echo number_format($total_pago, 0, '', '.') ?></b></td>
                    <td style='text-align: right;' id='borde' ><b>$ <?php echo number_format($total_pago, 0, '', '.') ?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div>
	    <table style="width: 100%">
	    	<tr>
	    		<td>
		            <table id='borde' >
		                <tr>
		                    <td>DEVOLUCION ANTICIPO ANTERIOR<br>
		                        DEVOLUCION ANTICIPO PRESENTE<br>
		                        ____________________________<br>
		                        DEVOLUCION ACUMULADA
		                    </td>
		                    <td>_____________<br>
		                        _____________<br>
		                        _____________<br>
		                        _____________
		                    </td>
		                </tr>
		                <tr id='borde'>
		                    <td>RETENCION ANTERIOR<br>
		                        RETENCION PREST. E DE PAGO<br>
		                        ____________________________<br>
		                        RETENCION ACUMULADA
		                    </td>
		                    <td>_____________<br>
		                        _____________<br>
		                        _____________<br>
		                        _____________
		                    </td>
		                </tr>
		                <tr id='borde'>
		                    <td>
		                        <b>DESCUENTOS</b><br>
		                        FECHA INGRESO<br>
		                        MONTO<br>
		                        MOTIVO
		                    </td>
		                    <td><br>
		                        _____________<br>
		                        _____________<br>
		                        _____________
		                    </td>
		                </tr><br><br><br>
		            </table>
		        </td>
		        <td>
		            <table >
		            	<thead id='borde'>
		            		<tr >
				                <th  colspan='2' style="text-align: center;"><b>VALOR E.E.P.P.</b></th>
				                <th  style='text-align: right;'><?php echo number_format($total_pago, 0, '', '.') ?></th>
			                </tr>
		            	</thead>
		              	<tbody id='borde'>
			              	<tr>
				                <td><b>DESCUENTOS</b></td>
				                <td></td>
				                <td style='text-align: right;'><?php echo number_format($descuentos, 0, '', '.') ?></td>
			             	</tr>
			                <tr>
				                <td><b>ANTICIPO</b></td>
				                <td></td>
				                <td style='text-align: right;'><?php echo number_format($anticipo, 0, '', '.') ?></td>
			                </tr>
			                <tr>
				                <td><b>RETENCION</b></td>
				                <td style='text-align: right;'>0%</td>
				                <td></td>
			                </tr>
			                <tr id='bordearriba'>
				                <td><b>TOTAL BRUTO</b></td>
				                <td></td>
				                <td style='text-align: right;'><?php echo number_format($total_bruto, 0, '', '.') ?></td>
			                </tr>
			                <tr>
				                <td><b>I.V.A</b></td>
				                <td style='text-align: right;'>19%</td>
				                <td style='text-align: right;'><?php echo number_format($iva_calculado, 0, '', '.') ?></td>
			                </tr>
			                <tr>
				                <td><b>I.V.A RETENIDO</b></td>
				                <td style='text-align: right;'><?php echo $iva_retenido_porcentaje ?></td>
				                <td style='text-align: right;'><?php echo number_format($iva_retenido, 0, '', '.') ?></td>
			                </tr>
			                <tr>
				                <td><b>MATERIALES</b></td>
				                <td></td>
				                <td style='text-align: right;'><?php echo number_format($total_materiales, 0, '', '.') ?></td>
			                </tr>
			                <tr>
				                <td><b>PAGO ADICIONAL</b></td>
				                <td></td>
				                <td style='text-align: right;'><?php echo number_format($total_adicional, 0, '', '.') ?></td>
			                </tr>
			                <tr style="border-top: solid 1px;">
				                <td colspan='2'><b>LIQUIDO A PAGO</b></td>
				                <td style='text-align: right'><b><?php echo number_format($total_mas_iva, 0, '', '.') ?></b></td>
			                </tr>
			            </tbody>
		            </table>
		        </td>
	        </tr>
	    </table>
	</div>
	<br><br><br><br>
    <div >
        <table style="width: 100%">
            <tr>
                <td style="text-align: center;">_________________________________<br>
                    V°B° JEFE DEPARTAMENTO
                </td>

                <td style="text-align: center;">_________________________________<br>
                    
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"><br><br><br>_________________________________<br>
                             V°B° GERENTE INMOBILIARIA
                </td>
                <td style="text-align: center;"><br><br><br>_________________________________<br>
                             V°B° CONTROL PRESUPUESTO
                </td>
            </tr>
        </table>
    </div>
    <div class="page_break"></div> <!-- SALTO DE PAGINA -->
    <div style='text-align: center;'>
        <center><h2>PRESUPUESTO DE COSTO REPARACIONES</h2></center>
    </div><hr>
    <table style="width: 100%">
        <tr>
            <td><b>CONTRATISTA: </b><?php echo $nombre_contratista ?></td>
            <td style='text-align: right;'><b>EMPRESA CONSTRUCTORA MALPO SPA</b></td>
        </tr>
        <tr>
            <td><b>RUT: </b><?php echo $rut_contratista ?></td>
            <td style='text-align: right;'><b>N° DE PAGO: </b><?php echo $n_pago ?></td>
        </tr>
    </table>
    <hr>
    <div style="width: 100%">
    	<b><?php echo $nombre_proyecto ?><br>CC. <?php echo substr($cod_proyecto, 0, 4) ?>
    </div>
    <div>
		<table id='borde' style='width: 100%'>
	        <thead>
	          <tr>
	            <th id='borde' style='text-align: center;'>SOLICITUD</th>
	            <th id='borde' style='text-align: center;'>SUCESO</th>
	            <th id='borde' style='text-align: center;'>PARTIDA</th>
	            <th id='borde' style='text-align: center;'>UNI</th>
	            <th id='borde' style='text-align: center;'>CANT</th>
	            <th id='borde' style='text-align: center;'>P.U.</th>
	            <th id='borde' style='text-align: center;'>OTROS COSTOS</th>
	            <th id='borde' style='text-align: center;'>MAT</th>
	            <th id='borde' style='text-align: center;'>TOTAL</th>
	          </tr>
	        </thead>
	        <tbody>
	        	<?php echo $partidas ?>
				<tr>
					<td colspan='6' id='borde' ><strong>TOTAL</strong></td>
					<td style='text-align: right;' id='borde' ><strong>$ <?php echo number_format($total_adicional, 0, '', '.') ?></strong></td>
					<td style='text-align: right;' id='borde' ><strong>$ <?php echo number_format($total_materiales, 0, '', '.') ?></strong></td>
					<td style='text-align: right;' id='borde' ><strong>$ <?php echo number_format($total_pago, 0, '', '.') ?></strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>