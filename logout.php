<?php
	session_start();
	unset($_SESSION['username']);

	$_SESSION['messageSuccess'] = 'You have logged out!';
	header('location: login.php');
 ?>