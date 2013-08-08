<?php 
	
	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');
 ?>