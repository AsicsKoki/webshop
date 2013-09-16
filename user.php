<?php

	include 'logincheck.php';
	include 'common.php';

	$id = $_GET['id'];

	if (!userLogin($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}

	//USER DATA


	$sql = "SELECT * FROM users where id= '$id'";

	$retval = mysql_query( $sql, $conn );
		if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}
	$data = mysql_fetch_assoc($retval);
	$first_name = $data['first_name'];
	$last_name = $data['last_name'];
	$username = $data['username'];
	$email = $data['email'];
	$about = $data['bio'];



	//IMAGE SELECTION
	$imgSql = "SELECT * FROM images WHERE entity_type = 'user' and entity_name = '$username'";
	$retvalImg = mysql_query( $imgSql, $conn );

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
	//LIKES
	$sqlLikes = "SELECT comment_id, username, comment FROM comment_likes LEFT JOIN comments ON comment_likes.comment_id = comments.id LEFT JOIN users ON comments.user_id = users.id WHERE comment_likes.user_id = $id";
	$retvalLikes = mysql_query($sqlLikes, $conn);


 ?>
<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/website.css" type="text/css" media="screen"/>
    <script src="js/jquery-1.10.2.min.js"></script>
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop
		</header>
		<div class="pull-right"><a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a></div>
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
					<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
						<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
						<li><a href="#likes" data-toggle="tab">Likes</a></li>
					</ul>
					<header><h4> <?php echo $username ?>'s profile </h4></header>
					<?php include 'notice.php';//error check and popup?>
					<div id="my-tab-content" class="tab-content">
						<div class="tab-pane active" id="profile">
							<div class="columnLeft">
								<ul class="plain">
									<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
									<li><img src="files/<?php echo $image['image_name'] ?>"></img></li>
									<?php } ?>
								</ul>
								<a class="buttons next" href="#">right</a>
								<input id="checkbox" type="checkbox">rotate banners
							</div>
							<div class="columnRight">
								<ul class="plain">
									<li><h4>First name:</h4> <?php echo $first_name; ?></li>
									<li><h4>Last name:</h4>  <?php echo $last_name ?> </li>
									<li><h4>Email:</h4>  <?php echo $email ?> </li>
									<li><h4>About me:</h4></li>
								</ul>
								<div><?php echo $about; ?></div>
							</div>
						</div>
						<div class="tab-pane" id="likes">
							<table id="like_table" class="table table-hover display">
								<thead>
									<th>Comment id</th>
									<th>Posted by</th>
									<th>Comment</th>
									<th>Delete like</th>
								</thead>
								<tbody>
									<?php
										while($info = mysql_fetch_assoc($retvalLikes)) {
									?>
									<tr>
										<th><?php echo $info["comment_id"]; ?></th>
										<th><?php echo $info["username"]; ?></th>
										<th><?php echo $info['comment']; ?></th>
										<th><a href="#" class="btn">Delete</a></th>
									</tr>
									<?php
										}
									 ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<div class="side"><img id="banner2" src=""></div>
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
    </div>
	<script src="js/bootstrap.min.js"></script>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
	<script src="js/main.js"></script>
</body>
</html>