<?php
include 'common.php';
include 'notice.php';

	$rating    = $_POST['rating'];
	$userid    = $_POST['userid'];
	$productid = $_POST['productid'];

	$ratingQuery      = "SELECT * FROM product_ratings WHERE product_id = $productid";
	$retvalRating     = mysql_query($ratingQuery, $conn);
	$ratingInfo       = mysql_fetch_assoc($retvalRating);
	$user_id_check    = $ratingInfo['user_id'];
	$product_id_check = $ratingInfo['product_id'];

	if($userid == $user_id_check AND $productid == $product_id_check){
		return false;
	} else {
		$sql  = "INSERT INTO product_ratings (product_id, user_id, rating) VALUES ('$productid','$userid', $rating)";
		$val = mysql_query( $sql, $conn );
		var_dump($val);
	}
 ?>