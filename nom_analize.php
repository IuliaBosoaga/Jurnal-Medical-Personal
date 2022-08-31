<?php include('head.php'); 
error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
?>


<?php 
//actiune adaugare 
 if ( isset($_POST['submitadd']) &&  $_POST['submitadd'])
{

	
	$item_sql="insert into nom_analize(DenumireA, Um, IntervalRef) values('". $_POST['DenumireA'] . "', '". $_POST['Um'] . "', '". $_POST['IntervalRef'] . "') ";
	$item_rs=mysqli_query($link,$item_sql) ; 
}

 //actiune editare 
 if ( isset($_POST['submitedit']) && $_POST['submitedit'])
{
		
	$item_sql="update nom_analize set DenumireA='" . $_POST['DenumireA'] . "', Um='" . $_POST['Um'] . "'  , IntervalRef='" . $_POST['IntervalRef'] . "'where IDA=" . $_POST['idold'] . "";	echo $item_sql;
	$item_rs=mysqli_query($link,$item_sql) ;
	
	
	
	
}
  
  ///actiune stergere
   if (isset($_GET['mod']) && $_GET['mod']=="del")
{
  $item_sql="delete from nom_analize where IDA=" . $_GET['id']  . "";
  $item_rs=mysqli_query($link,$item_sql);
}




///construiesc sirul sql in functie de fiultru get
//if (isset($_GET['tip']) && $_SESSION['vehicule_tip']!=$_GET['tip'])
//{
	//$_SESSION['furnizori']['page']=null;
	
	//$_SESSION['vehicule_tip']=$_GET['tip'];
	//$sql = "SELECT * FROM listVehicule where specificatii like '%" . $_SESSION['vehicule_tip'] . "%' order by Um,DenumireA";
	//$_SESSION['vehicule_sirsql']=$sql;
//}

//if(isset($_SESSION['vehicule_sirsql'])){
	//$sql=$_SESSION['vehicule_sirsql'];
//}
//else{
	$sql="select * from nom_analize order by DenumireA";
//}






 ?>
 
<script type="text/javascript" >
$(document).ready(function(){
	//alert("dffdg");
	
	//$('#cauta').focus();
	
	//daca este editare deci exista id il selectez
	<?php
	if($_GET['mod']=="edit" && strlen($_GET['id'])>0) 
	{ ?>
		var id="<?php echo $_GET['id']; ?>";
		
		var noudiv='rand--' + id;
		//alert(noudiv);
		
		$(document.getElementById(noudiv)).css('background-color', '#acd5f8');	
		//$("#" + noudiv).css('background-color', '#acd5f8');	
		$('.bloclista').scrollTop($(document.getElementById(noudiv)).offset().top -<?php echo $_GET['top']; ?> );
		
		<?php 
	} 
	?>
	
		
	$('.bloclista').on('click', 'table.style1 tbody tr', function(){
		
		$('table.style1 tbody tr').css({ 'background-color' : 'white'});
		$('table.style1 tbody tr:hover').css({ 'background-color' : '#DDDDDD'});
		$(this).css('background-color', '#acd5f8');	
			
			var idselectat = $(this).attr('id').split('--')[1];
			var top=$(this).offset().top ;
			 window.location.href = "<?php echo $_SERVER['PHP_SELF'];?>?mod=edit&id=" + idselectat + "&top="+top;
			//$(this).css('background-color', '#acd5f8');
			//alert(idselectat);
			//$('#idselectat').val(idselectat);//document.getElementById('#idselectat').value=idselectat; 
		}); 
		
		
 //inchiderecuselectare		
	$('.bloclista').on('click', '.inchidecuselectare', function(){
		var codfz = $(this).attr('id');
		//alert(idrevenire);	
		 if(window.opener != null && !window.opener.closed)
		{
		     //alert(window.opener.name);
			window.opener.reloadlista_furnizor(codfz);
			window.close();
		}		  
	
	}); 
	
	
	
	 
			
	
});



</script>


 
 
	<div class="titlufereastra " style="background:#FFECB3;color:#000">Nomenclator analize</div>	 
	
	<div class="butoane">
		<button name="btninchidere" class="button btninchidere" id="btninchidere" onclick="javascript:window.close();" >&nbsp Închide</button>
			<!--
			<a id="" href="javascript:popwin('nom_tipauto.php','Nomenclator tip vehicul',500,550)">
						<img width="20px" style="vertical-align:middle;" src="images/discipline.png"> 
						N. categorii cheltuieli</a>
						
						-->
						
			<a style="margin-right:80px;" name='btnadaugare' class="button blue btnadaugare" id='btnadaugare' href="<?php echo $_SERVER['PHP_SELF'] . '?mod=add'; ?>">+ Analiză nouă</a>
	
		
	</div>	

	
		
	
	<div class="cautare" style="border:1px solid #ccc;width:90%; margin-bottom:15px;">
	<?php

	 ///formular adaugare daca nu este editare
	 if (isset($_GET['mod']) && $_GET['mod']=="add")
	 { 
	   
	   ?>
	   
											
		<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		
		<div class="camp_auto"> 
			<label>Analiza</label> 
			<input style="width:300px;" name='DenumireA' type='text' id='DenumireA' value="<?php echo $row['DenumireA'];?>">
		</div>
		<div class="camp_auto"> 
			<label>Um </label>
			<input style="width:300px;" name='Um' type='text' id='Um' value="<?php echo $row['Um'];?>">
		</div>
		<div class="camp_auto camprand"> 
				<label >Interval referință : </label><br>
				<textarea style="width:99%;height:90px; background:#FDF2E9;" name='IntervalRef' type='text' id='IntervalRef' ><?php echo $row['IntervalRef'];?></textarea>
			</div>
			
		
		
		
		
		<input name="submitadd" class="button blue" type="submit" id="submit" value="Adauga">
		</form>
		
		
		<!--<div class="notification note-attention"></div>-->
	<?php
	 }

	 ///formular editare
	 if (isset($_GET['mod']) && $_GET['mod']=="edit")
	 {
	  $item_sql="select * from nom_analize  where IDA = " . $_GET['id']  . "";
	  //echo $item_sql;
	$item_rs=mysqli_query($link,$item_sql) ;
	$row=mysqli_fetch_assoc($item_rs);

	  ?>
		<form name="form1" id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<input name='idold' type="hidden" id="idold" value="<?php echo $row['IDA'];?>"><br>
			<b>ID <?php echo $row['IDA'];?> </b><br>
			<div class="camp_auto"> 
				<label>Analiza</label> 
				<input style="width:300px;" name='DenumireA' type='text' id='DenumireA' value="<?php echo $row['DenumireA'];?>">
			</div>	
			<div class="camp_auto"> 
				<label>Um</label>   
				<input style="width:100px;" name='Um' type='text' id='Um' value="<?php echo $row['Um'];?>">
			</div>
			
			<div class="camp_auto camprand"> 
				<label >Interval referință : </label><br>
				<textarea style="width:99%;height:90px; background:#FDF2E9;" name='IntervalRef' type='text' id='IntervalRef' ><?php echo $row['IntervalRef'];?></textarea>
			</div>
			
			<input name='submitedit' type='submit' class="button green" id='submitedit' value='Save'>

		</form> 
			
		
	 

	<?php
	 }

	?>
</div>
	
	
	
	
	


<!-- TABLE ********************************************************* -->
	<div class="bloclista" style="float:left;display:block;width:94%;">
			<table class="style1 datatable" style="">
			<thead>
				<tr>
					<th >ID </th>
					
					<th >Analiza </th>
					<th >UM </th>
					<th >Interval referință </th>
					
					<th width="80px">... </th>
				</tr>
			</thead>
			<tbody>
			
				<?php
				//echo $sql;
				
				$rs = mysqli_query($link,$sql) ;
				$nrrec=mysqli_num_rows($rs);
				
				if ($nrrec < 1) {
				 // echo "<P><em>No records.</em></p>";
				} else {
						$i=0;
						//$nrcampuri= mysqli_num_fields($rs);
						while ($item_row = mysqli_fetch_array($rs)) 
						{
							$urldel=$_SERVER['PHP_SELF'] . "?mod=del&id=". $item_row['IDA'];
							
							$urledit=$_SERVER['PHP_SELF'] . "?mod=edit&id=". $item_row['IDA'];
							
							
							
							
							
							?>
							<tr id="rand--<?php echo $item_row['IDA'] ?>" >
								<td ><?php echo $item_row['IDA'] ?> </td>
								
								
								<td ><?php echo $item_row['DenumireA'] ?> </td>
								<td ><?php echo $item_row['Um'] ?> </td>
								<td ><?php echo $item_row['IntervalRef'] ?> </td>
								<td >
								
									<!--<a href="<?php //echo $urledit; ?>"><img  src="images/ico_edit_16.png" class="icon16 fl-space2" alt="" title="Editeaza" /></a>
									&nbsp&nbsp&nbsp&nbsp-->
									
									<a  href="<?php echo $urldel;?>" 
									onclick="return confirm('Sigur doriți să ștergeți înregistrarea selectată? [IDA =' + '<?php echo $item_row['IDA'];?>' + ']')">
									<img  src="images/delete-icon16.png" class="icon16 fl-space2" alt="" title="Șterge" /></a>
									
									
								
								</td>
							</tr>
							<?php
						}
				}
				//mysqli_close($link);
				?>

			</tbody>
			</table>
	</div>	
<!-- #TABLE ********************************************************* -->







</body>
</html>
