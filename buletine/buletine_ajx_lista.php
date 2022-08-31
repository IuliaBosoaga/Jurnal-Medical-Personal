<?php session_start();
//include('../head.php'); 
error_reporting(E_ALL ^E_NOTICE );
?>
<?php require_once('../config.php');?>
<?php //include("functii.php");?>
<?php


	//aflu sirsql 
	if(isset($_SESSION['buletine_sirsql'] ) && $_SESSION['buletine_sirsql'] != null)
	{
		$sql=$_SESSION['buletine_sirsql'];
	}
	else 
	{
		$tmpsir =" (DataRecoltare >= dataI and DataRecoltare<=dataF) ";
		
		 if(strtolower($_SESSION['SESS_TIP'])!="administrator")
		 {
			 	$tmpsir .=" and buletine.id_user= " .  $_SESSION['SESS_ID_USER'];
		 }
		
		$sql="select  buletine.NrBuletin, DataRecoltare, NrCerere, Concat(nume, ' ', prenume) as NumePrenume , cnp, if(left(cnp,1) =1 or left(cnp,1) =5 , 'Masculin', 'Feminin') as Sex , year(DataRecoltare) - if(left(cnp,1) in (1,2) , concat('19', mid(cnp,2,2)), concat('20', mid(cnp,2,2) )) as Varsta , dataI, dataF
		from buletine inner join cfg_useri on buletine.id_user=cfg_useri.id_user, tblperioada			
		WHERE " .$tmpsir . "  
		ORDER BY DataRecoltare desc  , buletine.NrBuletin desc";
		$_SESSION['buletine_sirsql']=$sql;
		
	}
	


 $sql . "<br><br>";

//paginare part 1
$pageNum = 1;
if(isset($_SESSION['buletine']['page']) && $_SESSION['buletine']['page']>0) 
{$pageNum = $_SESSION['buletine']['page'];}
if(isset($_GET['page'])) {$pageNum = $_GET['page'];}
$_SESSION['buletine']['page']=$pageNum;

$rowsPerPage = 100;
$offset = ($pageNum - 1) * $rowsPerPage;
//echo $sql;
$rs = mysqli_query($link,$sql);
$nrrec=mysqli_num_rows($rs);
$nrPagini = ceil($nrrec/$rowsPerPage); //nr de pagini


//******paginare partea 2
if($nrrec>0) 
{	
	
	//construiesc numerele de pagini
	$numere2="<div class='paginare-wrapper'>Pagina ";
	$a=2;$b=2;
		if($pageNum==$nrPagini){$a++;} 
		if ($pageNum-$a > 1) {$prev=$pageNum-$a-1;$numere2.= " <div class=\"nrpag\"><a id=\"$i\" href=\"javascript:void();\"><</a></div> "; }
		for($i=$pageNum-$a; $i<=$pageNum+$b && $i<=$nrPagini;$i++)
		 {
			if($i<=0) {$b++;continue;}
			if($i==$pageNum)
			{	$numere2.="<div class=\"nrpagcur\" ><a id=\"$i\"href=\"javascript:void();\">$i</a></div>";		
			}
			else
			{	$numere2.="<div class=\"nrpag\" ><a id=\"$i\"href=\"javascript:void();\">$i</a></div>";		
			}
		 }
		if ($i < $nrPagini+1) {$numere2.= " <div class=\"nrpag\" ><a id=\"$i\" href=\"javascript:void();\">></a></div> "; }
	$numere2.=" ( " . $nrrec .  " inreg.)</div>";
}	

echo $numere2;
				

?>

	<div style="margin-top:-20px;width:100%;height:650px;overflow:scroll;">	
		<table class="style1 ">
			<thead >
					<tr >
						
						<th id="" >Nr. crt. </th>
						<th id="" >Data recoltare</th>
						<th id="" >Număr cerere</th>
						<th id="" >Nume și prenume</th>
						<th id="" >Sex</th>
						<th id="" >Vârsta</th>
						<th id="" >Număr analize</th>
					</tr>
				
			</thead>
			<tbody>
			
			<?php
			mysqli_query($link,"SET NAMES 'utf8'"); 
		
			$rs=mysqli_query($link, $sql . " LIMIT $offset, $rowsPerPage") ;
			while ($item_row = mysqli_fetch_array($rs)) 
			{ $i++;
				
				?>
				
				<tr id="rand--<?php echo $item_row['NrBuletin'] ?>" >
					<td id="" >	 <?php echo $item_row['NrBuletin'] ?>	</td>				
					<td ><?php echo date("d/m/Y",strtotime($item_row['DataRecoltare']));	 ?>	 </td>
					<td id=""><?php echo $item_row['NrCerere'] ?></td>
					<td id=""><?php echo $item_row['NumePrenume'] ?></td>					
					
				
					<td id="" > <?php 
						echo $item_row['Sex'] ;
					?>
					</td>
					
					<td id="" > <?php 
						echo $item_row['Varsta'] 
					?>
					</td>
					
					
					<td id="" > 
						<?php
						
						 $sira="select count(*) as NrAnalize from buletine_analize  where NrBuletin = " . $item_row['NrBuletin']  . " ";
						//echo $item_sql;
						$rsa=mysqli_query($link,$sira) ;
						$rowa=mysqli_fetch_assoc($rsa);
						echo $rowa['NrAnalize'] . " analize";
						?>
					</td>
					
				</tr>
				<?php
			}
				
				//mysqli_close($link);
				?>

			</tbody>
			</table>
			
		
			
	</div>	
	<div class="stare">
		<div id="info">
			 <input name="idselectat" type="text" id="idselectat" style="" value="" size="30">
			<input name="selectat" type="text" id="selectat" style="" value="">
		
		</div>
		<div class="paginare" style="float:right;display:block;">
		<?php echo $nrrec;?> inregistrari
		</div>
	</div>
<!-- #TABLE ********************************************************* -->







