<?php
include 'common.php';
include 'notice.php';

	$id   = $_POST['id'];
	$text = $_POST['text'];
	$sql  = "INSERT INTO comments (product_id,user_id,comment) VALUES ('$id','$user','$text')";
	mysql_query( $sql, $conn );

?>