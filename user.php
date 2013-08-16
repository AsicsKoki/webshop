<?php
	include 'common.php';
	include 'notice.php';

	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "You don't have permissions to view this page.";
		header("Location: login.php");
	}
	$id = $_GET['id'];
//SELECTS DATA FROM THE USERS TABLE
	$sql = "SELECT * FROM users WHERE id = '$id'";

	mysql_select_db('webshop');
		$retval = mysql_query( $sql, $conn );
	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}

	$info = mysql_fetch_assoc($retval);
//BANNERS

	$banners = 'SELECT banner FROM banners';

	$banners = mysql_query($banners, $conn);
	if(! $banners) {
		die('Could not get data: ' . mysql_error());
	}

	$bannerNames = [];
	while ($bannerName= mysql_fetch_assoc($banners)) {
		$bannerNames[] = 'images/'.$bannerName["banner"];
	}
	shuffle($bannerNames);
	$banners  = array_slice($bannerNames, 0,3);
	$banners2 = array_slice($bannerNames, 3,6);


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
		<header id="header">Konstantin's web shop
			<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a>
		</header>
		<div class="navbar">
			<div class="navbar-inner">
				<a class="brand" href="#">Home</a>
					<ul class="nav">
					    <li><a href="index.php">Products</a></li>
					    <li><a href="users.php">Users</a></li>
					    <li><a href="#">Contact</a></li>
					</ul>
			</div>
		</div>
		<div id="elementOne">
			<div class="side"><img id="banner" src=""></div>
			<div id="central">
				<div style="width: 200px;">
				<dl class="dl-horizontal">
		  			<dt>First name</dt>
		  			<dd><?php echo $info['first_name'];?></dd>
		  			<dt>Last name</dt>
		  			<dd><?php echo $info['last_name'];?></dd>
				</dl>
				</div>
				<div style="width: 300px; padding-left: 259px;">
					<dl>
						<dt>Bio</dt>
						<dd>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, commodi, iure, ipsum inventore dolores reiciendis voluptates nobis porro ex fugit doloremque quae quasi quod voluptatum officiis placeat minima magni minus!</dd>
					</dl>
				</div>
			</div>
			<div class="side"><img id="banner2" src=""></div>
			<input id="checkbox" type="checkbox">rotate banners
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
	</div>
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
</body>
</html>
<?php mysql_close($conn); ?>