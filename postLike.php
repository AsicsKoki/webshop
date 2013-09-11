<?php
include 'common.php';
include 'notice.php';

	$user_id   = $_POST['userId'];
	$comment_id = $_POST['commentId'];
	$sql  = "INSERT INTO comment_likes (user_id, comment_id) VALUES ('$user_id','$comment_id')";
	return mysql_query( $sql, $conn );

?>