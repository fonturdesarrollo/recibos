<?php
	require('../incluidos/constantes.php');
	include('pgsql-consulta_recibo.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>SISTEMA DE SOLICITUD DE RECIBOS</title>
	<link rel="stylesheet" type="text/css" href="../estilo.css" />
	<script type='text/javascript'>
			function validar_ingreso(){				
			ruta=document.ingreso;		
			if(ruta.cuenta.value==''){
				alert('Debe rellenar el campo cuenta nómina.');
			}else if(isNaN(ruta.cuenta.value)){
				alert('El número de cuenta solo debe contener números 0-9.');
			}else if(ruta.cuenta.value.length!=20){
				alert('El número de cuenta de nomina debe contener 20 dígitos.\nAviso: Recuerde que no es el número de su tarjeta de débito.');
			}else if(ruta.ci.value==''){
				alert('Debe rellenar el campo cédula de identidad.');
			}else if(isNaN(ruta.ci.value)){
				alert('El número de cédula solo debe contener números 0-9.');
			}else if(ruta.quincena.selectedIndex==0){
				alert('Debe seleccionar la quincena a solicitar.');
			}else {
				//alert('¡ATENCIÓN!\nEl Documento será válido por treinta (30) días a partir de su emisión.\nEl sistema generará un máximo de tres (3) constancias cada mes.\nLa remuneración especificada en este documento corresponde al mes anterior de la solicitud de la misma.');
				ruta.submit();
			}
		}
		function carga(){
			document.ingreso.quincena.selectedIndex=0;
		}
	</script>
</head>
<body onload="carga(); document.getElementById('captcha').src = '../incluidos/securimage/securimage_show.php?' + Math.random(); return false">
	<table class='cien'>
		<tr>
			<td class='encabezado'>
				<img class='enc1' src='../imagenes/header_gobierno.png' />
				<img class='enc2' src='../imagenes/banner_fontur.png' />
			</td>
		</tr>
		<tr>
			<td>
				<form name='ingreso' action='recibo.php' method='post'>
				<table align='center' class='auto' id='lineado'>
					<tr>
						<td colspan='2' class='auto' id='centrolineado'>
							<p class='titulo'>SISTEMA DE SOLICITUD DE RECIBOS</p>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='auto' id='centrolineado'>
							<p>INGRESE LOS DATOS SOLICITADOS Y PRESIONE 'SIGUIENTE'</p>
						</td>
					</tr>
					<tr>
						<td class='auto' id='derecha'>
							<p>N° DE CUENTA NÓMINA</p>
						</td>
						<td class='auto'>
							<p><input type='text' maxlength='20' name='cuenta' id="title" title="Ingrese su número de cuenta. &#10;En caso de no poseer cuenta, coloque su número de cédula y complete con ceros hasta llenar 20 dígitos.&#10;Ejemplo: 12345678900000000000"/></p>
						</td>
					</tr>
					<tr>
						<td class='auto' id='derecha'>
							<p>CÉDULA DE IDENTIDAD</p>
						</td>
						<td class='auto'>
							<p><input type='text' maxlength='8' name='ci' title="Ingrese su número de Cédula sin puntos.&#10;Ejemplo: 18000000"/></p>
						</td>
					</tr>
					<tr>
						<td class='auto' id='derecha'>
							<p>QUINCENA</p>
						</td>
						<td class='auto'>
							<p>
								<select name='quincena' title="Seleccione de la lista desplegable la quincena del recibo que desea emitir">
									<option selected='selected'>Seleccione</option>
									<option value='1'>Enero 1era Quincena</option>
									<option value='2'>Enero 2da Quincena</option>
									<option value='3'>Febrero 1era Quincena</option>
									<option value='4'>Febrero 2da Quincena</option>
									<option value='5'>Marzo 1era Quincena</option>
									<option value='6'>Marzo 2da Quincena</option>
									<option value='7'>Abril 1era Quincena</option>
									<option value='8'>Abril 2da Quincena</option>
									<option value='9'>Mayo 1era Quincena</option>
									<option value='10'>Mayo 2da Quincena</option>
									<option value='11'>Junio 1era Quincena</option>
									<option value='12'>Junio 2da Quincena</option>
									<option value='13'>Julio 1era Quincena</option>
									<option value='14'>Julio 2da Quincena</option>
									<option value='15'>Agosto 1era Quincena</option>
									<option value='16'>Agosto 2da Quincena</option>
									<option value='17'>Septiembre 1era Quincena</option>
									<option value='18'>Septiembre 2da Quincena</option>
									<option value='19'>Octubre 1era Quincena</option>
									<option value='20'>Octubre 2da Quincena</option>
									<option value='21'>Noviembre 1era Quincena</option>
									<option value='22'>Noviembre 2da Quincena</option>
									<option value='23'>Diciembre 1era Quincena</option>
									<option value='24'>Diciembre 2da Quincena</option>
								</select>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='auto' id='centrado'>
							<p>Código de Seguridad</p>
							<p><img id="captcha" src="../incluidos/securimage/securimage_show.php" alt="CAPTCHA Image" /></p>
							<p><input type="text" name="captcha_code" size="10" maxlength="6" title="Introduzca el código de seguridad tal como se muestra en la imágen respetando mayúsculas y minúsculas"/></p>
							<p><a href="#" onclick="document.getElementById('captcha').src = '../incluidos/securimage/securimage_show.php?' + Math.random(); return false">Haga clic para cambiar la imágen.</a></p>
						</td>
					</tr>
					<tr>
						<td colspan='2' class='auto' id='centrolineado'>
							<p>
								<input type='button' name='siguiente' value='Siguiente' onclick='validar_ingreso();'/>
								<input type='button' name='salir' value='Salir' onclick="javascript:window.location.href='../index.php';"/>
								<input type='hidden' name='bisiesto' value='<?php echo bisiesto(date('Y')) ?>' />
							</p>
						</td>
					</tr>
				</table>
				<?php
					if(isset($_GET['error'])){
						if($_GET['error']=='mpm'){
							echo "<br /><p class='valido' id='centrado'>USTED HA ALCANZADO EL MÁXIMO PERMITIDO POR EL MES, COMUNÍQUESE CON RECURSOS HUMANOS.</p>";
						}else if($_GET['error']=='rne'){
							echo "<br /><p class='valido' id='centrado'>REGISTRO NO ENCONTRADO, VERIFIQUE SU INFORMACIÓN.</p>";
						}else if($_GET['error']=='cvi'){
							echo "<br /><p class='valido' id='centrado'>CÓDIGO DE SEGURIDAD INCORRECTO, INTÉNTELO DE NUEVO.</p>";
						}
					}
				?>
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