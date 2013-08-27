<?php

		include 'common.php';
		include 'notice.php';


	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "You don't have permissions to view this page.";
		header("Location: login.php");
	}

//SELECTS DATA FROM THE USERS TABLE
	$full = "SELECT * FROM users";

	mysql_select_db('webshop');
		$retval2 = mysql_query( $full, $conn );
	if(! $retval2 ) {
		die('Could not get data: ' . mysql_error());
	}
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
	<link rel="stylesheet" href="css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/jquery.dataTables_themeroller.css">
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
					    		<li><a href="users.php">Users</a></li>
					    	</ul>
						</div>
					</div>
		<div id="elementOne">
			<div class="side"><img id="banner" src=""></div>
				<div id="central">
				<table id="usersTable" class="table table-hover" class="display">
					<thead>
						<th>First name</th>
						<th>Last name</th>
						<th>username</th>
						<th>email</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							while($row = mysql_fetch_assoc($retval2)) {
						 ?>
						<tr>
							<td class="column1"><?php echo $row["first_name"]; ?></a></td>
							<td class="column2"><?php echo $row["last_name"]; ?></td>
							<td class="column3"><?php echo $row["username"]; ?></td>
							<td class="column4"><?php echo $row["email"]; ?></a></td>
							<td class="column4"><a class="btn btn-info" href="user.php?id=<?php echo $row["id"]; ?>"><i class="icon-info-sign"></i>Profile</a></td>
						</tr>
						<?php
							}
						 ?>
					</tbody>
				</table>
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
	<script src="js/jquery.dataTables.min.js"></script>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
</body>
</html>
<?php mysql_close($conn); ?>