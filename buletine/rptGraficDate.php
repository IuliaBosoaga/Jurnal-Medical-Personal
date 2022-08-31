<?php
session_start();
header('Content-Type: application/json');

require_once('../config.php');

$tmpsir =" (DataRecoltare >= DataI and DataRecoltare<=DataF) ";

if(strtolower($_SESSION['SESS_TIP'])!="administrator")
	 {
			$tmpsir .=" and buletine.id_user= " .  $_SESSION['SESS_ID_USER'];
	 }
	 
	 if(isset($_SESSION['buletine_IDA']) && strlen($_SESSION['buletine_IDA'])>0)
	 {
		 
		 $tmpsir .=" and buletine_analize.IDA= " .  $_SESSION['buletine_IDA'];
	 }
	 
		 
$sqlQuery="select  DataRecoltare, Rezultat
		from buletine 
			inner join cfg_useri on buletine.id_user=cfg_useri.id_user
			inner join buletine_analize on buletine_analize.NrBuletin=buletine.NrBuletin, tblperioada			
		WHERE " . $tmpsir . "  
		ORDER BY DataRecoltare ";
//echo $sqlQuery;		
		
$result = mysqli_query($link,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

echo json_encode($data);
?>