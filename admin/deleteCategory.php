<?php
include 'common.php';
include 'notice.php';

	$categoryId   = $_POST['categoryId'];
	$sql  = "DELETE FROM categories WHERE id = '$categoryId'";
	$res = mysql_query( $sql, $conn );
	var_dump($res);

?>