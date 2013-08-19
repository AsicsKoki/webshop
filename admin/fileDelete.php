<?php
include '../common.php';
include '../notice.php';

	$id = $_GET['id'];
$sql = "SELECT * FROM products where id= '$id'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);


	 $image = $row['image'];
	if ($row['image']) {
		unlink('files/' . $image);
		header('Location: productEdit.php');

	}
 ?>