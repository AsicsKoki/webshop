<?php 
	include '../common.php';
	include '../notice.php';
	$comment = $_GET['id'];
	$sql = "DELETE FROM comments WHERE id = $id";
	$retval = mysql_query( $sql, $conn );
	return 1;
 ?>