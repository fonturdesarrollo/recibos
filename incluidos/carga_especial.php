<?php
	require("../incluidos/bd-pgsql-recibos.php");
	if($_POST['aq']&&$_POST['mq']){
		$aq=$_POST['aq'];
		$mq=$_POST['mq'];
		if ($aq>="2018"){
			$esquema_buscar="SIMA9".substr($aq,2,2);
		} else {
			$esquema_buscar="SIMA0".substr($aq,2,2);
		}
		$resultado = pg_query($conn, "SELECT DISTINCT(to_char(fecnom,'DD')) FROM \"$esquema_buscar\".nphiscon WHERE especial = 'S' AND to_char(fecnom,'MM') = '".$mq."' AND to_char(fecnom,'YYYY') = '".$aq."' ORDER BY to_char(fecnom,'DD') ASC;");
		//$resultado = pg_query($conn, "SELECT DISTINCT(to_char(fecnom,'DD')) FROM \"SIMA016\".nphiscon WHERE especial = 'S' AND to_char(fecnom,'MM') = '".$mq."' AND to_char(fecnom,'YYYY') = '".$aq."' ORDER BY to_char(fecnom,'DD') ASC;");
		echo '<option value=""></option>';
		while($row = pg_fetch_row($resultado)){
			$data=$row[0];
			echo '<option value="'.$data.'">'.$data.'</option>';
		}
	}
?>