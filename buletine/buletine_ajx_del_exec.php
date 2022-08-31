<?php error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);?>
<?php require_once('../config.php'); ?>
<?php

	

$item_sql="delete from buletine  where NrBuletin = " . $_GET['NrBuletin']  . "";
$item_rs=mysqli_query($link,$item_sql) ;
//echo $item_sql;
$item_sql2="delete from Buletine_analiza  where NrBuletin = " . $_GET['NrBuletin']  . "";
$item_rs2=mysqli_query($link,$item_sql2) ;

	//echo $item_sql;
	
	if ($item_rs)
	{
	echo "1";
	}
	
	
?>