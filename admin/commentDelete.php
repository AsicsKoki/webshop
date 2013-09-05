<?php
	include '../common.php';
	include '../notice.php';

	$id  = $_GET['id'];
	echo $id;;
	$sql = "DELETE FROM comments WHERE id = $id";
	mysql_query( $sql, $conn );
	return 1;
 ?>