<?php
	include '../common.php';


	// if (!loginCheck($conn)) {
	// 	return 0;
	// }

	$id = $_GET['id'];
	$active = $_GET['active'];
	$sql = "UPDATE products SET active = $active WHERE id= $id";
	$retval = mysql_query( $sql, $conn );
	return 1;

 ?>