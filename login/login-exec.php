<?php session_start();?>
<?php include("../config.php");?>
<?php
	$errmsg_arr = array();
	$errflag = false;
	$login = $_POST['user'];
	$password = $_POST['parola'];
	
	
	if($login == '') {
		$errmsg_arr[] = 'Nu ați completat numele de utilizator!';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Nu ați completat parola!';
		$errflag = true;
	}
	

	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		//echo $_SESSION['ERRMSG_ARR'] ;
		session_write_close();
		header("location: ../index.php");
		exit();
	}
	


//caut in bd contul si parola introduse
	
	$qry="SELECT * FROM cfg_useri WHERE username='" . $login . "' and parola='". md5($_POST['parola']) ."'";
	
	$result=mysqli_query($link,$qry);
	//echo mysql_num_rows($result);
	
	if($result) 
	{
		if(mysqli_num_rows($result) == 1) 
		{
			$utilizator = mysqli_fetch_assoc($result);
			
			//**** VERIFICARE DE IP inainte de a salva in sesiune si a redirectiona la main.php*************
			
			$areacces="da";
			//if($utilizator['tip']!="Administrator") {include "ipverif.php";}
			
			
			//*****************************************************************
			
			session_regenerate_id();
			$_SESSION['SESS_ID_USER'] = $utilizator['id_user'];
			$_SESSION['SESS_USER'] = $utilizator['username'];
	
			$_SESSION['SESS_TIP'] = $utilizator['tip'];

			$_SESSION['start'] = time();
			session_write_close();
			header("location: ../main.php");
				//echo mysql_num_rows($result);
			exit();
			
		}
		else 
		{
			$errmsg_arr[] = 'Numele de utilizator sau parola nu sunt corecte. <br>';
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			//echo $_SESSION['ERRMSG_ARR'] ;
			header("location: ../index.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>