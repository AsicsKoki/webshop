<?php
error_reporting(E_ALL ^ E_NOTICE);

	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');
//LOGIN CHECK FUNCTION
function loginCheck($connectionParam){
	if (!isset($_SESSION['username']))
		return false;

	$sql    = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND role_id= 1";
	$retval = mysql_query($sql, $connectionParam);
	$role   = mysql_fetch_assoc($retval);
	return $role;
}
//FILE UPLOAD FUNCTION
function fileUpload($conn){
	if (file_exists("../files/" . $_FILES["image"]["name"])) {
		return false;
	} else {
		move_uploaded_file($_FILES["image"]["tmp_name"], "../files/" . $_FILES["image"]["name"]);
		return true;
		}
	}
//FILE DELETE FUNCTION
function fileDelete($conn){
	$id     = $_GET['id'];
	$sql    = "SELECT * FROM images where id= '$id'";
	$retval = mysql_query( $sql, $conn );

		if(! $retval ) {
			die('Could not get data: ' . mysql_error());
		}

	$row   = mysql_fetch_assoc($retval);
	$image = $row['image_name'];

		if ($image) {
			unlink('../files/' . $image);
			mysql_query("DELETE FROM images WHERE id = '$id'",$conn);
			echo 1;
			return;
		}
		echo 0;
	}
?>