<?php 
	include '../common.php';
	include '../notice.php';
	$id = $_GET['id'];
	$sql = "DELETE FROM users WHERE id = '$id'";
	$retval = mysql_query( $sql, $conn );
	header("Location: users.php");

 ?>