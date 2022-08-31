<?php error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);?>
<?php require_once('../config.php'); ?>
<?php
	$erori="";
	if(is_null($_POST['DataRecoltare']) || strlen($_POST['DataRecoltare'])==0  )
	{ 
		$erori="<br> - Nu ați completat data!"; 
	}
	if(is_null($_POST['NrCerere']) || !strlen($_POST['NrCerere'])>0 )
	{ $erori.="<br> - Nu ați completat numărul cererii!"; }
	


	if(is_null($_POST['id_user']) || !$_POST['id_user']>0 )
	{ $erori.="<br> - Nu ați selectat pacientul!"; }
	
	echo $erori;
?>