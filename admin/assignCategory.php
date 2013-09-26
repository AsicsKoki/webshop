<?php
include 'common.php';
include 'notice.php';

	$productId   = $_POST['productId'];
	$categoryId = $_POST['categoryId'];
	$sql  = "INSERT INTO categorized_products (product_id, category_id) VALUES ('$productId','$categoryId')";
	return mysql_query( $sql, $conn );

?>