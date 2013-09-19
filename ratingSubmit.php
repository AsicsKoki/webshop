<?php
include 'common.php';
include 'notice.php';

	$rating    = $_POST['rating'];
	$user_id    = $_POST['userid'];
	$product_id = $_POST['productid'];

	$ratingQuery      = "SELECT * FROM product_ratings WHERE product_id = $product_id";
	$retvalRating     = mysql_query($ratingQuery, $conn);
	$ratingInfo       = mysql_fetch_assoc($retvalRating);
	$user_id_check    = $ratingInfo['user_id'];
	$product_id_check = $ratingInfo['product_id'];

	if($user_id == $user_id_check AND $product_id == $product_id_check){
		return false;
	} else {
		$sql  = "INSERT INTO product_ratings (product_id, user_id, rating) VALUES ('$product_id','$user_id', $rating)";
		$val = mysql_query( $sql, $conn );
		var_dump($val);
	}
 ?>