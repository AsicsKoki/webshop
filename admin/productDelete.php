<?php 
	include '../common.php';
	include '../notice.php';

	$id =$_REQUEST['id'];

	$sql = 'DELETE FROM products WHERE id = "$id"';
	$retval = mysql_query( $sql, $conn );
	header("Location: products.php");
 ?>