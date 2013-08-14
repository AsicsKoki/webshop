<?php

	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');

	function loginCheck($conn){
		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role_id as roleid"
		if ($roleid != 1) {
			header("Location: login.php")
		}
	}
 ?>