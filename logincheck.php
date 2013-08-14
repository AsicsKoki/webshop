<?php
	// session_start();
	// if(!isset($_SESSION['username'])){
	// 	header('location: login.php');
	// }

	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	function userLogin($conn){
		session_start();
		if (!isset($_SESSION['username']))
			return false;

		$sql = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
		$retval = mysql_query($sql, $conn);
		$res = mysql_fetch_assoc($retval);
		return $res;
	}
?>