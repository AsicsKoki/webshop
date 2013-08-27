<?php
	include 'common.php';
	include 'notice.php';


	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "Please log in!";
		header("Location: login.php");
	}

	$username = $_SESSION['username'];
	if(!empty($_POST)){
		$email      = $_POST['email'];
		$about      = $_POST['bio'];
		$image      = $_FILES['image']['name'];


		mysql_query("UPDATE users SET email = '$email', bio = '$about' WHERE username = '$username'",$conn);
		$_SESSION['messageSuccess'] = "Saved!";

		if ($_FILES["image"]["name"]) {
			if (fileUpload($conn)) {
				mysql_query("INSERT INTO images (image_name, entity_id, entity_type, entity_name) VALUES ('$image', '$id', 'user', '$username')", $conn);
			}
		}
		header('Location: profileEdit.php');
	}

	//GETS THE DATA FROMT HE TABLE
	$sql = "SELECT * FROM users WHERE username = '$username'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);


	//IMAGE QUERY
	$imgQuery = "SELECT * FROM images WHERE entity_type = 'user' and entity_name = '$username'";

	$retvalImg = mysql_query( $imgQuery, $conn );
	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}



 ?>
<!doctype HTML>
<html>
<head>
	<link rel ="stylesheet" href="css/styles.css">
	<link rel ="stylesheet" href="css/bootstrap.css">
	<link rel ="stylesheet" href="css/bootstrap.min.css">
	<link rel ="stylesheet" href="css/bootstrap-responsive.css">
	<link rel ="stylesheet" href="css/bootstrap-responsive.min.css">
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop
	<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a></header>
			<div id="elementOne">
			</div>
			<div id="central">
				<!-- SUBMISION FORM -->
				<form action="" method="post" data-validate="parsley" enctype="multipart/form-data">
					<ul ul style="list-style: none;">
						<li>email:<input type="text" name="email" value="<?php echo $row["email"] ;?>" data-required="true" data-type="email" ></li>
						<li>About me: <textarea name="bio" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["bio"] ;?></textarea></li>
							<div class="uploadFile"><li><label for="file">Filename:</label></li></div>
						<li><input type="file" name="image"><br></li>
						<li><input type="submit" name"submit" class="btn" value="Save"></li>
					</ul>
				</form>
				<ul style="list-style: none;">
					<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
					<li><img src="files/<?php echo $image['image_name'] ?>"></img>
					<div><a class="deleteUserPhoto" href="#" data-username='<?php echo $username;?>'>Delete image</a></div></li>
					<?php } ?>
				</ul>
			</div>
</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/parsley.js"></script>
</body>
</html>