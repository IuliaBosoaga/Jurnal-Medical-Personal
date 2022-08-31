<?php session_start();
header('Content-Type: text/html; charset=utf-8');
error_reporting(0); 
include("config.php"); 


	if (isset($_POST['submitreg'])) 
	{
		$username = mysqli_real_escape_string($link, $_POST['username']);
		$nume = mysqli_real_escape_string($link, $_POST['nume']);
		$prenume = mysqli_real_escape_string($link, $_POST['prenume']);
		$cnp = mysqli_real_escape_string($link, $_POST['cnp']);
		$email = mysqli_real_escape_string($link, $_POST['emailreg']);
		$parola = mysqli_real_escape_string($link, $_POST['parola']);
		$mobil = mysqli_real_escape_string($link, $_POST['mobil']);
		
		
		
			$parola1 = md5($parola);
			
			
			mysqli_query($link,"SET NAMES 'utf8'"); 
			
			
			$sqli="INSERT INTO cfg_useri (username, cnp, mail,parola,nume,prenume,tip, mobil) 
			VALUES ('" . trim($_POST['username']) . "','" . trim($_POST['cnp']) . "','" . trim($_POST['emailreg']) . "', md5('" . $_POST['parola'] . "'),'" . $_POST['nume'] . "','" . $_POST['prenume'] . "','Pacient','" . $_POST['prenume'] . "')";
			$rsi=mysqli_query($link, $sqli);
			
			if($rsi)
			{
				echo"<div style='color:green'><br><br>V-ați înregistrat cu succes. <br>După activarea contului vă veți putea loga prin introducerea adresei e-mail și a parolei.<br> <br>";
				echo "<a href='index.php'> Click aici pentru a vă autentifica! </a></div>";
				
				/*
				$subject = "Înregistrare pacient";
				$message= "V-ați înregistrat cu succes! \n";	
				$message .="Username(E-mail): " . $email . "\n"; 
				$message .="Parola: " . $parola . "\n"; 
				
				$message .="\n Vă mulțumim! \n"; 
				$from = "From: Aplicatie buletine analize medicale\r\n"; 
				
				mail($email, $subject, $message, $from);
				*/
			}
			else
			{	
				echo"<div style='color:red'><br><br>Înregistrarea nu a reușit, este posibil ca email-ul sau username-ul să fie deja folosite!<br> <br>";
				echo "<a href='index.php'> Click aici pentru a vă autentifica sau pentru a încerca să vă înregistrați din nou! </a></div>";
				
			}
			
			
			                                                
			
		

	}
?>