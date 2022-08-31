




<?php
//******************* DACA este setat mod addart sau edit art******************
if( isset($_GET['mod'])) 
{
	?>
	

			
		<?php
		///formular EDIT sau ADD
		//***********************************************************************************************
		if ($_GET['IDA']>0)
		{
			 $item_sql="select * from buletine_analize
			 where IDA = " . $_GET['IDA']  . "  and NrBuletin= " . $_GET['NrBuletin'] . "";
			//echo $item_sql;
			$item_rs=mysqli_query($link,$item_sql) ;
			$row=mysqli_fetch_assoc($item_rs);
			
			
		}
		 ?>
				<?php if ($_GET['IDA']>0) { ?>
					<form name="formeditart" id="formeditart" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?IDA=<?php echo $_GET['IDA'] ;?>&NrBuletin=<?php echo $_GET['NrBuletin'] ;?>" >
					<input type="hidden" name="IDAold" value="<?php echo $_GET['IDA'] ;?>">
			
				<?php } 
				else {
					?>
					
					<form name="formeditart" id="formeditart" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?NrBuletin=<?php echo $_GET['NrBuletin'] ;?>" >
					
				<?php } ?>
				


				<div class="camp_auto camprand" >
					<label>Analiza  </label> 
							
					<div style="display:inline-block">
						
						<select style="" name="IDA"  id="IDA" >
						<?php
						$sirA="select * from  nom_analize order by DenumireA";
						$rsA=mysqli_query($link,$sirA) ;
						while ($rowA = mysqli_fetch_array($rsA)) 
						{
							?>
							<option value="<?php echo  $rowA['IDA'];?>" <?php if($row['IDA']==$rowA['IDA']) {echo 'selected ' ; } ?>	><?php echo  $rowA['DenumireA'];?> </option>
							<?php
						}
						?>
						</select>
					</div>	
				</div>		
						
									
					<div class="camp_auto " >
						
						<label >Rezultat   </label>
						<input style="" name='Rezultat' type='text' id='Rezultat' value="<?php echo  $row['Rezultat'];?>">
						
					</div>	
					
				<br>	
				
			
				<?php if ($_GET['IDA']>0) { ?>
					<div class="camprand" >	
						<input name='submiteditart' type='submit' class="button green submit" style="width:auto;position:relative;float:right;margin-right:10px;margin-top:15px;font-size:14px" value='Salvează rezultat analiză'>
					</div>
				<?php } 
				else { ?>
				
				
				
					<div class="camprand" >	
					
						<input name="submitaddart" type="submit" class="button blue submit"  style="width:auto;position:relative;float:right;margin-right:10px;margin-top:15px;font-size:14px"  value="Adaugă rezultat analiză ">
					</div>
				<?php } ?>
				
				
			
				</form> 
				
				
				
				
<?php
	}
?>