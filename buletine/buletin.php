<?php include('../head.php'); 
error_reporting(E_ALL ^E_NOTICE ^E_WARNING ^E_DEPRECATED);


if( isset($_GET['mod']) && $_GET['mod']=="del") 
{

//stergere analiza din buletin
$item_sql2="delete from buletine_analize  where NrBuletin = " . $_GET['NrBuletin']  . " and IDA = " . $_GET['IDA']  . "";
//echo $item_sql2;
$item_rs2=mysqli_query($link,$item_sql2) ;
}

?>




<?php
//exec editare
if(isset($_POST['submiteditart']))
{
	
		$sir="";

		$IDA=$_POST['IDA'] ;
		$sir.="  IDA=" . $IDA . ", ";
		$sir.="  Rezultat='" . $_POST['Rezultat'] . "' ";
		
	
		$sqlu="update buletine_analize set " . $sir . " where IDA=" . $_POST['IDAold'] . " and NrBuletin=" . $_GET['NrBuletin'] . "";
		//echo $sqlu;
		$rsu=mysqli_query($link,$sqlu) ;	
		
		
		
}
?>





<?php
//exec adaugare
if(isset($_POST['submitaddart']))
{
		
		//inserez		
		$sqli="INSERT INTO buletine_analize ( NrBuletin, IDA, Rezultat) 
		VALUES ( " .  $_GET['NrBuletin'] . ", " . $_POST['IDA'] . ", '" . $_POST['Rezultat'] . "')";
		//echo $sqli;
		$rsi=mysqli_query($link,$sqli) ;
				
		if($rsi && $rslast){mysqli_query($link,"COMMIT");}
		else{ mysqli_query($link,"ROLLBACK");}
		
		
		
}
?>



<script type="text/javascript">
	
function validare(form)
	{
		var errors = [];
		
			//verific erori in php prin ajx
			$.ajax({
					type: "POST",
					async: false,   // forces synchronous call
					url: "buletin_ajx_validare.php",
					data: $("#formedit").serialize(), // serializes the form's elements.
					success: function(data) {
						//alert(data);
						if(data!="")		
						{
							errors[errors.length] = data;	
						}		
					}
			});
		
		//errors[errors.length] = "Exista erori validare php!";	
	
		if (errors.length > 0) {
			var msg = "<br> ATENTIE!<br>";
			var numError;
			for (var i = 0; i<errors.length; i++) {
				numError = i + 1;
				msg += "" + errors[i];
			}
				afiseaza_in_popap_centru_2(msg,"error");
			return false;
		 }

		 return true;
		
	}
	
	

	</script>	
<script type="text/javascript" >
$(document).ready(function()
{

	
	<?php if ($_GET['NrBuletin']>0) {?>
		NrBuletin=<?php echo $_GET['NrBuletin'];?>;
		reloadlista_analize(NrBuletin);
	
	<?php }?>
	 
	
}); //end doc ready jquery

	


function inchideinapoi(){
		
			<?php 
				$pag=1;
				if($_SESSION['buletine_page'] !=null && $_SESSION['buletine_page']>1) {$pag==$_SESSION['buletine_page'];}
			?>
			window.opener.reloadlista(<?php echo $pag;?>);
			window.close();
	
}	
	
	
	

	
	
function reloadlista_analize(NrBuletin){
	$(document).ready(function(){
		$.ajax({
		type: "GET",
				async: false,   // forces synchronous call
				url:"buletin_ajx_analize_lista.php",
				data: "NrBuletin=" + NrBuletin ,
				success: function(data) {
					var content = data;			
					//alert(content);
					$('#bloclista_analize').html(content); 	
			
				}
		});
	});
}	
	


</script>



<?php 
	if(!isset($_GET['NrBuletin'])){?>	
		<div class="titlufereastra_add">Buletin de analiză / adăugare   <br> <span class="entitate"> <?php echo $_GET['NrBuletin']; ?> </span></div>
		<?php }
	else{	?>	
		<div class="titlufereastra_addedit">Buletin de analiză / editare <br><span class="entitate"> Numărul  <?php echo $_GET['NrBuletin']; ?> </span></div>
		<?php
	}
	?>	

	
		
	<button name="btninchidere" class="button btninchidere" id="btninchidere" onclick="javascript:inchideinapoi();" >&nbsp Închide</button>
		
	
	<div class="cautare" style="border:1px solid #ccc;width:97%">
	
			 
	
	
	
<?php
///formular EDIT sau ADD
//***********************************************************************************************
if ($_GET['NrBuletin']>0)
{
	  $item_sql="select  buletine.id_user, buletine.NrBuletin, DataRecoltare, NrCerere, nume, prenume, Concat(nume, ' ', prenume) as NumePrenume , cnp, if(left(cnp,1) =1 or left(cnp,1) =5 , 'Masculin', 'Feminin') as Sex , year(DataRecoltare) - if(left(cnp,1) in (1,2) , concat('19', mid(cnp,2,2)), concat('20', mid(cnp,2,2) )) as Varsta
		from buletine inner join cfg_useri on buletine.id_user=cfg_useri.id_user
	 where NrBuletin = " . $_GET['NrBuletin']  . " ";
	//echo $item_sql;
	$item_rs=mysqli_query($link,$item_sql) ;
	$row=mysqli_fetch_assoc($item_rs);
	
	
}
 ?>
		<?php if ($_GET['NrBuletin']>0) { ?>
			<form name="formedit" id="formedit" method="post" action="buletin_exec.php?NrBuletin=<?php echo $_GET['NrBuletin'] ;?>" onsubmit="return validare(this);">
			<input type="hidden" name="NrBuletin" value="<?php echo $_GET['NrBuletin'] ;?>">
			
		<?php } 
		else {
			?>
			
			<form name="formedit" id="formedit" method="post" action="buletin_exec.php" onsubmit="return validare(this);">
				
		<?php } ?>
		
		
			
		
		<div class="camp_auto" > 
			<label> Număr cerere &nbsp &nbsp	</label>
			 <input style="width:250px" name='NrCerere' type='text' id='NrCerere' value="<?php echo  $row['NrCerere'];?>">
			 
		</div>		
		
		<div class="camp_auto" > 
			<label> Data recoltare &nbsp &nbsp	</label> 
			<input style="width:250px" name='DataRecoltare' type='text' id='DataRecoltare' value="<?php if ($_GET['NrBuletin']>0) { echo  date("d/m/Y", strtotime($row['DataRecoltare'])) ;} else { echo  date("d/m/Y");}?>">
		</div>
		
		
		<br>
		
		<div class="camp_auto" > 
			<label> Pacient (utilizator) 	</label> 
			
			<select style="" name="id_user" id="id_user" size="1" >
				
				<?php
				if(!$_GET['NrBuletin']>0 )
				{
					$sqlsirs="SELECT id_user, nume, prenume , username FROM cfg_useri
					where id_user=" . $_SESSION['SESS_ID_USER'] . "
				order by nume,prenume"; 
					
				}
				else{
				$sqlsirs="SELECT id_user, nume, prenume , username FROM cfg_useri 
				order by nume,prenume"; 
				}				
				$rss = mysqli_query($link,$sqlsirs);
				while($rows = mysqli_fetch_array($rss))
				{		?>
					<option value="<?php echo $rows['id_user']; ?>" 	
					<?php if($row['id_user']==$rows['id_user']  ) 
							{echo 'selected ' ; }	?>	> 
							<?php echo $rows['nume'] ; ?> <?php echo $rows['prenume'] ; ?> 
					</option>
				<?php }	 ?>	 
			</select>
			
			
		</div>
		
		
		<br>
		
		
		
		<br>
		<div class="camp_auto" > 
			<label> Sex	</label>
			 <label style="width:250px"> 
				<?php  echo $row['Sex']  ; ?>
			 </<label>
			 
		</div>		
			
		<div class="camp_auto" > 
			<label> Vârsta	</label>
			 <label style="width:250px">   
			 <?php    echo $row['Varsta']  ;  ?>
			 </label>
			 
		</div>		
		
		
		
		 
		<?php if ($_GET['NrBuletin']>0) { ?>
			<div class="camp_auto" >	
				<input name='submitedit' type='submit' class="button green submit" style="position:relative;font-size:20px" value='Salvează'>
			</div>
			
	
		<?php } 
		else { ?>
			<div class="campedit" >	
				<input name="submitadd" type="submit" class="button blue submit"  style="position:relative;font-size:20px"  value="Adaugă ">
			</div>
		<?php } ?>
		
		
	
		</form> 
		
	
	
	
</div>





















<?php if ($_GET['NrBuletin']>0) { ?>
	<script type="text/javascript" >
	$(document).ready(function(){	

		
		$('#bloclista_analize').on('click', 'table.style1 tbody tr', function(){
			//alert( $(this).attr('id'));	
			$('table.style1 tbody tr').css({ 'background-color' : 'white'});
			$(this).css('background-color', '#acd5f8');	
			var idselectat = $(this).attr('id');
			$('#idselectat_analize').val(idselectat);
			$('#articol_editare').html("");
			
		}); 
		
		
		$(".adaugare_analize").click(function(){ 
			//popwin("buletin_articol.php?NrBuletin=" + <?php echo $_GET['NrBuletin'] ?>  ,'Articol factura',650,450);
			window.location.href = "<?php echo $_SERVER['PHP_SELF'];?>?NrBuletin=" + <?php echo $_GET['NrBuletin'] ?> + "&mod=addart"; 
		});	
	
		/*
		//deschidere editare window
		$(".editare_analize").click(function(){ 
		
			var IDA=$('#idselectat_analize').val().split('--')[1];
			var NrBuletin=$('#idselectat_analize').val().split('--')[2];
			
			if (IDA.length==0) {
			alert("Nu ati selectat nici o inregistrare!");
			}
			else{
				
				window.location.href = "<?php echo $_SERVER['PHP_SELF'];?>?NrBuletin=" + <?php echo $_GET['NrBuletin'] ?> + "&mod=editart&IDA=" + IDA + "";
			}
		
		});	
		*/
	
			
	}); 		
		
	</script>
	

	

	
	<div style="float:left;width:90%; margin-top:20x;">
	<br><br><br>
		<div style="text-align:right; font-size:14p;">
			<a href="javascript:void();" class="adaugare_analize" style="font-size:16px;">+ Adaugă analiză  </a>    &nbsp&nbsp&nbsp&nbsp
			
		
		</div>
		
		<div class="cautare" id="articol_editare">
			<?php include("buletin_inc_analiza_form_add_edit.php"); ?>
		</div>
		
		
	
		
		
		<div id="bloclista_analize" style="">
				
				

			<!-- TABLE ********************************************************* -->
				
				<div style="margin-top-0px;width:100%;height:auto;">	
						<table class="style1" style="font-size:16px !important;">
						<thead >
								<tr>
								<th id="" >Nr. crt.</th>	
								<th id="" >Analiza</th>
									<th id="" >Rezultat</th>
									<th id="" >UM</th>
									<th id="" >Interval de referință</th>
								
									<th id="" ></th>
								</tr>
						</thead>
						<tbody>
						<?php
							$sql = "SELECT buletine_analize.NrBuletin,buletine_analize.IDA, Rezultat,
							nom_analize.IDA, DenumireA, Um, IntervalRef
							from buletine_analize inner join nom_analize on buletine_analize.IDA=nom_analize.IDA
							where buletine_analize.NrBuletin=" . $_GET['NrBuletin'] . " 
							order by DenumireA";
							//echo $sql;
							$i=0;
							$rs = mysqli_query($link,$sql);
							while ($item_row = mysqli_fetch_array($rs)) 
							{
								$i++;
								?>
								<tr id="randarticole--<?php echo $item_row['IDA']; ?>--<?php echo $_GET['NrBuletin']; ?>">
									<td><?php echo $i ?> </td>
									<td><?php echo $item_row['DenumireA'] ?>  </td>
									<td><?php echo $item_row['Rezultat'] ?> </td>
									<td><?php echo $item_row['Um'] ?> </td>
									<td><?php echo $item_row['IntervalRef'] ?> </td>
									<td>
										<?php 
											$urldel="buletin.php?NrBuletin=" . $_GET['NrBuletin'] ."&mod=del&IDA=". $item_row['IDA'];
											$urledit="buletin.php?NrBuletin=" . $_GET['NrBuletin'] ."&mod=delart&IDA=". $item_row['IDA'];
									
										?> 
										<a href="<?php echo $urledit; ?>"><img  src="../images/ico_edit_16.png" width="24px" alt="" title="Editeaza" /></a>
										&nbsp&nbsp
										<a href="<?php echo $urldel;?>" 
												onclick="return confirm('Sigur doriti sa stergeti inregistrarea selectata? [IDA =' + '<?php echo $item_row['IDA'];?>' + ']')">
												<img  src="../images/delete-icon24.png" width="24px"  alt="" title="Sterge" /></a>
												
											
									</td>
									
								</tr>
								<?php
							}
						?>

						</tbody>
						</table>
						
				</div>	
				<div class="stare" style="background:transparent; border:0px;">
					<div id="info">
						<input class="idselectat" name="idselectat_articole" type="hidden"  readonly id="idselectat_articole" style="border:0px;" value="" size="20">
					</div>
					
				</div>
			<!-- #TABLE ********************************************************* -->



				
				
		</div>
	</div>

<?php } ?>


</body>
</html>
