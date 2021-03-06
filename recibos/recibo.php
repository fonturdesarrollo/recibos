<?php
	if(isset($_POST['cuenta'])&&isset($_POST['ci'])&&isset($_POST['tipo_nomina'])&&isset($_POST['año_quincena'])&&isset($_POST['mes_quincena'])&&isset($_POST['quincena'])&&isset($_POST['captcha_code'])){
	include '../incluidos/securimage/securimage.php';
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=cvi">';
			//return 0;
		}
		if($_POST['quincena']=='1'){
			$dia_quincena_1='01';
			$dia_quincena_2='15';
		}else{
			$dia_quincena_1='16';
			$mes = mktime( 0, 0, 0, $_POST['mes_quincena'], 1, $_POST['año_quincena'] );
			$dia_quincena_2 = date('t',$mes);
		}
		$tipo_nomina = $_POST["tipo_nomina"];
		$fecha_i=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$dia_quincena_1;
		$fecha_f=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$dia_quincena_2;
		if($tipo_nomina=="N"){
			$fecha_inicial=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$dia_quincena_1;
			$fecha_final=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$dia_quincena_2;
		}else{
			$fecha_inicial=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$_POST['quincena'];
			$fecha_final=$_POST['año_quincena']."-".$_POST['mes_quincena']."-".$_POST['quincena'];
		}
		
		$año=$_POST['año_quincena'];
		if ($año>="2018"){
			$esquema="SIMA9".substr($año,2,2);
		} else {
			$esquema="SIMA0".substr($año,2,2);
		}
		
		//PRUEBA CONTROL TIEMPO
		if($fecha_final>=date("Y-m-d")){
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=rne">'; exit;
		}
		//FIN PRUEBA CONTROL TIEMPO
		
		$numero_cuenta=$_POST['cuenta'];
		$cedula=$_POST['ci'];
		$total_asignaciones = 0;
		$total_deducciones = 0;
	}else{
		header('Location: ingreso.php');
	}
	
	function arregla_fecha($fecha){
		$arreglo_fecha = explode("-",$fecha);
		return $arreglo_fecha[2]."/".$arreglo_fecha[1]."/".$arreglo_fecha[0];
	}
	
	$conexion = pg_pconnect("host=172.16.7.195 port=5432 dbname=SIMA user=cidesa password=cidesa");
	if (!$conexion) {
		//echo "No se conectó a PostgreSQL."; exit;
	}

	$consulta = pg_query($conexion, "SELECT * FROM \"$esquema\".nphiscon WHERE cedemp = '$cedula' AND cuenta_banco = '$numero_cuenta' AND fecnom BETWEEN '$fecha_inicial' AND '$fecha_final' AND especial = '$tipo_nomina' LIMIT 1;");
	if (!$consulta) {
		//echo "No se pudo ejecutar la consulta."; exit;
	}
	
	if(pg_num_rows($consulta)==0){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=rne">'; exit;
	}

	while ($fila = pg_fetch_array($consulta)) {
		$codigo_nomina = $fila['codnom'];
		
		if($codigo_nomina=="004"){
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=rne">'; exit;
		}
		
		$cedula_empleado = $fila['cedemp'];
		
		$fecha_nomina = $fila['fecnom'];
		$nombre_empleado = $fila['nomemp'];
		
		$consulta1 = pg_query($conexion, "SELECT fecing FROM \"$esquema\".nphojint WHERE cedemp = '$cedula_empleado';");
		if (!$consulta1) {
			//echo "No se pudo ejecutar la consulta."; exit;
		}

		while ($fila1 = pg_fetch_array($consulta1)) {
			$fecha_ingreso = $fila1['fecing'];
		}
		
		$consulta2 = pg_query($conexion, "SELECT nomnom FROM \"$esquema\".npnomina WHERE codnom = '$codigo_nomina';");
		if (!$consulta2) {
			//echo "No se pudo ejecutar la consulta."; exit;
		}

		while ($fila2 = pg_fetch_array($consulta2)) {
			$nombre_nomina = $fila2['nomnom'];
		}
		
		$dependencia = $fila['desniv'];
		$nombre_cargo = $fila['nomcar'];
		$cuenta_banco = $fila['cuenta_banco'];
		
		$consulta3 = pg_query($conexion, "SELECT monto FROM \"$esquema\".nphiscon WHERE cedemp = '$cedula' AND cuenta_banco = '$numero_cuenta' AND nomcon = 'SUELDO BASICO' AND fecnom BETWEEN '$fecha_i' AND '$fecha_f' AND especial = 'N' AND now()>=fecnom;");
		if (!$consulta3) {
			//echo "No se pudo ejecutar la consulta."; exit;
		}
		
		if(pg_num_rows($consulta3)==0&&$codigo_nomina!="006"&&$codigo_nomina!="007"){
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=nnc">'; exit;
		}

		while ($fila3 = pg_fetch_array($consulta3)) {
			$sueldo_basico_mensual = $fila3['monto']*2;
		}
	}
	
	$contador_asignaciones = 1;
	$nombre_asignacion[255]=array("");
	$monto_asignacion[255]=array("");
	
	$consulta_asignaciones = pg_query($conexion, "SELECT nomcon, monto FROM \"$esquema\".nphiscon WHERE cedemp = '$cedula' AND cuenta_banco = '$numero_cuenta' AND ASIDED = 'A' AND fecnom BETWEEN '$fecha_inicial' AND '$fecha_final' AND especial = '$tipo_nomina' ORDER BY codcon ASC;");
	if (!$consulta_asignaciones) {
		//echo "No se pudo ejecutar la consulta."; exit;
	}
	
	while ($fila_asignaciones = pg_fetch_array($consulta_asignaciones)) {
		$nombre_asignacion[$contador_asignaciones]=$fila_asignaciones['nomcon'];
		$monto_asignacion[$contador_asignaciones]=$fila_asignaciones['monto'];
		$contador_asignaciones++;
		$total_asignaciones += $fila_asignaciones['monto'];
	}
	
	$contador_deducciones = 1;
	$nombre_deduccion[255]=array("");
	$monto_deduccion[255]=array("");
	
	$consulta_deducciones = pg_query($conexion, "SELECT nomcon, monto FROM \"$esquema\".nphiscon WHERE cedemp = '$cedula' AND cuenta_banco = '$numero_cuenta' AND ASIDED = 'D' AND fecnom BETWEEN '$fecha_inicial' AND '$fecha_final' AND especial = '$tipo_nomina' ORDER BY codcon ASC;");
	if (!$consulta_deducciones) {
		//echo "No se pudo ejecutar la consulta."; exit;
	}
	
	while ($fila_deducciones = pg_fetch_array($consulta_deducciones)) {
		$nombre_deduccion[$contador_deducciones]=$fila_deducciones['nomcon'];
		$monto_deduccion[$contador_deducciones]=$fila_deducciones['monto'];
		$contador_deducciones++;
		$total_deducciones += $fila_deducciones['monto'];
	}
	
	$cuenta_contador = 0;
	if($contador_asignaciones>$contador_deducciones){
		$cuenta_contador=$contador_asignaciones;
	}else{
		$cuenta_contador=$contador_deducciones;
	}
	
	$total_cobrar=$total_asignaciones-$total_deducciones;
	
	if($total_cobrar==null||$total_cobrar=='0,00'||$total_cobrar==''){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ingreso.php?error=rne">'; exit;
	}
	
require('../fpdf17/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('P','Letter');
$pdf->SetMargins(10,20,10);
$pdf->Image('../imagenes/header_gobierno_recibo.png',10,10,195,12,'PNG');
$pdf->Cell(195,12,'',1,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(195,5,'RECIBO DE PAGO',1,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(195,6,'Gerencia de Recursos Humanos',0,1,'C');
$pdf->Cell(26,6,utf8_decode('Período de pago:'),0,0,'L');
$pdf->SetFont('Arial','',9);
if($tipo_nomina=="N"){
	$pdf->Cell(169,6,'Desde '.arregla_fecha($fecha_inicial).' hasta '.arregla_fecha($fecha_final),0,1,'L');
}else{
	$pdf->Cell(169,6,arregla_fecha($fecha_inicial),0,1,'L');
}
$pdf->SetFont('Times','B',9);
$pdf->Cell(195,6,'Datos del Trabajador',1,1,'C');
$pdf->Cell(24,6,'Trabajador:',0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(66,6,$nombre_empleado,0,0,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(37,6,utf8_decode('N° de Cédula de Identidad:'),0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(67,6,$cedula_empleado,0,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(24,6,'Fecha de Ingreso:',0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(66,6,arregla_fecha($fecha_ingreso),0,0,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(37,6,utf8_decode('Tipo de Nómina:'),0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(65,6,substr($nombre_nomina,0,25),0,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(24,6,'Dependencia:',0,0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(66,6,substr($dependencia,0,34),0,0,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(37,6,'Cargo:',0,0,'L');
$pdf->SetFont('Times','',7);
$pdf->Cell(67,6,substr($nombre_cargo,0,30),0,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(24,6,'',0,0,'L'); //Nro de Cuenta: (texto)
$pdf->SetFont('Times','',9);
$pdf->Cell(66,6,'',0,0,'L'); //$cuenta_banco (variable)
$pdf->SetFont('Times','B',9);
if($tipo_nomina=="N"&&$codigo_nomina!="006"&&$codigo_nomina!="007"){
	$pdf->Cell(37,6,utf8_decode('Sueldo Básico Mensual:'),0,0,'L');
	$pdf->SetFont('Times','',9);
	$pdf->Cell(67,6,number_format($sueldo_basico_mensual,2,",","."),0,1,'L');
}else{
	$pdf->Cell(37,6,'',0,0,'L');
	$pdf->SetFont('Times','',9);
	$pdf->Cell(67,6,'',0,1,'L');
}
$pdf->SetFont('Arial','B',8);
$pdf->Cell(195,6,utf8_decode('Descripción'),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(72,6,'Asignaciones',1,0,'C');
$pdf->Cell(25,6,'Monto (Bs.)',1,0,'C');
$pdf->Cell(72,6,'Deducciones',1,0,'C');
$pdf->Cell(26,6,'Monto (Bs.)',1,1,'C');
$pdf->SetFont('Arial','',8);
									$su=1;
									while($su<$cuenta_contador){
										if(isset($nombre_asignacion[$su])){
											$pdf->Cell(72,6,utf8_decode($nombre_asignacion[$su]),1,0,'L');
											$pdf->Cell(25,6,number_format($monto_asignacion[$su],2,",","."),1,0,'R');
										}else{
											$pdf->Cell(72,6,'',1,0,'C');
											$pdf->Cell(25,6,'',1,0,'C');
										}
										if(isset($nombre_deduccion[$su])){
											$pdf->Cell(72,6,utf8_decode($nombre_deduccion[$su]),1,0,'L');
											$pdf->Cell(26,6,number_format($monto_deduccion[$su],2,",","."),1,1,'R');
										}else{
											$pdf->Cell(72,6,'',1,0,'C');
											$pdf->Cell(26,6,'',1,1,'C');
										}
										$su++;
									}
$pdf->SetFont('Arial','B',8);
$pdf->Cell(72,6,'Total Asignaciones',1,0,'C');
$pdf->Cell(25,6,number_format($total_asignaciones,2,",","."),1,0,'R');
$pdf->Cell(72,6,'Total Deducciones',1,0,'C');
$pdf->Cell(26,6,number_format($total_deducciones,2,",","."),1,1,'R');
$pdf->Cell(169,6,'Total a Cobrar',1,0,'R');
$pdf->Cell(26,6,number_format($total_cobrar,2,",","."),1,1,'R');
$pdf->SetFont('Arial','',5);
$pdf->SetXY(10,27);
$pdf->Cell(195,12,'',1,1,'C');	
$pdf->SetXY(10,45);
$pdf->Cell(195,24,'',1,1,'C');	
$pdf->Output();
?>
</body>
</html>