<? session_start();?>

<? include("../config.php"); ?>

<?

if($_GET['id_user']>0){

	//validare editare

	$result=mysql_query("select mail from cfg_useri  where mail ='" . $_GET['email'] . "' and id_user<>" . $_GET['id_user'] . "");

}

else{

	//validare adaugare

	$result=mysql_query("select mail from cfg_useri  where mail ='" . $_GET['email'] . "'");

	

}



	

if(mysql_num_rows($result)>0){		

		 echo "1";

		//no means not available

	}

	else{

		echo "0";

	}

?> 

