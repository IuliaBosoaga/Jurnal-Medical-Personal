<?php //include('head.php'); ?>

 
<?php
$page=1;
if(isset($_POST['toate']) )
{
	
	$_SESSION['buletine_cauta']=null;
	$_SESSION['buletine_sirsql']=null;
	$_SESSION['buletine_IDA']=null;
}

if(isset($_POST['cautare']))
{
	
	$DataI =  date('Y-m-d', strtotime(str_replace('/', '-', $_POST['DataI'])));
	$DataF =  date('Y-m-d', strtotime(str_replace('/', '-', $_POST['DataF'])));

	$item_sql="update tblperioada set DataI='" . $DataI . "', DataF='" . $DataF . "'";
	$item_rs=mysqli_query($link,$item_sql) ;

	$tmpsir =" (DataRecoltare >= dataI and DataRecoltare<=dataF) ";
	
	if(strlen($_POST['cauta'])>0  && strtolower($_SESSION['SESS_TIP'])=="administrator") 
	{
		$tmpsir.= " and (CNP like '%" . $_POST['cauta'] . "%' or NumePrenume like '%" . $_POST['cauta'] . "%' )";
	}
	
	
	 if(strtolower($_SESSION['SESS_TIP'])!="administrator")
		 {
			 	$tmpsir .=" and buletine.id_user= " .  $_SESSION['SESS_ID_USER'];
		 }
	
	
		$sql="select  buletine.NrBuletin, DataRecoltare, NrCerere, Concat(nume, ' ', prenume) as NumePrenume , cnp, if(left(cnp,1) =1 or left(cnp,1) =5 , 'Masculin', 'Feminin') as Sex , year(DataRecoltare) - if(left(cnp,1) in (1,2) , concat('19', mid(cnp,2,2)), concat('20', mid(cnp,2,2) )) as Varsta , dataI, dataF
		from buletine inner join cfg_useri on buletine.id_user=cfg_useri.id_user, tblperioada			
		WHERE " .$tmpsir . "  
		ORDER BY DataRecoltare desc , buletine.NrBuletin desc";
		
	$_SESSION['buletine_sirsql']=$sql;
	if(isset($_POST['cauta'])) {$_SESSION['buletine_cauta']=$_POST['cauta'];}
	if(isset($_POST['IDA'])) {$_SESSION['buletine_IDA']=$_POST['IDA'];}
	
	
}

if(isset($_SESSION['buletine_sirsql'])){
	$sql=$_SESSION['buletine_sirsql'];
}
else{

}



?>



 
 
 
<script type="text/javascript" >
function reloadlista(nrpag){
		$(document).ready(function(){
			$('#bloclista').html("<br><br><center><img src='images/ajax-loader.gif'></center>"); 	
		
			$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url:"buletine/buletine_ajx_lista.php",
						data: "page=" + nrpag  ,
						success: function(data) {
							var content = data;			
						    $('#bloclista').html(content); 	
						}
				});
				
		
		});
	}	

	
$(document).ready(function(){
	reloadlista(<?php echo $page;?>);
	//************** LISTA *************************************
	$('#bloclista').on('click', 'table.style1 tbody tr', function(){
		$('#bloclista table.style1 tbody tr').css({ 'background-color' : 'white'});
		$('#bloclista table.style1 tbody tr:hover').css({ 'background-color' : '#acd5f8'});
		$(this).css('background-color', '#acd5f8');	
		var idselectat = $(this).attr('id') ;
		$('#idselectat').val(idselectat);
			
	}); 
	
	
	$("#bloclista").on('click', '.nrpag a', function(){
		var nrpag=this.id; //		alert(nrpag);
		reloadlista(nrpag);
	});		

	$(".btnadaugare").click(function(){ 
		popwin("buletine/buletin.php"  ,'Buletin analiza',1200,600);
	});	
	
	
	//deschidere editare window
	$(".btneditare").click(function(){ 
		var NrBuletin=$('#idselectat').val().split('--')[1];
		if (NrBuletin.length==0) {
		alert("Nu ați selectat nici o înregistrare!");
		}
		else{
			popwin("buletine/buletin.php?NrBuletin=" + NrBuletin ,'Buletin analiza',1200,600);
		}
	
	});	
	
	
	//apel delete
	$('#btnstergere').click(function(){ 
		var NrBuletin=$('#idselectat').val().split('--')[1];
		if (NrBuletin.length>0){
			if(confirm("Sigur doriți să ștergeți înregistrarea selectată? [NrBuletin=" + NrBuletin + "]"))
				{
					$.ajax({
					   type: "GET",
					   async: false,   
					   url: "buletine/buletine_ajx_del_exec.php",
					   data: "NrBuletin=" + NrBuletin , 
					   success: function(data)
					   {
						   rez=data;
						  // alert(rez); 
					   }
					 });
					 
					 if(rez) 
					 {  	
						reloadlista(<?php echo $page;?>);
				
					 }
				
				}
				else
				{false;	}
			
		}
		else{
			alert("Nu ați selectat nici o înregistrare de șters!");
		
		}
		
	});

	});	




</script>








 
 
	<div class="titlufereastra txtmov" style="background:#D6EAF8; color:#000">  Centralizator buletine de analiză
			
	</div>	 
	<div class="cautare" style="display:none;">	</div>	
		
		<div class="filtrare">
		
			<form style="display:block; float:left;width:auto;border:0px solid red;margin:0px;"  name="formcautare" method="post" id="formcautare" action="main.php?p=<?php echo $_GET['p'];?>">
								
			
				<div class="camp_auto" > 
					<?php
						$sirp="select * from tblperioada ";
						 $rp=mysqli_query($link,$sirp) ;
						$rowp=mysqli_fetch_assoc($rp);

					?>
					
					
					<?php // echo date("d/m/Y", strtotime($rowp['DataI'])); ?>
					<?php //echo date("d/m/Y", strtotime($rowp['DataF'])); ?>
					
					<label>Perioada &nbsp &nbsp	</label> 
					
					<input style="width:130px" name='DataI' type='text' id='DataI' value="<?php echo date("d/m/Y", strtotime($rowp['DataI'])); ?>"> &nbsp&nbsp 
					
					
					<input style="width:130px" name='DataF' type='text' id='DataF' value="<?php echo date("d/m/Y", strtotime($rowp['DataF'])); ?>"> &nbsp&nbsp
				</div>
				
					
			
		
				<?php if(strtolower($_SESSION['SESS_TIP'])=="administrator")
				{?>
				<div class="camp_auto"> 
					<label>CNP / Nume prenume</label>
					<input style="width:240px;" name='cauta' type='text' id='cauta' value="<?php echo $_SESSION['buletine_cauta'];?>"  tabindex=0>
				</div>	
				<?php
				}
				?>				
	
				
				<?php if(strtolower($_SESSION['SESS_TIP'])!="administrator")
				{?>
				<div class="camp_auto camprand" >
					<label>Analiza  </label> 
							
					<div style="display:inline-block">
						
						<select style="" name="IDA"  id="IDA" >
						<option value="" <?php if($_SESSION['buletine_IDA']=="") {echo 'selected ' ; } ?>></option>
						<?php
						$sirA="select * from  nom_analize order by DenumireA";
						$rsA=mysqli_query($link,$sirA) ;
						while ($rowA = mysqli_fetch_array($rsA)) 
						{
							?>
							<option value="<?php echo  $rowA['IDA'];?>" <?php if($_SESSION['buletine_IDA']==$rowA['IDA']) {echo 'selected ' ; } ?>	><?php echo  $rowA['DenumireA'];?> </option>
							<?php
						}
						?>
						</select>
					</div>	
				</div>	
				<?php
				}
				?>		
	
			
				&nbsp &nbsp
				<input name="cautare" class="btnfiltrare" type="submit" id="submit" value="&nbsp &nbsp Filtrează">
				
				
				
				<input name="toate" class="button gray" type="submit" id="submit" value="Toate">
				&nbsp &nbsp &nbsp&nbsp 
				</form>
				</div>	
				
				<div style="width:100%;border:0px solid red;">
				<br>	<br>	

				
				
				
				
				<?php if(strtolower($_SESSION['SESS_TIP'])!="administrator")
				{?>
				
					<a name='' class="btnraport" style="" id='' href="javascript:popwin('buletine/rptStatisticiAnalize.php','Raport analize',1100,700)"> &nbsp &nbsp &nbsp Raport statistici rezultate pe analiză </a>&nbsp
					
					<a name='' class="btnraport" style="" id='' href="javascript:popwin('buletine/rptAnalizeEvolutieTimp.php','AnalizeEvolutieTimp',1100,700)"> &nbsp &nbsp &nbsp Raport evoluție analiză în timp </a>&nbsp
					
					<a name='' class="btnraport" style="" id='' href="javascript:popwin('buletine/rptGrafic.php','Grafic analize',1100,700)"> &nbsp &nbsp &nbsp Grafic evoluție analiză în timp  </a>&nbsp
					
					
				<?php
				}
				?>
			
				
				
				</div>
		
				
				
		
		
		
		<div class="butoane">
	
			<a name='btnstergere' class="button  btnstergere  gray" style="position:relative;float:right;" id='btnstergere' href="javascript:void();"> Ștergere </a>
	
		
			<a name='btneditare' class="button  btneditare green " style="position:relative;float:right;" id='btneditare' href="javascript:void();"> Editare </a>
		
			<a name='btnadaugare' class="button  btnadaugare blue "  style="position:relative;float:right;" id='btnadaugare' href="javascript:void();"> + Buletin nou </a>
		
				
		</div>
		
		<div id="bloclista">
		
		</div>


	






</body>
</html>
