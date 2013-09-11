<?php
include 'common.php';
include 'notice.php';

	$user_id   = $_POST['userId'];
	$comment_id = $_POST['commentId'];
	$sql  = "INSERT INTO comment_likes (comment_id,user_id) VALUES ('$comment_id','$user_id')";
	return mysql_query( $sql, $conn );

?>