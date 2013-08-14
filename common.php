<?php

	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');

	function loginCheck($connectionParam){
		if (!isset($_SESSION['username'])) 
			return false;

		$sql    = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND role_id= 1";
		$retval = mysql_query($sql, $connectionParam);
		$role   = mysql_fetch_assoc($retval);

		return $role;
	}


 ?>