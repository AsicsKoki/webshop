<?php
	include "common.php";
	session_start();
	unset($_SESSION['username']);

	$msg = 'You have logged out!';
	messageSuccess($msg);
	header('location: login.php');
 ?>