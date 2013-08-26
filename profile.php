<?php
	include 'logincheck.php';
	include 'common.php';

	if (!userLogin($conn)) {
		$_SESSION['messageError'] = "Please log in.";
		header("Location: login.php");
	}
	//PRODUCT DATA
	$id = $_GET["id"];

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


	//IMAGE SELECTION
	$imgSql = "SELECT * FROM images WHERE entity_type = 'user' and entity_id = '$id'";
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

 ?>
<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/website.css" type="text/css" media="screen"/>
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/jquery.tinycarousel.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#slider1').tinycarousel();
	});
</script>
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop
		</header>
		<div style="float: right;">
			<a href="profile"><button class="btn-info">Profile</button></a>
			<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a>
		</div>
		<div class="navbar">
			<div class="navbar-inner">
		    		<a class="brand" href="index.php">Home</a>
		    	<ul class="nav">
		    		<li><a href="#">Products</a></li>
		    		<li><a href="#">About us</a></li>
		    		<li><a href="#">Contact</a></li>
		    	</ul>
			</div>
		</div>
		<div id="elementOne">
			<div class="side"><img id="banner" src=""></div>
			<div id="central">
				<header><h4> <?php echo $name ?> </h4></header>
				<?php
				//ERROR/success CHECK AND POPUP
					include 'notice.php';
						 ?>
				<div class="columnLeft">
					<ul style="list-style: none;">
						<li><?php echo $description; ?></li>
						<li><button id="readMore">Read more</button></li>
						<li> Price:  <?php echo $price ?> </li>
						<li> quantity:  <?php echo $quantity ?> </li>
					</ul>
					<select>
						<?php while ($color= mysql_fetch_assoc($retvalColor)) {
						if ($row['colorid'] == $color["color_id"]) { ?>
							<option selected="selected"  value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						} else { ?>
							<option value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						}
					}
						?>
					</select>
					<footer>
						<form action="" method="post">
							<label for="quantity">quantity: </label>
							<input type="submit" value="purchase">
							<input name="quantity" style="float: left; width: 120px;" type="text" size="2" placeholder="Enter quantity here!">
						</form>
						<input id="checkbox" type="checkbox">rotate banners
					</footer>
				</div>
					<div id="more" class="hide">
						Lorem ipsum enim aliquip in et nulla deserunt esse anim ullamco officia proident id reprehenderit sint exercitation tempor amet in enim culpa.
					</div>
				<div class="columnRight">
					<div id="slider1">
						<a class="buttons prev" href="#">left</a>
						<div class="viewport">
							<ul class="overview">
								<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
								<li><img src="files/<?php echo $image['image_name'] ?>"></img></li>
									<?php } ?>
							</ul>
						</div>
					    <a class="buttons next" href="#">right</a>
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