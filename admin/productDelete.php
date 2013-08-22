<?php 
	include '../common.php';
	include '../notice.php';
	$id = $_GET['id'];
	$sql = "DELETE FROM products WHERE id = '$id'";
	$retval = mysql_query( $sql, $conn );
	return 1;
 ?>