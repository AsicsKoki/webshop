<?php
include 'common.php';
include 'notice.php';

	$username =	$_SESSION['username'];
	$sql  = "SELECT * FROM users where username = '$username'";
	$info = mysql_query($sql, $conn);
	$row  =	mysql_fetch_assoc($info);
	$user = $row['id'];

	$id   = $_POST['id'];
	$text = $_POST['text'];
	$sql  = "INSERT INTO comments (product_id,user_id,comment) VALUES ('$id','$user','$text')";
	mysql_query( $sql, $conn );
	var_dump($id);
	var_dump($text);

?>