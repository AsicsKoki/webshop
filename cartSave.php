<?php 
	include 'common.php';
	include 'notice.php';
	include 'logincheck.php';

	if (!userLogin($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}
	$quantity = $_POST['quantity'];
	$id = $_POST['id'];

	//PURCHASE AND ADDING TO CART
	if(!empty($_POST)) {
		echo addToCart($id,$quantity);
 	}
 	return 1;
 ?>