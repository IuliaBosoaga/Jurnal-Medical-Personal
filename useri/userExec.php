<?php session_start();  ?>
<?php require_once('../config.php');  ?>
<?php	
	//inserez idnou sau aflu id existent din GET
		if(!isset($_GET['id']))
		{
			//mysqli_query($link,"BEGIN");
			//inserez doar cu username si email si parola
			$sqli="INSERT INTO cfg_useri (username, cnp, mail,parola,nume,prenume,tip) VALUES ('" . trim($_POST['username']) . "','" . trim($_POST['cnp']) . "','" . trim($_POST['email']) . "', md5('" . $_POST['parola'] . "'),'" . $_POST['nume'] . "','" . $_POST['prenume'] . "','" . $_POST['tip'] . "')";
			echo $sqli;
			$rsi=mysqli_query($link,$sqli) ;
			if(!$rsi)
			{
				header("location: user.php");
			}
			
			
			//aflu utimul id in tranzactie cu inserarea
				//aflu ultimul id
				
			$sqllast="SELECT id_user FROM cfg_useri ORDER BY id_user DESC LIMIT 0 , 1 ";
			$rslast=mysqli_query($link,$sqllast);
			$rowlast=mysqli_fetch_assoc($rslast);
			$id=$rowlast['id_user'];
						
			//if($rsi){mysqli_query($link,"COMMIT");}
			//else{ mysqli_query($link,"ROLLBACK");}
			
			header("location: user.php?id=" . $id);
		}
		else{
			$id=$_GET['id'];
			$sir="";
			
			
			if(strlen(trim($_POST['parola']))>0 )
			{ $sir.="  parola=md5('" . trim($_POST['parola']) . "'), "; }
			
			$sir.="  username='" . trim($_POST['username']) . "', ";
			$sir.="  mail='" . trim($_POST['email']) . "', ";
			$sir.="  nume='" . trim($_POST['nume']) . "', ";
			$sir.="  prenume='" . trim($_POST['prenume']) . "', ";
			$sir.="  cnp='" . trim($_POST['cnp']) . "', ";
			$sir.="  tip='" . trim($_POST['tip']) . "' ";
			//echo $sir;
			
			$sqlu="update cfg_useri set " . $sir . " where id_user=" . $id . "";
			echo $sqlu;
			if($id>0){$rsu=mysqli_query($link,$sqlu) ;}
			header("location: user.php?id=" . $id);	
		}
		
		

?>	