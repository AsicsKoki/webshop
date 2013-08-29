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
//FILE UPLOAD FUNCTION BACK END
 function fileUpload(){
	if ($_FILES["file"]["error"] > 0) {
		return false;
	}

	$infix = "";
	while(file_exists("../files/" . $_FILES["image"]["name"] . $infix)){
		if($infix == ""){
			$infix = 1;
	} else {
		$infix++;
		}
	}
	$name = $_FILES['image']['name'];
	$name2 = explode( ".", $name);
	$split = array_pop($name2);
	array_push($name2, $infix);
	array_push($name2, $split);
	$str = implode(".", $name2);

	move_uploaded_file($_FILES["image"]["tmp_name"], "../files/" . $str);
	return $str;
	}
//FILE UPLOAD FUNCTION FRONT END
function imageUpload($conn){
	if (file_exists("files/" . $_FILES["image"]["name"])) {
		return false;
	} else {
		move_uploaded_file($_FILES["image"]["tmp_name"], "files/" . $_FILES["image"]["name"]);
		return true;
		}
	}
//FILE DELETE BACK END
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

//FILE DELETE FRONT END
	function imageDelete($conn){
	$username = $_SESSION['username'];
	$sql      = "SELECT * FROM images where entity_name= '$username'";
	$retval   = mysql_query( $sql, $conn );

		if(! $retval ) {
			die('Could not get data: ' . mysql_error());
		}

	$row   = mysql_fetch_assoc($retval);
	$image = $row['image_name'];

		if ($image) {
			unlink('files/' . $image);
			mysql_query("DELETE FROM images WHERE entity_name = '$username'",$conn);
			echo 1;
			return;
		}
		echo 0;
	}
//MESSAGE ERROR/SUCCESS
	function messageError($msg){
		$_SESSION['messageError'] = $msg;
	}
	function messageSuccess($msg){
		$_SESSION['messageSuccess'] = $msg;
	}
?>