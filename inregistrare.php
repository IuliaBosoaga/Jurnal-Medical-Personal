<?php
session_start();
error_reporting(0);
include('config.php'); 
?>
<script   src="https://code.jquery.com/jquery-3.4.0.min.js"   integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="   crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css" type="text/css"/>

<style>
input {width:240px;margin-bottom:10px; padding:4px;font-size:16px;border-radius:6px;border:1px solid #000; }label {width:110px;display:inline-block;}


</style>
<script type="text/javascript">



function validare(form)
{
	var errors = [];
	//alert("validez din js");
	
	var nume = form.nume.value;
	if (nume.length==0 ) {
		errors[errors.length] = "Nu ați completat numele!";			
		$("#nume").css('border-color', 'red');
	 }
	 else
	 {
		$("#nume").css('border-color', '#ccc'); 
	 }	
	 
	
	var prenume = form.prenume.value;
	if (prenume.length==0 ) {
		errors[errors.length] = "Nu ați completat prenumele!";			
		$("#prenume").css('border-color', 'red');
	 }
	 else
	 {
		$("#prenume").css('border-color', '#ccc'); 
	 }
				 
				 
	 var cnp = form.cnp.value;
				if (cnp.length==0 ) {
					errors[errors.length] = "Nu ați completat CNP-ul!";			
					$("#cnp").css('border-color', 'red');
				 }
				 else
				 {
					$("#cnp").css('border-color', '#ccc'); 
				 }
				 
				 			 
	
	
	
		var emailreg = form.emailreg.value;
	if (emailreg.length==0 ) {
		errors[errors.length] = "Nu ați completat e-mail-ul!";
		$("#emailreg").css('border-color', 'red');
	 }
	 else
	 {
		$("#emailreg").css('border-color', '#ccc'); 
	 }
	 
	 
	var filter=/^.+@.+\..{2,3}$/
		if (!filter.test(emailreg)) {
		errors[errors.length] = "E-mail invalid!";
		$("#emailreg").css('border-color', 'red');
	}
	 else
	 {
		$("#emailreg").css('border-color', '#ccc'); 
	 }
	
	
	if (emailreg.length>0 ) {
		$.ajax({
		type: "GET",
				async: false,   
				url: "useri/user_emailcheck.php",
				data: "email=" + emailreg, 
				success: function(data) 
				{
					if(data==1)		
					{	
							errors[errors.length] = "Această adresă de e-mail este deja înregistrată în baza de date!";									
					}		
				}
		});
	}
	

	
		 var mobil = form.mobil.value;
				if (mobil.length==0 ) {
					errors[errors.length] = "Nu ați completat numărul de telefon!";			
					$("#mobil").css('border-color', 'red');
				 }
				 else
				 {
					$("#mobil").css('border-color', '#ccc'); 
				 }
				 
	
	
	
	
	
		
		
		
				 
		 
				 
			
				 
				 var parola = form.parola.value;
				 var cparola = form.cparola.value;
				 
				if (parola.length==0 ) {
					errors[errors.length] = "Nu ați completat parola!";			
					$("#parola").css('border-color', 'red');
				 }
				 else
				 {	$("#parola").css('border-color', '#ccc'); 		 }
				 
				 
				 
				 if (cparola.length==0 ) {
					errors[errors.length] = "Nu ați completat confirmarea parolei!";			
					$("#cparola").css('border-color', 'red');
				 }
				 else
				 {		$("#cparola").css('border-color', '#ccc'); 			 }
				 
				 
				 
				 
				if (parola.length>0 && parola.length<6 ) 
				{ 
					errors[errors.length] = "Parola trebuie să aibă minim 6 caractere!";	
					$("#parola").css('border-color', 'red');
				}
				else
				 {	$("#parola").css('border-color', '#ccc');  }
				
				
				if(parola.indexOf(" ")>0)
				{ 
					errors[errors.length] = "Parola nu trebuie să conțină spații!";	
					$("#parola").css('border-color', 'red');
				}
				else
				 {		$("#parola").css('border-color', '#ccc'); 		 }
				
				
				
				
				var regexp = /^[a-zA-Z0-9@#$%^&]+$/;
				if (regexp.test(parola) == false)    { 
					errors[errors.length] = "Parola trebuie să conțină numai litere, cifre și caractere speciale."; 
					$("#parola").css('border-color', 'red');
				}
				else
				 {	$("#parola").css('border-color', '#ccc'); 			 }
				
				 
				 
				 if (parola!=cparola) { 			  
					errors[errors.length] = "Cele două parole nu se potrivesc!";
					$("#parola").css('border-color', 'red');					
					$("#cparola").css('border-color', 'red');
					}
					else
				 {
					$("#parola").css('border-color', '#ccc'); 
					$("#cparola").css('border-color', '#ccc'); 
				 }
											
					
		
		
		
		
	//alert(errors.length );	
	if (errors.length > 0) 
	{
			var msg = "<br> Atentie!:<br>";
			var numError;
			for (var i = 0; i<errors.length; i++) {
				numError = i + 1;
				msg += "<br>* " + errors[i];
			}
				document.getElementById('erori').innerHTML =  "<br>" +msg + "<br><br>";
			return false;
	}

	 return true;
} 



</script>




<body style="padding:10px 20px;">
<div class="container">
	<div class="header">
		
	</div>
	
	
	<div class="continut">
		<div style="float:left;display:block;width:100%;text-align:left">
				
					<h1>Înregistrează-te ca pacient</h1><br>		<br>

				
					<form id="regForm" name="regForm" method="post" action="inregistrare_exec.php" onsubmit="return validare(this);">
					
					<label >Username &nbsp*</label>
					<input name="username" id="username" type="text"  value=""/>
					 <br />
						 <span id="msgbox" style="display:none;"></span>
						 
						 
					<label >Parola &nbsp*</label>
					<input name="parola" id="parola" type="password" value="" />
					 <br />	 
						  
					<label >Confirmă parola &nbsp*</label>
					<input name="cparola" id="cparola" type="password"  value=""/>
					 <br />	
					 
					 <br>
					 
					 <label >Nume &nbsp*</label>
					<input name="nume" id="nume" type="text"  />
					 <br />	
					 
					 <label >Prenume &nbsp*</label>
					<input name="prenume" id="prenume" type="text"  />
					 <br />	
					 
					  <label >CNP &nbsp*</label>
					<input name="cnp" id="cnp" type="text"  />
					 <br />	
					 
					 <label >E-mail &nbsp*</label>
					<input name="emaileg" id="emailreg" type="text"  value=""/>
					 <br />
						 <span id="msgbox" style="display:none;"></span>
					 
					<label >Telefon &nbsp*</label>
					<input name="mobil" id="mobil" type="text"  />
					 <br />	
					 
					 <br>
			
					 
					<div id="erori" style="color:red;text-align:left;margin-left:10px;margin-top:20px;width:100%";>
					
					</div>
					
					<label ><span class="red"></span></label>
					<input align="center" class="buton_verde" type="submit" name="submitreg"  value="Înregistrează-te" />	
					
						
						
					</form>
					<br><br>
		</div>
				
		
	
   </div>
   
   <div class="footer">
		
   </div>
</div>
</body>
</html>
