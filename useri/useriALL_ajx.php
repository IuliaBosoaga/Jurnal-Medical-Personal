<?php include('../config.php'); ?>
<?php
//******************* bloc incarcare LISTA *************************************
if($_GET['mod']=="lista")
{
	?>
	<div class="lista">
		
		<div style="margin-top:-20px;width:100%;height:550px;overflow:scroll;">	
			
				<table class="style1" cellspacing="0">				
				<thead style="height:0px;">
					<tr>
						<th id=""  style="width:40px;min-width:40px;">ID</th>
						<th id=""  style="width:130px;min-width:80px;">Nume </th>
						<th id=""  style="width:130px;min-width:80px;">Prenume</th>
						<th id=""  style="width:110px;min-width:90px;">Username</th>
						<th id=""  style="width:140px;min-width:120px;">E-mail</th>
						<th id=""  style="width:110px;min-width:90px;">Rol(Tip)</th>
						<th id=""  style="width:60px;min-width:60px;">Admin</th>
						
						<th id=""  > </th>
					</tr>
				</thead>	
				<tbody >
				<?php
						
						$sql = "SELECT * FROM cfg_useri order by id_user ";
						//echo $sql;					
						$rsuseri = mysqli_query($link,$sql);
						
							//echo mysqli_num_rows($rsuseri);
							while ($item_row = mysqli_fetch_array($rsuseri)) 
							{
								
								
								?>
								<tr id="listaarticol--<?php echo $item_row['id_user'] ?>|<?php echo $item_row['username'] ?>|<?php echo $item_row['mail'] ?>" >
									
									<td id="" style="width:40px;min-width:40px;"><?php echo $item_row['id_user'] ?></td>
									<td id=""  style="width:130px;min-width:80px;"><?php echo $item_row['nume'] ?></td>
									<td id=""  style="width:130px;min-width:80px;"><?php echo $item_row['prenume'] ?></td>
									<td id=""  style="width:110px;min-width:90px;"><?php echo $item_row['username'] ?></td>
									
									<td id="" style="width:140px;min-width:120px;"><?php echo $item_row['mail'] ?></td>
									<td id=""  style="width:110px;min-width:90px;">
									<?php echo $item_row['tip'] ?>
									
									
									</td>
									<td id="" style="width:60px;min-width:60px;">
									<?php if($item_row['tip']=="Administrator") {	?>  <img src='../images/ico_active_16.png' >  			<?php }?>
									</td>
									
											
									
									<td></td>
								</tr>
								<?php
							}
				
						//mysqli_close($link);
					?>
 		
				</tbody>
				
			</table>
		</div>
	
	</div>
	
	<div class="stare">
		<div id="info">
			Selectat: <input name="idselectat" type="text" id="idselectat" style="" value="" size="30">
			<input name="selectat" type="text" id="selectat" style="" value="">
		
		</div>
		<div class="paginare" style="float:right;display:block;">
		<?php echo $nrrec;?> inregistrari
		</div>
	</div>
<?php
// END LISTA 
}	

?>







<?php
//******************* BLOC pentru stergere in functie de un id selectat*************************************
 if ($_GET['mod']=="del")
{
	$vector = explode("|",$_GET['id']);
			$id_user=$vector[0];
			
			

	$item_sql="delete from cfg_useri where id_user=" . $id_user  . "";
	$item_rs=mysqli_query($link,$item_sql);
	if($item_rs){echo "Înregistrarea a fost ștearsă cu succes!";}
	else{echo "Nu se poate șterge înregistrarea!";}
// END bloc 
}	

?>


	
