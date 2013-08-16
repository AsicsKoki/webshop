<?php
		include '../common.php';
		include '../notice.php';
	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "Please log in!";
		header("Location: login.php");
	}

 ?>

 <!doctype HTML>
 <html>
<head>
	<link rel ="stylesheet" href="../css/styles.css">
	<link rel ="stylesheet" href="../css/bootstrap.css">
	<link rel ="stylesheet" href="../css/bootstrap.min.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.min.css">
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop
	<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a></header>
		<div id="elementOne">
			<?php
			 include 'sidebar.php';
			  ?>
			  </div>
			<div id="central">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
	<footer id="footer">(2013) All rights reserved</footer>
</div>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>