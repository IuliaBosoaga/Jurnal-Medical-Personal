<?php include('head.php'); ?>

<div class="container" style="">
	<div class="stanga" style="display:none;">
		
	</div>
	
	<div class="dreapta">
		<div class="sus" style="background:#fff;">
			<div style="float:left;display:block;border:0px solid green;width:100%">
			<?php

			
					include($cale . '/header_meniu.php');
				
			?>
			
			</div>
			
		
		</div>
		
		<div class="continut" >
		
		
		
		<br>

		
			
		<?php
		if(!isset($_GET['p']) )
		{		?>
			<br><br><br><h1 style="font-size:42px">
			<center> 
			<br>
			<img  style="vertical-align:middle" src="images/logo_medical_data.png"  />
			
			</center></h1>
		
			<?php
		}
		?>
		

		
			
			
			<?php
			
			if($_GET['p']=="parsare_PDF_test")
			{include ('pdf_parsare_buletin_analize.php');}
				
			if($_GET['p']=="buletine")
				{include ('buletine/buletine.php');}
			
			if($_GET['p']=="nom_analize")
				{include ('nom_analize.php');}
		
			?>
			
				
		
		
		</div><!-- end continut-->
		
	
	
	
	
	</div>



