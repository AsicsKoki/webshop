<?php
include '../common.php';
include '../notice.php';

if (!loginCheck($conn)) {
	$_SESSION['messageError'] = "Please log in!";
	header("Location: login.php");
}
echo fileDelete($conn);

?>