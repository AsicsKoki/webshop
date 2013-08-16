<?php

	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');

	function loginCheck($connectionParam){
		if (!isset($_SESSION['username']))
			return false;

		$sql    = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND role_id= 1";
		$retval = mysql_query($sql, $connectionParam);
		$role   = mysql_fetch_assoc($retval);
		return $role;
	}
  function fileUpload(){
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
    	echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    	echo "Type: " . $_FILES["file"]["type"] . "<br>";
    	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    	echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("../files/" . $_FILES["file"]["name"])) {
    	echo $_FILES["file"]["name"] . " already exists. ";
      } else {
      	move_uploaded_file($_FILES["file"]["tmp_name"], "../files/" . $_FILES["file"]["name"]);
      	echo "Stored in: " . "../files/" . $_FILES["file"]["name"];
      }
    }
}
 ?>