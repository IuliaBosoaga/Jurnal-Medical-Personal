<?php include('../head.php'); ?>
<?php require_once('../config.php');  ?>

<head>
	
<script type="text/javascript" >

	$(document).ready(function(){
		alert (url);
	
	
		
	});//end doc ready



function inchideinapoi(){	
		  if(window.opener != null && !window.opener.closed)
			{
				window.opener.reloadlista();
				window.close();
			}		  
		
	}

	
	
	
	
	function validare(form)
	{
				//alert('verific');
				var errors = [];
				
				var nume = form.nume.value;
				if (nume.length==0 ) {
					errors[errors.length] = "Nu ați completat numele!";			
					$("#nume").css('border-color', 'red');
				 }
				 
				 
				 var prenume = form.prenume.value;
				if (prenume.length==0 ) {
					errors[errors.length] = "Nu ați completat prenumele!";			
					$("#prenume").css('border-color', 'red');
				 }
				
				var username = form.username.value;
				if (username.length==0 ) {
					errors[errors.length] = "Nu ați completat username-ul!";			
					$("#username").css('border-color', 'red');
				 }
				//verific username existent
				<?php if(isset($_GET['id'])) {$iduser=$_GET['id'];} else{$iduser=0;}?>
				$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url: url + "/admin/user-usernamecheck_ajx.php",
						data: "username=" + username+"&id_user=<?php echo $iduser;?>", 
						success: function(data) {
						if(data==1)		{	errors[errors.length] = "Numele de utilizator este deja înregistrat!";			}		
						}
				});
				
				var email = form.email.value;
				if (email.length==0 ) {
					errors[errors.length] = "Nu ați completat email-ul!";			
					$("#email").css('border-color', 'red');
				 }
				var filter=/^.+@.+\..{2,3}$/
				if (!filter.test(email)) {
					errors[errors.length] = "E-mail invalid!";
				}
					//verific email existent
				$.ajax({
				type: "GET",
						async: false,   // forces synchronous call
						url: url + "/admin/user-emailcheck_ajx.php",
						data: "email=" + email+"&id_user=<?php echo $iduser;?>", 
						success: function(data) {
						if(data==1)		{	errors[errors.length] = "Această adresă de e-mail este deja înregistrată în baza de date!";						}		
						}
				});
				
				var parola = form.parola.value;
				if (parola.length==0 ) {
					errors[errors.length] = "Nu ați completat parola!";			
					$("#parola").css('border-color', 'red');
				 }
				if (parola.length>0 && parola.length<6 ) { 			  errors[errors.length] = "Parola trebuie să aibă minim 6 caractere!";		 }
				if(parola.indexOf(" ")>0)
				{ errors[errors.length] = "Parola nu trebuie să conțină spații!";	}
				var regexp = /^[a-zA-Z0-9@#$%^&]+$/;
				if (regexp.test(parola) == false)    { errors[errors.length] = "Parola trebuie să conțină numai litere, cifre și caractere speciale."; }
				
				
				
		if (errors.length > 0) {
				var msg = "<br> Eroare validare:<br>";
				var numError;
				for (var i = 0; i<errors.length; i++) {
					numError = i + 1;
					msg += "<br>* " + errors[i];
				}
						afiseaza_in_popap_centru(msg, "error","400px","210px");
						//$("#popap_centru_text").html(data);
						$("#popap_centru").css('top',  "8%");
						$("#popap_centru").css('left', "8%");
						$("#popap_centru").css('position', 'fixed');	
						$("#popap_centru").css('width', '84%');
						$("#popap_centru").css('height', '84%');
						$("#popap_centru").css('background-color',  "#fff");
						$('.black_overlay').show();
						$('#popap_centru').fadeIn(300) ; 
				//document.getElementById('eroare').innerHTML =  "<br>" +msg + "<br><br>";
				return false;
			 }

			 return true;
		} //end validare
		
		
		
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

</script> 	
</head>
<body>

	
	<?php 
	if(!isset($_GET['id'])){?>	
		<div class="titlufereastra_add">[Adaugare Utilizator]</div>
		<?php }
	else{	?>	
		<div class="titlufereastra_addedit">[Editare Utilizator]</div>
		<?php
	}
	?>
	
	<div class="butoane" style="text-align:left;">
		
		<button name="btninchidere" type="button" class="button btninchidere" id="btninchidere" onclick="javascript:inchideinapoi();" >Închide</button>

	</div>
	
	
	<div id="continut" >
	
		<div id="continut_dr" style="height:355px;width:96%">
			<form name="form2" id="form2" method="post" action="<?php if(!isset($_GET['id'])) {echo "userExec.php" ;} else {echo "userExec.php" . "?id=". $_GET['id'];}?>" onsubmit="return validare(this);">
			
				<?php include("userGeneral_inc.php");?>
			
			
		
			
			</form> 		
			
		
		</div><!-- end dreapta  -->
	</div><!-- end div continut  -->	
	
	<div id="statusbar" style="">
		
		
	</div>
</body>	

