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
function addInfix($name, $infix){
		if (!$infix) return $name;
		$name2 = explode( ".", $name);
		$last = array_pop($name2);
		$penultimate = array_pop($name2);
		array_push($name2, $penultimate."_".$infix);
		array_push($name2, $last);
		$str = implode(".", $name2);
		return $str;
}
//FILE UPLOAD FUNCTION BACK END
 function fileUpload(){
	if ($_FILES["file"]["error"] > 0) {
		return false;
	}

	$infix = "";
	while(file_exists("../files/" . addInfix($_FILES["image"]["name"], $infix) )){
		if($infix == ""){
			$infix = 1;
		} else {
			$infix = $infix + 1;
		}
	}
	$str = addInfix($_FILES["image"]["name"], $infix);

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
//SELECTS USER PHOTO FOR PROFILE PAGE
function getUserPhoto($user_id){
	$sql      = "SELECT * FROM images where entity_type = 'user' AND entity_id= '$user_id'";
	global $conn;
	$retval   = mysql_query( $sql, $conn );
	$res = mysql_fetch_assoc($retval);
	if($res){
		return $res['image_name'];
	} else {
		return "default.jpg";
	}
}
//DELETES COMMENTS BACKEND
function commentDelete($conn){
	$id  = $_GET['id'];
	$sql = "DELETE FROM comments WHERE id = $id";
	mysql_query( $sql, $conn );
	return 1;
	}

function hasLikes($comment_id, $user_id = null){
	global $conn;

	if ($comment_id and $user_id) {
		$like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
	} else {
		$like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$commentId'";
	}
	$retval = mysql_query($like_query, $conn);
	return mysql_result($retval, 0, 0);
}

/*	function hasLiked($comment_id, $user_id = null, $conn){
		// $like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$commentId'";
	$like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
	$retval = mysql_query($like_query, $conn);
	return mysql_result($retval, 0, 0);
	}
function numberOfLikes($comment_id, $user_id = null, $conn){
	$like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$commentId'";
	$retval = mysql_query($like_query, $conn);
	return mysql_result($retval, 0, 0);
}*/
?>