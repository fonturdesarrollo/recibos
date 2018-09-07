<?php
	require('incluidos/constantes.php');
?>
<!DOCTYPE html>
<html>
<head><!--Version de server5 sin contador ni encriptacion de datos-->
	<meta charset='utf-8' />
	<title>SISTEMA DE SOLICITUDES EN LÍNEA</title>
	<link rel='stylesheet' type='text/css' href='estilo.css' />
</head>
<body>
	<table align='center' class='cien'>
		<tr>
			<td class='encabezado'>
				<img class='enc1' src='imagenes/header_gobierno.png' />
				<img class='enc2' src='imagenes/banner_fontur.png' />
			</td>
		</tr>
		<tr>
			<td>
				<form name='validacion' action='valido.php' method='post'>
				<table align='center' class='auto' id='lineado2'>
					<tr>
						<td class='auto' id='centrolineado2'>
							<p class='titulo'>SISTEMA DE SOLICITUDES EN LÍNEA</p>
						</td>
					</tr>
                                        <tr>
						<td  id='centrado'>
							<img  src='imagenes/mantenimiento.jpg' />
						</td>
					</tr>
				</table>
				<br /><br /><br /><br />
				</form>
			</td>
		</tr>
		<tr>
			<td class='pie'>
				<p class='pie' id='centrado'><?php echo $institucion2; ?></p>
				<p class='pie' id='centrado'><?php echo $direccioninstitucion; ?></p>
				<p class='pie' id='centrado'><?php echo $contacto; ?></p>
			</td>
		</tr>
	</table>		
</body>
</html>
