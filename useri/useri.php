<?php include('../head.php'); 
error_reporting(E_ALL ^E_NOTICE);
?>

<head>

<script type="text/javascript" >
$(document).ready(function(){
	
		reloadlista();
	
		//alert("jquery works");
			
	//buton filtrare lista
	$("#filtreaza").click(function(){ 
		reloadlista();	
	});	

	
	//click pe reload pentru refresh lista		
	$(".btnrefresh").click(function(){ 
		reloadlista();	
	});	
			
	//stergere articol prin ajax si refresh pagina 
	$(".btnstergere").click(function(){ 
		//var id=this.id.split('-')[1];
		var id=$('#idselectat').val();
		if (id.length==0 || id.split('|')[0]=="1") {
			alert("Nu ați selectat nici o înregistrare sau ați selectat user-ul cu ID=1 ce nu poate fi șters !");
		}
		else{
			//alert(id);
			if(confirm("Sigur doriți să ștergeți înregistrarea selectată: (" + id + ") ?"))
			{	$.ajax({
					type: "GET",
					async: false,   // forces synchronous call
					url:"useriALL_ajx.php",
					data: "mod=del&id="+ id,
					success: function(data) {
						var content = data;
						if(content.substring(0, 6)=="Eroare")
						{ 
							afiseaza_in_popap_centru(content, "error","180px","80px");
							}
						else{
							afiseaza_in_popap_centru(content, "info","180px","80px");
							}
						reloadlista();
					}
				});
				
			}
		}
	
	});	
	
	
	//deschidere adaugare window
	$(".btnadaugare").click(function(){ 
		popwin( "user.php",'User',700,500)
	});	
	
	
	//deschidere editare window
	$(".btneditare").click(function(){ 
		var id=$('#idselectat').val().split('|')[0];
		if (id.length==0) {
			alert("Nu ați selectat nici o înregistrare!");
		}
		else{
			popwin("user.php?id=" + id,'User',700,500)
		}
	
	});	
	
	
//GRILA TABEL select table tr on click
		
		$('#bloclista').on('click', 'table.style1 tbody tr', function(){
			$('table.style1 tbody tr').css({ 'background-color' : 'white'});
			$('table.style1 tbody tr:hover').css({ 'background-color' : '#DDDDDD'});
			
			var idselectat = $(this).attr('id').split('--')[1];
			$(this).css('background-color', '#acd5f8');
			//alert(idselectat);
			//$('#idselectat').val(idselectat);
			$('#idselectat').val(idselectat);//document.getElementById('#idselectat').value=idselectat; 
		}); 
		
		
	//inchiderecuselectare		
	$('#bloclista').on('click', '.inchidecuselectare', function(){
		var id_user = $(this).attr('id');
		//alert(id_user);	
		if(window.opener != null && !window.opener.closed)
		{
		    //alert(window.opener.name);
			window.opener.reload_user(id_user);
			window.close();
		}		  
	}); 	
			
		
	}); //end doc ready
	
	
	//incarcare lista
	function reloadlista(){
		
		$(document).ready(function(){
			$('#bloclista').html("<b>Se incarca, va rugam asteptati ...</b> ");
			$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url: "useriALL_ajx.php",
						data: "mod=lista",
						success: function(data) {
							var content = data;			//alert(content);
							$('#bloclista').html(content); 	//document.getElementById('blocrating').innerHTML =  content ;
						}
				});
		});
	}	
	


	
	
	</script>
</head>
<body>
	
	<!-- casute invizibile ptr varibile gen nrpag, tabwin1 si tabwin2 -->
	<input name='pag' type="hidden" id="pag" value="">
	<input name='tabwin1' type="hidden" id="tabwin1" value="">
	<input name='tabwin2' type="hidden" id="tabwin2" value="">
	<input name='formular' type="hidden" id="formular" value="">
	
	<!-- div continut fereastra (incarcate direct in partea de sus a ferestrei si prin ajax la lista) -->
	<div class="titlufereastra txtmov">Utilizatori</div>
	
		<!--<input name="inchidere" type="button" class="button grena btninchidere" id="inchidere" onClick="window.close();" value="(X) Inchide">-->
		
		
		<div class="butoane">
			
			<button name='btnrefresh' class="btnrefresh" id='btnrefresh'  ></button>
			<button name='btnadaugare' class="button  btnadaugare" id='btnadaugare'  >+ User nou</button>
			<button name='btneditare' class="button  btneditare" id='btneditare'  >Editare</button>
			<button name='btnstergere' class="button  btnstergere" id='btnstergere'  >Stergere</button>
			
		</div>
		<div class="cautare">
		
				
			
				<!--<button style="float:right;" id="filtreaza"> Filtrare </button>-->
		
		</div>
	<div id="bloclista" >
		
	
	</div>

