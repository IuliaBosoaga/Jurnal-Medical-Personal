<?php session_start();
include('config.php');
//error_reporting(E_ALL);
error_reporting(E_ALL);
if(isset($_SESSION['SESS_USER']) )
{}
else{
$_SESSION['ERRMSG_ARR'] ="Sesinea de lucru a expirat și nu mai sunteți logat. <br>
Logați-vă din nou accesând link-ul <a href='" . URL . "' > " . URL . " </a>  și închideți alte ferestre rămase deschise!";
echo $_SESSION['ERRMSG_ARR'];
//header("location:  .index.php");
exit();
}
 //NEVER FORGET TO START THE SESSION!!!


$inactive = 2400; //secunde
if(isset($_SESSION['start']) ) 
{
	$session_life = time() - $_SESSION['start'];
		if($session_life > $inactive){
			$_SESSION['ERRMSG_ARR'] ="Ați fost inactiv mai mult de 10 minute. Închideți și logați-vă din nou!";
			unset($_SESSION['SESS_ID_USER']);
			unset($_SESSION['SESS_USER']);
			unset($_SESSION['SESS_NUMEPRENUME']);
			unset($_SESSION['SESS_TIP']);
			
			

			session_destroy ();
			echo $_SESSION['ERRMSG_ARR'];
			//header("Location: .index.php");
		}
}




//session_cache_expire(20);
$_SESSION['start'] = time();
?>