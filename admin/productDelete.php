<?php 
	include '../common.php';
	include '../notice.php';
	$id = $_GET['id'];
	//var_dump($_GET["id"]);
	//exit;
	$sql = "DELETE FROM products WHERE id = '$id'";
	$retval = mysql_query( $sql, $conn );
	header("Location: products.php");


 ?>