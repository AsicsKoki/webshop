<?php 
	include 'common.php';
	include 'notice.php';
		
		if(isset($_POST['password'], $_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['email'])){

			$username   = mysql_real_escape_string($_POST['username']);
			$password   = mysql_real_escape_string($_POST['password']);
			$first_name = mysql_real_escape_string($_POST['first_name']);
			$last_name  = mysql_real_escape_string($_POST['last_name']);
			$email      = mysql_real_escape_string($_POST['email']);

			if (!$username || !$password || !$first_name || !$last_name || !$email) {
				session_start();

				$_SESSION['messageError'] = "Please enter info.";
				header("Location: register.php");
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$_SESSION['messageError'] = "Invalid email";
				header("Location: register.php");
			}
			$password   = crypt($_POST['password'],"./PeRa1.2.");

			$sql = mysql_query("SELECT * FROM users WHERE username='$username' OR email='$email'");
			$row = mysql_fetch_assoc($sql);
			if(!$row){

			mysql_query ("INSERT INTO users (username, password, first_name, last_name, email) VALUES ('$username', '$password', '$first_name', '$last_name', '$email')");
			header("location: index.php");
			} else {
			$_SESSION['messageError'] = "Username or email already exists.";
			header("Location: register.php");
			}
	}
 ?>


<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop</header>
		<div id="elementOne">
			<div id="central">
				<form class="form-inline" method="post">
					<input type="text" name="first_name" class="input-medium" placeholder="First name?">
					<input type="text" name="last_name" class="input-medium" placeholder="Last name?">
					<input type="text" name="email" class="input-medium" placeholder="Email?">
				  	<input type="text" class="input-medium" name="username" placeholder="username">
				  	<input type="password" name="password" class="input-medium" placeholder="Password">
				  	<button type="submit" name"submit" class="btn">Register</button>
				</form>
			</div>
				<div class="side">BANNER</div>
			</div>
		<footer id="footer">(2013) All rights reserved</footer>
	</div>
	<script src="bootstrap.js"></script>
	<script src="bootstrap.min.js"></script>
	<script src="main.js"></script>
</body>
</html>
<?php mysql_close($conn); ?>