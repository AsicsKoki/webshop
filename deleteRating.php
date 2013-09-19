<?php
include 'common.php';
include 'notice.php';

	$userId   = $_POST['userId'];
	$productId = $_POST['productId'];
	$sql  = "DELETE FROM product_ratings WHERE user_id = '$userId' AND product_id = '$productId'";
	$res = mysql_query( $sql, $conn );
	var_dump($res);

?>