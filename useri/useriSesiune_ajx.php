<?php
session_start();
if(isset($_GET['user_salvare-inchidere']) ){
	$_SESSION['user_salvare-inchidere']=$_GET['user_salvare-inchidere'];
}
if(isset($_GET['user_salvare-nou']) ){
	$_SESSION['user_salvare-nou']=$_GET['user_salvare-nou'];
}
?>