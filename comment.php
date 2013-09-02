<?php
include 'common.php';
include 'notice.php';

if (!loginCheck($conn)) {
	$msg = "Please log in!";
	messageError($msg);
	header("Location: login.php");
}
	$user =	$_SESSION['username'];
	$id = $_POST['id'];
	$sql = "UPDATE comments SET entity_id = $id, user = $user, text = $text";
	$retval = mysql_query( $sql, $conn );
	return 1;


?>