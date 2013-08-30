<?php
	include 'common.php';
	include 'notice.php';
	include 'logincheck.php';

	if (!userLogin($conn)) {
		$msg = "Please log in.";
		messageError($msg);
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
		$email          = mysql_real_escape_string($_POST['email']);
		$about          = mysql_real_escape_string($_POST['bio']);
		$image          = $_FILES['image']['name'];
		$oldPassword    = mysql_real_escape_string($_POST['oldPassword']);
		$oldPassword    = mysql_real_escape_string(crypt($oldPassword, "./PeRa1.2."));

		if($row['password'] == $oldPassword){

			if(isset($_POST['newPassword'],$_POST['repeatPassword']) and $_POST['newPassword'] and $_POST['repeatPassword']){

				$newPassword    = mysql_real_escape_string($_POST['newPassword']);
				$repeatPassword = mysql_real_escape_string($_POST['repeatPassword']);

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

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$_SESSION['messageError'] = "Invalid email";
				header("Location: register.php");
			}
		mysql_query("UPDATE users SET email = '$email', bio = '$about' WHERE username = '$username'",$conn);
		$_SESSION['messageSuccess'] = "Saved!";

		if ($_FILES["image"]["name"]) {
			if (imageUpload($conn)) {
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
		<form class="form-horizontal pull-left" method="post" data-validate="parsley" enctype="multipart/form-data">
	        <div class="control-group">
	            <label class="control-label" for="email">Email:</label>
	                <div class="controls">
						<input input type="text" name="email" value="<?php echo $row["email"] ;?>" data-required="true" data-type="email">
	                </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" for="bio">About me:</label>
	                <div class="controls">
	                    <textarea name="bio" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["bio"] ;?></textarea>
	                </div>
	        </div>
	         <div class="control-group">
	            <label class="control-label" for="oldPassword">Old password:</label>
	                <div class="controls">
	                    <input name="oldPassword" id="old" type="password" placeholder="enter old password"></input>
	                </div>
	        </div>
	         <div class="control-group">
	            <label class="control-label" for="newPassword">New password:</label>
	                <div class="controls">
	                    <input name="newPassword" id="new" type="password" placeholder="enter new password"></input>
	                </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" for="newPassword">New password:</label>
	                <div class="controls">
	                    <input name="repeatPassword" id="repeat" type="password" placeholder="enter new password"></input>
	                </div>
	        </div>
	        <div class="control-group">
	            <label style="float:left; padding-left: 100px;" class="control-lable" for="file">Filename:</label>
	                <div class="controls">
	                    <input style="padding-left: 50px;:" type="file" name="image">
	                </div>
	        </div>
	        <input type="submit" name"submit" class="btn" value="Save">
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
	<script type="text/javascript">
		//AJAX DELETE FRONT END
		$('.deleteUserPhoto').click(function(e){
			e.preventDefault();
			var username = $(this).data('username');
			var self = this;
			$.ajax({
				url: "imageDelete.php",
				type: "get",
				data: {
					username: username
				},
				success: function(data){
					if (data){
						$(self).parents("li").remove();
					}
				}
			});
		});
	</script>
</body>
</html>