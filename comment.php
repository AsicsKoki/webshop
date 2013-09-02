<?php
include 'common.php';
include 'notice.php';


	$user =	$_SESSION['username'];
	$sql  = "SELECT id AS user_id FROM users WHERE username = '$user'";
	$info = mysql_query($sql, $conn);
	$row  =	mysql_fetch_assoc($info);
	$user = $row['id'];

	$id   = $_POST['id'];
	$text = $_POST['text'];
	$sql  = "UPDATE comments SET product_id = $id, user_id = $user, comment = '$text'";
	$retval = mysql_query( $sql, $conn );
	return 1;


?>