<?php
session_start();
//ini_set('session.save_path', '/tmp');
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
error_reporting(0);
include('config.php');

?>

<body style="background:#5499C7/*#AED6F1*/;">
<div id="container">
   
	<?php
		if(strlen(	$_SESSION['SESS_IP_VERIF'])>0)
		{
			echo $_SESSION['SESS_IP_VERIF'];
			$_SESSION['SESS_IP_VERIF']=null;
		}
	
				
		?>
			
		<div align="center" style="position:relative;background:#fff;border: 0px solid #5674b9;  margin:50px auto; width: 60%; min-height:250px; border-radius:25px; text-align: center;font-familly:tahoma; size:24; ">
				<br>
				<img height="100px;" src="images/logo_medical_data.png">
				
				<br><h2>Jurnal Medical Personal</h2>
			   <br> 
			
				<form style="" name="login" method="post" action="login/login-exec.php">
			
				
					<b>Utilizator</b><br /><input style="font-size:26px;border:0px;border-bottom:1px solid #000;border-radius:14px;padding:15px;" name="user"  type="text" size="20" ><br /><br />
					<b>Parola</b><br /><input name="parola" style="font-size:26px;border:0px;border-bottom:1px solid #000;border-radius:14px;padding:15px;"  type="password" size="20" ><br /><br />
					
					<div align="center">
					<?php
									if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
										echo '<span style="color:red;">';
										foreach($_SESSION['ERRMSG_ARR'] as $msg) {
											echo '<br/>  ',$msg,''; 
										}
										echo '</span>';
										unset($_SESSION['ERRMSG_ARR']);
									}
					?>
					
					<?php
									if( isset($_SESSION['ERRMSG_ARR']) && !is_array($_SESSION['ERRMSG_ARR']) ) {
										echo '<span style="color:red;">';
										echo $_SESSION['ERRMSG_ARR'] ;
										echo '</span>';
										unset($_SESSION['ERRMSG_ARR']);
									}
					?>
				
				</div>
					
					<br><input style="font-size:22px;padding:10px;border-radius:14px;" type="submit" value="Autentificare" >
					<br><br>		
					<a href="inregistrare.php"> Înregistrare cont de pacient </a>
					<br>
				</form>
							
					<br>					
			
		 
		 </div>
		 
		 
		 <div>
		
		 
		 </div>
	
   </div>
</body>
</html>










