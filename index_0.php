<?php
	//require('incluidos/constantes.php');
    //require('incluidos/contador.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>SISTEMA DE SOLICITUDES EN L&Iacute;NEA</title>
	<link rel='stylesheet' type='text/css' href='estilo.css' />
</head>
<body>
	<table align='center' class='cien'>
		<tr>
			<td class='encabezado'>
				<!--<img class='enc1' src='imagenes/header_gobierno.png' />-->
				<!--<img class='enc2' src='imagenes/banner_fontur.png' />-->
				<img class='enc3' src='imagenes/cabecera.png' />
			</td>
		</tr>
		<tr>
			<td>
				<form name='validacion' action='valido.php' method='post'>
				<table align='center' class='auto' id='lineado'>
					<tr>
						<td class='auto' id='centrolineado'>
							<p class='titulo'>SISTEMA DE SOLICITUDES EN L&Iacute;NEA</p>
						</td>
					</tr>
                                        <tr>
					<tr>
						<td class='auto' id='centrado'>
                                                    <p class='titulo2'><a href='constancias/ingreso.php'>Constancia de Trabajo</a></p>
                                                </td>
					</tr>
					<tr>
						<td class='auto' id='centrado'>
                                                    <p class='titulo2'><a href='recibos/ingreso.php'>Recibos de Pago</a></p>
                                                </td>
					</tr>
					<td class='auto' id='centrado'>
                                                    <p class='titulo2'><a href='arc/ingreso.php'>ARC</a></p>
                                                </td>
					</tr>
				</table>
				<br /><br /><br /><br />
				</form>
			</td>
		</tr>
                <!--<tr>
                    <td>
                        <p class='valido' id='derecha'>Usted es el visitante N&uacutemero: <?php //echo contar_visita($conn);?></p>
                    </td>
                </tr>-->
		<tr>
			<td class='pie'>
				<!--<p class='pie' id='centrado'><?php //echo $institucion2; ?></p>
				<p class='pie' id='centrado'><?php //echo $direccioninstitucion; ?></p>
				<p class='pie' id='centrado'><?php //echo $contacto; ?></p>-->
				<img class='pie1' src='imagenes/pie.png' />
			</td>
		</tr>
	</table>		
</body>
</html>