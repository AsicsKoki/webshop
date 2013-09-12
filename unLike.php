<?php
include 'common.php';
include 'notice.php';

	$userId   = $_POST['userId'];
	$comment_id = $_POST['commentId'];
	$sql  = "DELETE FROM comment_likes WHERE user_id = '$userId' AND comment_id = '$comment_id'";
	return mysql_query( $sql, $conn );

?>