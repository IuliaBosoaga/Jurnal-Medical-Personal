<?php
session_start();
unset($_SESSION['SESS_ID_USER']);
unset($_SESSION['SESS_USER']);
unset($_SESSION['SESS_NUMEPRENUME']);
unset($_SESSION['SESS_TIP']);


session_destroy ();

header("location: ../index.php");
?>
<script type="text/javascript">
alert("Ați ieșit din sesiunea de lucru. Pentru a continua să lucrați trebuie să vă autentificați din nou !");
window.location = " ../index.php";
</script>