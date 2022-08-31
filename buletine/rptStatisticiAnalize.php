<?php 
session_start();
include('../config.php'); 
error_reporting(E_ALL);
?>



<style>
table { width: 100%; margin: 0px; margin-bottom: 20px; cell-padding:0px;cell-spacing:0px;}
table.style1 {width:100%; }
	table.style1 th	{ border: 1px solid #DDDDDD; font-size:12px;line-height: 12px; padding: 2px 3px 2px 3px; color: #333333; white-space: nowrap; text-align: left;	}
	table.style1 thead th {  background:#ebe8e8;padding-top: 2px;border-bottom:0px; }
	table.style1 thead td { background: #ccc; border: 1px solid #FFFFFF; text-align: left; line-height: 12px; padding: 1px 1px 1px 1px; white-space: nowrap; }
	table.style1 tbody { height: 60px;   overflow-y: auto;overflow-x: hidden;}
	table.style1 tbody tr{ width:100%;background: #fff; }
	table.style1 tbody tr td {  border: 1px solid #DDDDDD; font-size:14px;line-height: 14px; padding:5px;    color: #333333;}
	table.style1 .icon16		{ margin-top: 3px; margin-bottom: 3px; }
	table.style1 td.vcenter		{ vertical-align: middle; }
table.style1  {
    border-width: 1px;
    border-style: solid;
    
    border-collapse: collapse;
}

table.style1 tbody td {
    border-width: 1px;
    border-style: solid;
    
}

table.style1 thead th {
    border-width: 1px;
    border-style: solid;
    border-bottom:0px; border-bottom:0px;
	
    /*background-color: green;*/
}	
	
	
	
	
	
	
	
	
	
	
	
	
body {
  background: rgb(204,204,204);  background: #fff;
}
page[size="A4" {
  background: #fff;
  width: 21cm;
  height:auto;
  /* height: 29.7cm; */
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
 
}

@media print 
{
	  body, page[size="A4" {
		margin: 0;
		box-shadow: 0;
	  }
  
  
	

}

</style>

<link rel="stylesheet" href="style.css" type="text/css" media="print"/ >
<script type="text/javascript">		
function printpage() {

    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
   //var btninchidere = document.getElementById("btninchidere");
   // var reenterButton = document.getElementById("reenterthenews");

    //Set the button visibility to 'hidden' 
    printButton.style.visibility = 'hidden';
   // btninchidere.style.visibility = 'hidden';
    //reenterButton.style.visibility = 'hidden';

    //Print the page content
    window.print()

    //Restore button visibility
    printButton.style.visibility = 'visible';
   // btninchidere.style.visibility = 'visible';
   // reenterButton.style.visibility = 'visible';

}
</script>
<input style= "position:fixed;left:0;top:0;" id="printpagebutton" type="button" value="Print" onclick="printpage()"/>
<?php

//update tblperioada
//$DataI =  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_GET['dataI3'])));
//$DataF =  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_GET['dataF3'])));

//$item_sql="update tblperioada set dataI3='" . $DataI . "', dataF3='" . $DataF . "'";
//echo $item_sql;
//$item_rs=mysqli_query($link,$item_sql) ;
	

//extrag perioada salvata de butonul filtrare in tabel tblperioada
$sirp="SELECT * from tblperioada "; 
$rsp=mysqli_query($link,$sirp) ;
$rowp = mysqli_fetch_assoc($rsp) ;

$DataI =  date('d.m.Y', strtotime(str_replace('/', '-', $rowp['DataI'])));
$DataF =  date('d.m.Y', strtotime(str_replace('/', '-', $rowp['DataF'])));
	




$sql="";

$tmpsir =" (DataRecoltare >= DataI and DataRecoltare<=DataF) ";
		
		 if(strtolower($_SESSION['SESS_TIP'])!="administrator")
		 {
			 	$tmpsir .=" and buletine.id_user= " .  $_SESSION['SESS_ID_USER'];
		 }
		


$sql="select  nom_analize.IDA, DenumireA, UM, IntervalRef,
		count(*) as NrRezultate, 
		Min(Rezultat) as RezultatMinim,
		Max(Rezultat) as RezultatMaxim,
		AVG(Rezultat) as RezultatMedie
		from buletine 
			inner join cfg_useri on buletine.id_user=cfg_useri.id_user
			inner join buletine_analize on buletine_analize.NrBuletin=buletine.NrBuletin
			inner join nom_analize on buletine_analize.IDA=nom_analize.IDA, tblperioada			
		WHERE " .$tmpsir . "  
		group by nom_analize.IDA, DenumireA, UM, IntervalRef
		ORDER BY DenumireA ";

//echo $sql;


$sqluser="select   Concat(nume, ' ', prenume) as NumePrenume , cnp, if(left(cnp,1) =1 or left(cnp,1) =5 , 'Masculin', 'Feminin') as Sex 
		from cfg_useri 
		where id_user= " .  $_SESSION['SESS_ID_USER'];
///echo	$sqluser;	
$rsuser=mysqli_query($link,$sqluser) ;
$rowuser = mysqli_fetch_assoc($rsuser) ;
			
			
			



?>
	  
	  
<page size="A4">
<div id="raport_container" style="padding:8px;">

<center>

<h3>Raport statistici pe analize: valori medii, minime și maxime</h3>
Pacient: <?php echo $rowuser['NumePrenume'];?><br>
Sex: <?php echo $rowuser['Sex'];?> <br><br>

<span style="color:blue">Perioada : </span><?php echo $DataI;?> - <?php echo $DataF;?>
<br>

</center>



<div id="raport" style="font-size:12px;font-family:arial;">
<br>



		<table class="style1 norme" cell-spacing="0" cell-padding="0">
			<thead >
					<tr background="#ebe8e8" >
						<th id="" >Denumire</th>
						<th id="" >Număr de analize</th>
						<th id="" >Rezultat minim</th>
						<th id="" >Rezultat mediu</th>
						<th id="" >Rezultat maxim</th>
						<th id="" >UM</th>
						<th id="" >Interval referință</th>
						

						
					</tr>
			</thead>
			<tbody>
			
			<?php
			$CategoriePrec="";
			$t1grup=0;
			//ciclez prin recordset 
			
				$rs2 = mysqli_query($link,$sql) ;
				$i=0;
				$t1=0;
				while ($item_row = mysqli_fetch_array($rs2)) 
				{
								
				$i++;
					
				?>
						<tr >
							
								<td id="">  <?php echo $item_row['DenumireA'] ?> </td>	
								<td id="">  <?php echo $item_row['NrRezultate'] ?></td>	
								<td id="">  <?php echo $item_row['RezultatMinim'] ?></td>	
								<td id="">  <?php echo number_format($item_row['RezultatMedie'],2)?></td>	
								<td id="">  <?php echo $item_row['RezultatMaxim'] ?></td>	
								
								<td id="" style="background:#E9F7EF">  <?php echo $item_row['UM'] ?></td>
								<td id="" style="background:#E9F7EF">  <?php echo $item_row['IntervalRef'] ?>
						</tr>
					<?php	
					
				} //end 
				?>
			
			
			
				
			</tbody>
			</table>
			
		
		
	
	

	

	

	  
</div>
</div>
</page>