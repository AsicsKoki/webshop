<?php
include 'common.php';
include 'notice.php';

if (!loginCheck($conn)) {
	$msg = "Please log in!";
	messageError($msg);
	header("Location: login.php");
}
echo imageDelete($conn);

?>