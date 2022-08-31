<?php session_start();  ?>
<?php require_once('../config.php');  ?>
<?php	

	$nou="nu";
	$DataRecoltare =  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['DataRecoltare'])));
	
	
		if(!isset($_GET['NrBuletin']))
		{
			$nou="da";	
			
			//extrag id_user
			
			$id_user=$_POST['id_user'];
			
			mysqli_query($link,"BEGIN");
			//inserez doar cu username si email si parola
		
		
			$sqli="INSERT INTO buletine (DataRecoltare,NrCerere, id_user) 
			VALUES ('" . $DataRecoltare . "', '" . $_POST['NrCerere'] . "',  " . $id_user . ")";
			echo $sqli;
			$rsi=mysqli_query($link,$sqli) ;
			if(!$rsi)
			{
				header("location: buletin.php");
			}
			//aflu utimul id in tranzactie cu inserarea
			$sqllast="SELECT NrBuletin AS ultimul FROM buletine  
			ORDER BY NrBuletin DESC LIMIT 0 , 1 ";
			//echo $sqllast;
			$rslast=mysqli_query($link,$sqllast);
			$rowlast=mysqli_fetch_assoc($rslast);
			$NrBuletin=$rowlast['ultimul'];
			
			
			if($rsi && $rslast){mysqli_query($link,"COMMIT");}
			else{ mysqli_query($link,"ROLLBACK");}
		}
		else{
			$NrBuletin=$_GET['NrBuletin'];
			
		}
		
		//extrag id_user
			
			$id_user=$_POST['id_user'];
		
		$sir="";
		$sir.="  DataRecoltare='" . $DataRecoltare . "', ";
		$sir.="  id_user=" . $id_user . ", ";
		//$sir.="  CNP='" . $_POST['CNP'] . "', ";
		//$sir.="  NumePrenume='" . $_POST['NumePrenume'] . "', ";
		$sir.="  NrCerere='" . $_POST['NrCerere'] . "' ";
		
		//echo $sir;

		$sqlu="update buletine set " . $sir . " where NrBuletin=" . $NrBuletin . " ";
		echo $sqlu;
		$rsu=mysqli_query($link,$sqlu) ;
		if($nou=="da")
		{
			header("location: buletin.php?nou=da&NrBuletin=" . $NrBuletin . "");
		}
		else{
			header("location: buletin.php?nou=nu&NrBuletin=" . $NrBuletin . "");
		}
		
				
		

?>	