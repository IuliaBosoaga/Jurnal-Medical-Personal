	<div style="position:absolute;top:0px;left:1%;display:block;font-size:14px;font-weight:bold;">
			<a   id="" href="main.php">
				<img width="40px" style="vertical-align:middle" src="images/logo_medical_data.png"  />
				Jurnal Medical Personal
			</a>
			
	
	</div>
	
	
	<div style="position:absolute;top:0px;right:1%;display:block">
			
			 <a style="color:#fff" href="login/logout.php" class="button red">Iesire <br><?php	echo $_SESSION['SESS_USER'] ;	?> &nbsp </a>
	
	</div>
		
	<div style="background:#fff;height:auto;width:100%;display:inline-block;font-size:16px;
	border-top:1px dotted navy;vertical-align:top;margin-top:50px;">
				
				
				
	
	
				<a class="button " style="height:44px;background:#D5F5E3;width:auto;font-weight:normal" id="" 
						href="main.php?p=parsare_PDF_test" >
						<img width="32px" style="vertical-align:middle;" src="images/organizare32.png"> Parsare analize din fișier <br> PDF încărcat 
					</a>
					
					
				<a class="button " style="height:44px;background:#D6EAF8;width:auto;font-weight:normal" id="" 
						href="main.php?p=buletine" >
						<img width="32px" style="vertical-align:middle;" src="images/personaldata1.png"> Centralizator buletine de analiză <br> <br>
					</a>
								
				
					 <a class="button " id="" 
					 style="height:44px;background:#FFECB3;width:auto;border:1px solid:#FF7043;font-weight:normal; "  href="javascript:popwin('nom_analize.php','Nomenclator analize',800,650)" >
					 <img width="32px" style="vertical-align:middle;" src="images/discipline.png"> Nomenclator de analize <br> &nbsp
					 </a>
					 
					<?php if(strtolower($_SESSION['SESS_TIP'])=="administrator")
					{?>
					 <a  class="button "  id="" 
					 style="height:44px;background:#FBE9E7; width:auto;border:1px solid:#FF7043;font-weight:normal;" href="javascript:popwin('useri/useri.php','Useri',1050,650)"> 	
					 <img width="32px" style="vertical-align:middle;" src="images/users32.png"> 
						Utilizatori<br> &nbsp
						</a>
					<?php
					}
					?>		
					 
				
						
	</div> <!-- end meniu_bloc --->



		
