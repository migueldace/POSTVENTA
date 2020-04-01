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
	<div style="text-align: left">
		<img width="250" height="75" src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/Comercial/POSTVENTA/assets/img/logo_pdf.png" >
	</div>
	<div style='text-align: center;'>
        <center><h2>COMPROBANTE DE CONFORMIDAD</h2></center>
    </div><hr>
    <table style="width: 100%">
        <tr>
            <td><b>N° SOLICITUD: </b><?php echo $id_solicitud ?></td>
            <td></td>
        </tr>
        <tr>
            <td><b>NOMBRE: </b><?php echo $nombre ?></td>
            <td style='text-align: right;'><b>TELÉFONO: </b><?php echo $telefono ?></td>
        </tr>
        <tr>
            <td><b>RUT: </b><?php echo $rut ?></td>
            <td></td>
        </tr>
        <tr>
            <td ><b>PROYECTO: </b><?php echo $proyecto ?></td>
            <td style='text-align: right;'><b>DIRECCIÓN: </b><?php echo $direccion ?></td>
        </tr>
    </table>
    <hr>
    <!-- aqui los datos -->
    <?php 
    // var_dump($sucesos);
    // var_dump($partidas_suceso);
    $detalle = "";
    	foreach ($sucesos as $suc) {
    		$id_ss = $suc->id_solicitud_suceso;

    		if ($suc->id_estado == 14) { //SI ESTA RECHAZADO NO SE MUESTRA
    		}
    		else {
	    		$partida1 = "";
	    		$partidas2mas = "";
	    		$contador_partidas = 0;
	    		foreach ($partidas_suceso as $par) {
	    			if ($id_ss == $par->id_solicitud_suceso) { //SI LA PARTIDA PERTENECE A EL SUCESO
	    				if ($contador_partidas == 0) { //SI ES EL PRIMERO
	    					$partida1 .= "
		    				<td id='borde'>$par->partida</td>
		    				<td id='borde'>$par->tipo_medida</td>
		    				<td id='borde' style='text-align: right'>$par->medida</td>";
		    				if (is_null($par->fecha_termino)) {
		    					$partida1 .= "
			    				<td id='borde' style='text-align: right'></td>";
		    				}
		    				else {
			    				$partida1 .= "
			    				<td id='borde' style='text-align: right'>".date('d/m/Y',strtotime($par->fecha_termino))."</td>";
			    			}
	    				}
	    				else {
	    					$partidas2mas .= "<tr>
		    				<td id='borde'>$par->partida</td>
		    				<td id='borde'>$par->tipo_medida</td>
		    				<td id='borde' style='text-align: right'>$par->medida</td>";
		    				if (is_null($par->fecha_termino)) {
		    					$partidas2mas .= "
			    				<td id='borde' style='text-align: right'></td>";
		    				}
		    				else {
			    				$partidas2mas .= "
			    				<td id='borde' style='text-align: right'>".date('d/m/Y',strtotime($par->fecha_termino))."</td>";
			    			}
			    			$partidas2mas.= "</tr>";

	    				}
	    				$contador_partidas++;
	    			}
	    		}
	    		$detalle .= "
	    		<tr>
	    			<td rowspan='$contador_partidas' id='borde'>$suc->suceso</td>
	    			<td rowspan='$contador_partidas' id='borde'>$suc->observacion</td>
	    			$partida1
	    		</tr>$partidas2mas";
	    	}
    	}
    ?>
    <table id='borde' style="width: 100%">
    	<thead>
              <tr>
                <th id='borde' style='text-align: center;'>SUCESO</th>
                <th id='borde' style='text-align: center;'>COMENTARIO</th>
                <th id='borde' style='text-align: center;'>PARTIDA</th>
                <th id='borde' style='text-align: center;'>TIPO UNI.</th>
                <th id='borde' style='text-align: center;'>CANT.</th>
                <th id='borde' style='text-align: center;'>FECHA CONFORMIDAD</th>
              </tr>
            </thead>
        <tbody>
        	<?php
        	echo $detalle;
        	?>
       	</tbody>
    </table><br>
    <hr>
	<br><br><br><br>
	<div >
        <table style="width: 100%">
            <tr>
                <td style="text-align: center;">_________________________________<br>
                    FIRMA SUPERVISOR
                </td>

                <td style="text-align: center;">_________________________________<br>
                    FIRMA CONFORMIDAD
                </td>
            </tr>
        </table>
    </div>
</body>
</html>