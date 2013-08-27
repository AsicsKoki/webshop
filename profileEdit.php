<?php
	include 'common.php';
	include 'notice.php';


	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "Please log in!";
		header("Location: login.php");
	}

	$username = $_SESSION['username'];
	//GETS THE DATA FROM THE TABLE
	$sql = "SELECT * FROM users WHERE username = '$username'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);

	if(!empty($_POST)){
		$email          = $_POST['email'];
		$about          = $_POST['bio'];
		$image          = $_FILES['image']['name'];
		$oldPassword    = $_POST['oldPassword'];
		$oldPassword    = crypt($oldPassword, "./PeRa1.2.");

		if($row['password'] == $oldPassword){

			if(isset($_POST['newPassword'],$_POST['repeatPassword']) and $_POST['newPassword'] and $_POST['repeatPassword']){

				$newPassword    = $_POST['newPassword'];
				$repeatPassword = $_POST['repeatPassword'];

				if($newPassword == $repeatPassword){
					$newPassword = crypt($newPassword, "./PeRa1.2.");
					mysql_query("UPDATE users SET password = '$newPassword' WHERE username = '$username'", $conn);
				} else {
					$_SESSION['messageError'] = "Password does not match.";
				}
			}
		} else {
			$_SESSION['messageError'] = "Please enter old password";
		};


		mysql_query("UPDATE users SET email = '$email', bio = '$about' WHERE username = '$username'",$conn);
		$_SESSION['messageSuccess'] = "Saved!";

		if ($_FILES["image"]["name"]) {
			if (fileUpload($conn)) {
				mysql_query("INSERT INTO images (image_name, entity_id, entity_type, entity_name) VALUES ('$image', '$id', 'user', '$username')", $conn);
			}
		}
		header('Location: profileEdit.php');
	}



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
		<header id="header">Konstantin's web shop</header>
		<div style="float: right;">
			<a href="profile.php"><button class="btn-info">Profile</button></a>
			<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a>
		</div>
		<div class="navbar">
			<div class="navbar-inner">
		    		<a class="brand" href="index.php">Home</a>
		    	<ul class="nav">
		    		<li><a href="#">Products</a></li>
		    		<li><a href="#">About us</a></li>
		    		<li><a href="#">Contact</a></li>
		    		<li><a href="users.php">Users</a></li>
		    	</ul>
			</div>
		</div>
		<div id="elementOne">
			<div class="side"><img id="banner" src=""></div>
			<div id="central">
				<!-- SUBMISION FORM -->
				<form action="" method="post" data-validate="parsley" enctype="multipart/form-data">
					<ul ul style="list-style: none;">
						<li>email:<input type="text" name="email" value="<?php echo $row["email"] ;?>" data-required="true" data-type="email" ></li>
						<li>About me: <textarea name="bio" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["bio"] ;?></textarea></li>
						<li><input name="oldPassword" id="old" type="password" placeholder="enter old password"></li>
						<li><input name="newPassword" id="new" type="password" placeholder="enter new password"></li>
						<li><input name="repeatPassword" id="repeat" type="password" placeholder="enter new password"></li>
							<div class="uploadFile">
								<li><label for="file">Filename:</label></li>
							</div>
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
	</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/parsley.js"></script>
</body>
</html>