<?php
		include '../common.php';
		include '../notice.php';


		if(isset($_POST['password'], $_POST['username'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
			if ($username == "" OR $password == "") {
				$_SESSION['messageError'] = "Please enter username and password.";
				header("Location: login.php");
			}

			$password = crypt($password, "./PeRa1.2.");
			var_dump($password);

			$sql = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password' AND role_id = 1");
			$row = mysql_fetch_assoc($sql);

			if ($row) {
				session_start();
				$_SESSION['username'] = $username;
				header("Location: panel.php");
			} else {
				$_SESSION['messageError'] = "Wrong username and/or password.";
			}
		}

?>

<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="../css/styles.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/bootstrap-responsive.css">
	<link rel="stylesheet" href="../css/bootstrap-responsive.min.css">
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop</header>
	<div width="100%">ADMIN PAGE</div>
		<div id="elementOne">
			<div id="central">
				<form class="form-inline" method="post">
				  <input type="text" class="input-medium" name="username" placeholder="username">
				  <input type="password" name="password" class="input-medium" placeholder="Password">
				  <label class="checkbox">
				    <input type="checkbox"> Remember me
				  </label>
				  <button type="submit" name"submit" class="btn">Sign in</button>
				  <a class="btn-info" href="register.php">Register</a>
				</form>
			</div>
				<div class="side">BANNER</div>
			</div>
		<footer id="footer">(2013) All rights reserved</footer>
	</div>
	<script src="/..js/bootstrap.js"></script>
	<script src="/..js/bootstrap.min.js"></script>
	<script src="/..js/main.js"></script>
</body>
</html>
<?php mysql_close($conn); ?>