<?php
	include '../common.php';


	$id = $_GET['id'];
	$approved = $_GET['approved'];
	$sql = "UPDATE comments SET approved = $approved WHERE id= $id";
	$retval = mysql_query( $sql, $conn );
	return 1;

 ?>