<?php
include ('alt_autoload.php-dist');
// Parse PDF file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();

?>


<div  style="display:inline-block;padding:8px;background:#fff;margin-top:15px;">
		
		<form name="form1" method="post"  style="margin-left:10px;" enctype="multipart/form-data" action="main.php?p=parsare_PDF_test" >

		Selectați fișierul PDF Synevo ce conține buletinul de analiză<br>
			<br> <input name="image" type="file" >		
			<br><input name="submitaddfisier" type="submit"  style="btnadaugare" value="Incarcă fișier PDF cu analize">
		</form>
	</div>



<?php

$fisiercomplet='' ;

 	if ($_POST['submitaddfisier'])
	{
		
		 $path_dir="fisiere/incarcate";
          if(is_dir($path_dir)) {
           echo "Folder existent : " . $path_dir; }
           else {
           mkdir($path_dir,0755) or die("director necreat");
          echo "S-a creat folderul " . $path_dir;
          }
		
		$image=$_FILES['image']['name']; 
		if ($image)  	
		{ 
			$filename = stripslashes($_FILES['image']['name']); 
			if (strtoupper(substr($filename,-3))=="PDF") 
			{
				$newname=$path_dir . "/" . $filename ;
				$copied = copy($_FILES['image']['tmp_name'], $newname);
				$fisiercomplet=$newname;
				echo '<span style="color:green;">';
				echo "<br>Ați încărcat fișierul PDF " . $filename . "!";
				echo '</span>';	
			
			}
			else{

				echo '<span style="color:red;">';
				echo "<br>Fișierul nu este de tipul acceptat!";
				echo '</span>';
			}
		}

		else{
				echo '<span style="color:red;">';
				echo "<br>Nu ați selectat nici un fișier!";
				echo '</span>';
		}

	}


	





//se salveaza in baza de date buletinul pentru $_SESSION['SESS_ID_USER']
if (isset($_POST['submitaddParsare']))
	{
	echo "<div><br>";
	//construiesc sir adaugare in buletin
	$id_user=$_SESSION['SESS_ID_USER'];
	$DataRecoltare =  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['DataRecoltare'])));
	
	//inserez si aflu urmatorul numar buletin
		$sqli="INSERT INTO buletine (DataRecoltare,NrCerere, id_user) 
			VALUES ('" . $DataRecoltare . "', '" . trim($_POST['NrCerere']) . "',  " . $id_user . ")";
		echo $sqli . "<br><br>";
		$rsi=mysqli_query($link,$sqli) ;

		//aflu utimul id in tranzactie cu inserarea
		$sqllast="SELECT NrBuletin AS ultimul FROM buletine  
		ORDER BY NrBuletin DESC LIMIT 0 , 1 ";
		//echo $sqllast;
		$rslast=mysqli_query($link,$sqllast);
		$rowlast=mysqli_fetch_assoc($rslast);
		$NrBuletinUltim=$rowlast['ultimul'];
		

	//construiesc sir adaugare in buletin_analize
	$nrelem= count($_POST['rez']);
	for($i=0;$i<$nrelem;$i++)
	{
		$sqli2="INSERT INTO buletine_analize ( NrBuletin, IDA, Rezultat) 
		VALUES ( " .  $NrBuletinUltim . ", " . $_POST['IDA'][$i] . ", '" . $_POST['rez'][$i] . "')";
		echo $sqli2 . "<br>";
		$rsi2=mysqli_query($link,$sqli2) ; 
	}
	echo "<br><h1>Buletinul parsat a fost adăugat în baza de date și este afișat în modulul buletine de analiză!</h1>";
	echo "</div>";
	}















if (!isset($_POST['submitaddParsare']) && is_file($fisiercomplet))
	{
echo "<span style='color:blue;font-size:16px;'>
<br>Fișierul de parsat este: <br>" . $fisiercomplet . " </span>";
$pdf = $parser->parseFile($fisiercomplet);
$text = $pdf->getText();

 
	
	
//echo $text;
$pos1=strpos($text, "Sex:");
$pos2=strpos($text, "Prenume pacient:", $pos1+1);
//echo "<br>" .$pos1 . " - " . $pos2 . "<br>";
$CNP=substr($text,$pos1 +4, $pos2-($pos1+4) );



$NumePacient="";
$pos1=0;$pos2=0;
$pos1=strpos($text, "Prenume pacient:");
$pos2=strpos($text, "Data recol", $pos1+1);
//echo "<br>" .$pos1 . " - " . $pos2 . "<br>";
$NumePacient=substr($text,$pos1 +16, $pos2-($pos1+16) );


$pos1=$pos2+17;
$pos2=strpos($text, " ", $pos1);
//echo "<br>" .$pos1 . " - " . $pos2 . "<br>";
$DataRecoltarii=substr($text,$pos1, $pos2-$pos1);
	
$pos1=$pos2+1;
$pos2=strpos($text, " ", $pos1);
//echo "<br>" .$pos1 . " - " . $pos2 . "<br>";
$NrCerere=substr($text,$pos1, $pos2-$pos1-4);



?>
<hr>
<form method="post" action="main.php?p=parsare_PDF_test">
<b>Au fost extrase următoarele date:</b><br>
Data recoltării: <?php echo $DataRecoltarii;?><br>
Numar cerere: <?php echo $NrCerere;?><br>
	<input type="hidden" name="NrCerere" value="<?php echo $NrCerere ;?>">
	
	<input type="hidden" name="DataRecoltare" value="<?php echo $DataRecoltarii ;?>">
		

<hr>
Utilizator logat: <?php	echo $_SESSION['SESS_USER'] ;	?>
<br>
<h1>Au fost extrase următoarele analize și rezultate.
<br> Verificați și corectați rezultatele parsate în casete:
</h1><br>

<?php


//sterg parsare poziti anterior
$item_sqld="delete from parsare_analize ";
$item_rsd=mysqli_query($link,$item_sqld) ;


//caut analizele din baza de date in text pdf si salvez pozitiile unde incep si pozitiile unde se termina (incepe alta analiza), pentru a le putea citi in ordine crescatoare a pozitiilor in text si a extrage linia unei analize

$sql="select * from nom_analize order by DenumireA";
$rs = mysqli_query($link,$sql) ;
$pos2=-1;
$pos2_prec=0;
$pos1=$pos2+1;

//******************************* salvare pozitii analize gasite******************************************
while ($item_row = mysqli_fetch_array($rs)) 
{
	$pos2=strpos($text, $item_row['DenumireA'], $pos1);
	if($pos2>0)
	{
		//echo "<br>Analiza gasita " . $item_row['DenumireA'] .  " pe pozitia " . $pos2 . "<br>";
		
		$sqli="INSERT INTO parsare_analize (IDA, DenumireA,PozitieInTextPDF, Um, IntervalRef) 
			VALUES (  " . $item_row['IDA'] . ",'" . $item_row['DenumireA'] . "', " . $pos2 . ",'" . $item_row['Um'] . "','" . $item_row['IntervalRef'] . "')";
			//echo $sqli;
			$rsi=mysqli_query($link,$sqli) ;
		
		//$pos1=$pos2+1;
		$pos2_prec=$pos2;
	}
	
}
	
		
		
		
	
	//parcurg analizele gasite in ordinea pozitilor si extrag liniile
		
	$sqlp="select *, replace(IntervalRef,' ','') as IntervalRefFaraSpatii from parsare_analize order by PozitieInTextPDF";
	$rsp = mysqli_query($link,$sqlp) ;	
	while ($rowp = mysqli_fetch_array($rsp)) 
	{
		$poznext=$rowp['PozitieInTextPDF'];
		//aflu pozitia imediat mai mare unde incepe urmatoarea analiza
		$sqlnext="select * from parsare_analize where PozitieInTextPDF> " . $rowp['PozitieInTextPDF'] . " order by PozitieInTextPDF limit 0,1";
		$rsnext = mysqli_query($link,$sqlnext) ;	
		$rownext = mysqli_fetch_assoc($rsnext);
		if($rownext['PozitieInTextPDF']> $poznext) 
			{$poznext=$rownext['PozitieInTextPDF'];}
		else
			{$poznext=strpos($text, "Medic", $rowp['PozitieInTextPDF']);}
		
		
		
		
		//afisez linia analiza extrasa
		echo "<br> " . $rowp['DenumireA']  . "<br>";
		
		$linieAnaliza=substr($text,$rowp['PozitieInTextPDF'], $poznext-$rowp['PozitieInTextPDF']); 
		//extrag din linie anumite parti care nu sunt necesare
		$posAltele=strpos($linieAnaliza, "Tiparit", 0);
		if($posAltele>0)
		{ $linieAnaliza=substr($linieAnaliza,0, $posAltele);  } 
			
		$posCateg=strpos($linieAnaliza,"Hematologie Hemograma");
		if($posCateg>0)
		{ $linieAnaliza=substr($linieAnaliza,0, $posCateg);  } 
		
		//elimin numele analizei prin inlocuire cu spatiu, UM si IntervalRef, ca sa ramana doar rezultatul
	    $linieAnaliza = str_replace("LT", " ", $linieAnaliza);
		$linieAnaliza = str_replace("*", " ", $linieAnaliza);
		
		//$linieAnaliza = preg_replace("/[[:blank:]]+/"," ",$linieAnaliza);
		
		//echo $rowp['IntervalRef'];
		$linieAnaliza = str_replace(trim($rowp['DenumireA']), " ", $linieAnaliza);
		
		$linieAnaliza = str_replace(trim($rowp['Um']), " ", $linieAnaliza);
		
		
	
		//elimin teste de neafisat in liniile analizelor
	
			
			$linieAnaliza = str_replace("/", "", $linieAnaliza);
			$linieAnaliza = str_replace("Profil lipidic", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Ser  ECLIA - electrochemiluminiscenta", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Conform NCEP ATP III", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Ser", " ", $linieAnaliza);
			$linieAnaliza = str_replace("spectrofotometrie", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Imunochimie", " ", $linieAnaliza);
			$linieAnaliza = str_replace("metoda", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Metoda", " ", $linieAnaliza);
			$linieAnaliza = str_replace("directa", " ", $linieAnaliza);
			$linieAnaliza = str_replace("enzimatica - colorimetrica", " ", $linieAnaliza);
			$linieAnaliza = str_replace("kinetica IFCC", " ", $linieAnaliza);
			$linieAnaliza = str_replace("cu piridoxal fosfat", " ", $linieAnaliza);
			$linieAnaliza = str_replace("kinetica IFCC", " ", $linieAnaliza);
			$linieAnaliza = str_replace("enzimatica", " ", $linieAnaliza);
			$linieAnaliza = str_replace("ECLIA - electrochemiluminiscenta", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Alaninaminotransferaza (GPTALATA )", " ", $linieAnaliza);
			$linieAnaliza = str_replace("- optim: < 100- optim la limita: 100-129- borderline crescut: 130-159 - crescut: 160-189- foarte crescut: ≥ 190", " ", $linieAnaliza);
		    $linieAnaliza = str_replace("microfotometrica", " ", $linieAnaliza);
		    $linieAnaliza = str_replace("capilara", " ", $linieAnaliza);
		    $linieAnaliza = str_replace("imunocromatografica", " ", $linieAnaliza);
			$linieAnaliza = str_replace("Fecale ", " ", $linieAnaliza);
			
			$intervaldesters= $rowp['IntervalRef']; 
			$linieAnaliza = str_replace($intervaldesters, "", $linieAnaliza);
			//echo $linieAnaliza;
			
	
		
		
		$linieAnaliza=trim($linieAnaliza);
		if(floatval($linieAnaliza)>0) 
		{$linieAnaliza=floatval($linieAnaliza);} 
		else
		{
			$posUltimSpatiu=strripos($linieAnaliza," ");
			//echo "ultim spatiu " . $posUltimSpatiu;
			if ($posUltimSpatiu>0)
			{	$linieAnaliza=substr($linieAnaliza,$posUltimSpatiu); }
		
		
		
		}
		$linieAnaliza=trim($linieAnaliza);
		
		?>
		<input type="hidden" name="IDA[]" value="<?php echo $rowp['IDA']  ?>"> <br>
		<input type="text" style="width:110px" name="rez[]" value="<?php echo $linieAnaliza  ?>"> <br>
		
		<?php
		
		//echo "" . $linieAnaliza . "<br>";


	}
	
	?>
	
	
	
<br><br>
	<input name="submitaddParsare" type="submit" class="button blue submit"  style="position:relative;font-size:20px"  value="Salvează buletinul parsat în baza de date a aplicației ">
	<br>	<br>	
		
</form>
	
	
	

	<br>
	


	<?php
	
}	 /*   end if nu s-a apasat post submit parsare in bd */
	//******************************************************************





?>	