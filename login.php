<?php
		include 'phpcode.php';

		$sql = mysql_query("SELECT COUNT(*) AS total FROM users WHERE username='$username'");
		$row = mysql_fetch_object($sql);

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
				
			<form action="login.php" method="POST">
				<input type="text" name="username"/><br />
				<input type="password" name="password"/><br />
				<input type="submit" name"submit" value="Log In"/>
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