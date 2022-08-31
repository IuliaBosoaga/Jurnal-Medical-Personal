<?php
define('URL', 'Http://localhost/JurnalMedicalPersonal'); //pentru apeluri css si js DIN FISIERE PHP 
	define('DB_HOST', 'localhost');
	define('DB_DATABASE', 'analize');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
	
  	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
	
	if(!$link) {die('Failed to connect to server: ' . mysqli_error());	}
	//mysqli_set_charset('utf8', $link);
	mysqli_set_charset($link,'utf8' );
	//Select database
	$db = mysqli_select_db($link,DB_DATABASE);
	if(!$db) {die("Unable to select database");	}




	//functie pentru a  preveni SQL injection - curatare campuri
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if(!$link) {die('Failed to connect to server: ' . mysql_error());	}
		return mysqli_real_escape_string($link,$str);
	}
	
	
?>