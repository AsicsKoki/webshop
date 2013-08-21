<?php
include '../common.php';
include '../notice.php';

$id     = $_GET['id'];
$sql    = "SELECT * FROM products where id= '$id'";
$retval = mysql_query( $sql, $conn );

	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}

$row   = mysql_fetch_assoc($retval);
$image = $row['image'];

	if ($image) {
		unlink('../files/' . $image);
		mysql_query("UPDATE products SET image = null WHERE id = '$id'",$conn);
		echo 1;
		return:
	}
	echo 0;
 ?>


 napraviti funkciju od ovog
 uvuci sve
 sredi data tables