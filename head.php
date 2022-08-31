<?php 
include("auth.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED );
header('Content-Type: text/html; charset=utf-8');
 

?>

<?php 
$cale=$_SERVER['DOCUMENT_ROOT'] . "/JurnalMedicalPersonal"; 
//pentru apeluri de fisiere php din fisiere php

require_once($cale . '/config.php'); 
?>


<html>
<head>
	
<meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
	
	<link rel="stylesheet" href="<?php echo URL;?>/style.css" type="text/css"/>
	<script   src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="   crossorigin="anonymous"></script>
  	
	<script type="text/javascript" src="<?php echo URL;?>/js/main.js"></script>
	


	
	<script type="text/javascript">
	
	$(document).ready(function(){
		
		 //mesaj de deschidere
			
			 $(".inchidere").click(function(){ 
				$('#popap_centru').fadeOut("slow");
				$('.black_overlay').hide();
			});
			
			$(".black_overlay").click(function(e) {
				e.stopPropagation();
			});
	
		
		
		
		
		
		
	}); // end document ready jq	 
	</script>	
	
	
<?php

	
?>
	
 
	

				
</head>


	


<div id="fade" class="black_overlay"></div>
	<div id="popap_centru"> 
		<a href = "javascript:void(0)" class="inchidere" style="position:absolute;left:94%;top:0px;"></a>
		<div id="popap_centru_text" style="margin-left:1%;width:98%"></div> 
	</div>
	<div id="popap_centru2"> 
		<a href = "javascript:void(0)" class="inchidere2" style="position:absolute;left:94%;top:0px;z-index:113"></a>
		<div id="popap_centru_text2" style="margin-left:1%;width:98%"> </div>
	</div>


	
