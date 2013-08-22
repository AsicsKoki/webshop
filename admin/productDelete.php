<?php 
	include '../common.php';
	include '../notice.php';
	$id = $_GET['id'];
	$sql = "DELETE FROM images WHERE id = '$id'";
	$retval = mysql_query( $sql, $conn );
	return 1;
 ?>