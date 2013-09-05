<?php
	include '../common.php';
	include '../notice.php';

	$id  = $_GET['id'];
	$sql = "DELETE FROM comments WHERE id = $id";
	return mysql_query( $sql, $conn );
 ?>