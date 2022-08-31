
<?php	
// FORM EDITARE

	  
	  
if(isset($_GET['id'])){
		//extrag inregistrarea in functie de id pasat prin GET
	  $item_sql="select * from cfg_useri  where id_user = " . $_GET['id']  . "";
	  $item_rs=mysqli_query($link,$item_sql) ;
	  $item_row=mysqli_fetch_assoc($item_rs);
	?>
	<div id="blocform">
	
			
			<div class="camp_auto"> 
				<label>Nume: </label>
				<input name='nume' type='text' id='nume' value="<?php echo $item_row['nume'];?>" style="width:300px;">
			</div>	
				
			<div class="camp_auto"> 
				<label>Prenume:</label>
					<input name='prenume' type='text' id='prenume' value="<?php echo $item_row['prenume'];?>" style="width:300px;">
			</div>	
				<br>

			<div class="camp_auto"> 
				<label>CNP:</label>
					<input name='cnp' type='text' id='cnp' value="<?php echo $item_row['cnp'];?>" style="width:300px;">
			</div>	
				<br>					
			<div class="camp_auto"> 
				<label >E-mail :</label>
					<input name='email' type='text'  id='email' value="<?php echo $item_row['mail'];?>" style="width:300px;">
			</div>	
			<br>
			
			<div class="camp_auto"> 
				<label>Tip (ROL):</label>
				<div class="camp_auto"> 
					<select style="display:inline-block" name="tip" id="tip" size="1"  >
									
							<option value="Pacient" <?php if($item_row['tip']=="Pacient") {echo 'selected ' ; } ?>    > Pacient</option>
							<option value="Administrator" <?php if($item_row['tip']=="Administrator") {echo 'selected ' ; } ?>    > Administrator</option>
								
							
							
					</select>
						<?php if($_GET['id']==1 && $item_row['tip']=="Administrator"){?>
							 <img src='../images/ico_active_16.png' >
						<?php } ?>
					</div>
			</div>	
			
				<br>
			<div class="camp_auto"> 
				<label>Username (E-mail)*:</label>
					<input name='username' type='text' id='username' value="<?php echo $item_row['username'];?>" style="background:yellow;width:300px;">
			</div>			
				<br>	
			<div class="camp_auto"> 
				<label>Parola *:</label>
					<input name='parola' type='password' id='parola' value="<?php ;?>" style="background:yellow;width:300px;">
			</div>	
					<br>	
			<input name='submitedit' type='submit' class="button green" id='submitedit' style="display:block;" value='Save'>
		
		
	</div>

<?php
}
?>	
	

	
	
	



<?php	
// FORM ADAUGARE
if(!isset($_GET['id'])){?>

	<div id="blocform">
	
			
			<div class="camp_auto"> 
				<label>Nume: </label>
				<input name='nume' type='text' id='nume' value="" style="width:300px;">
			</div>	
				<br>
			<div class="camp_auto"> 
				<label>Prenume:</label>
					<input name='prenume' type='text' id='prenume' value="" style="width:300px;">
			</div>	
			<br>	


			<div class="camp_auto"> 
				<label>CNP:</label>
					<input name='cnp' type='text' id='cnp' value="" style="width:300px;">
			</div>	
				<br>				
			<div class="camp_auto"> 
				<label >E-mail :</label>
					<td ><input name='email' type='text'  id='email' value="" style="width:300px;">
			</div>		
			<br>
			
			<div class="camp_auto"> 
				<label>Tip (ROL):</label>
				<div class="camp_auto"> 
					<select style="display:inline-block" name="tip" id="tip" size="1"  >
									
							
							<option value="Pacient" <?php if($item_row['tip']=="Pacient") {echo 'selected ' ; } ?>    > Pacient</option>
							<option value="Administrator" <? if($item_row['tip']=="Administrator") {echo 'selected ' ; } ?>    > Administrator</option>
							
					</select>
						<?php if($_GET['id']==1 && $item_row['tip']=="Administrator"){?>
							 <img src='../images/ico_active_16.png' >
						<?php } ?>
					</div>
			</div>	
				
					
				<br>
			<div class="camp_auto"> 
				<label>Username (E-mail)*:</label>
					<input name='username' type='text' id='username' value="" style="background:yellow;width:300px;">
			</div>		
			<div class="camp_auto"> 		
					<label>Parola *:</label>
					<input name='parola' type='password' id='parola' value="" style="background:yellow;width:300px;">
			</div>
				<br>
			<input name='submitadd' type='submit' class="button green" id='submitadd' style="display:block;" value='Save'>
			
	
		
	</div>
<?php
}
?>	
	
	