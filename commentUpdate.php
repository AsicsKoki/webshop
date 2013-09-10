<?php
include 'common.php';
include 'notice.php';

	$id   = $_POST['id'];
	$text = $_POST['text'];
	$sql  = "UPDATE comments SET comment = '$text' WHERE id = $id";
	mysql_query( $sql, $conn );
	return 1;

?>