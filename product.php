<?php
	include 'logincheck.php';
	include 'common.php';

	if (!userLogin($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}
	//PRODUCT DATA
	$id = $_GET["id"];

	$sql = "SELECT * FROM products where id= '$id'";
	$retval2 = mysql_query( $sql, $conn );
		if(! $retval2 )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval2);

	if(!$row){
		$msg = "Product not found";
		messageError($msg);
		header("Location: index.php");
	}


	$description = $row['description'];
	$name = $row['name'];
	$price = $row['price'];
	$quantity = $row['quantity'];
	$active = $row['active'];
	if ($active == 0){
		header("Location: index.php");
	}

	// COLOR SELECTION
	$boje= "SELECT * FROM colors";

	$retvalColor = mysql_query( $boje, $conn );
	if(! $retvalColor ) {
	  die('Could not get data: ' . mysql_error());
	}

	//IMAGE SELECTION
	$imgSql = "SELECT * FROM images WHERE entity_type = 'product' and entity_id = '$id'";
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

	//QUANTITY SUBMIT
	if (isset($_POST['quantity'])){
		$amount = 'SELECT quantity FROM products WHERE id = ' . $id;
		$current = mysql_query( $amount, $conn);
		if(! $current )
		{
			 die('Could not get data: ' . mysql_error());
		}

		while ($val= mysql_fetch_assoc($current))
			$value = $val['quantity'];

		if ($value >= $_POST['quantity']){
			$quantity = $_POST['quantity'];
			mysql_query("UPDATE products SET quantity= quantity - '$quantity' WHERE id = '$id'",$conn);
			$success = "Purchase successfull";
		} else {
			$error = "Amount is too high";
		}
	}

	//COMMENT SECTION
	$query = "SELECT * FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE product_id = $id";
	$retvalCom = mysql_query( $query, $conn );
		if(! $retvalCom )
	{
		die('Could not get data: ' . mysql_error());
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
			<?php
			include "partials/loginLogout.php";
			include "partials/navbar.php";
			 ?>
		<div id="elementOne">
			<div class="side"><img id="banner" src=""></div>
			<div id="central">
				<header><h4> <?php echo $name ?> </h4></header>
				<?php
				//ERROR/success CHECK AND POPUP
					include 'notice.php';
						 ?>
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
						<form action="" method="post" data-validate="parsley">
							<label for="quantity">quantity: </label>
							<input type="submit" value="purchase">
							<input name="quantity" data-range="[1, 9999999]" style="float: left; width: 120px;" type="text" size="2" placeholder="Enter quantity here!">
						</form>
						<input id="checkbox" type="checkbox">rotate banners
					<div id="more" class="hide">
						Lorem ipsum enim aliquip in et nulla deserunt esse anim ullamco officia proident id reprehenderit sint exercitation tempor amet in enim culpa.
					</div>
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
						<textarea id="comment" name="comment" cols="100" rows="10"></textarea>
						<input data-id='<?php echo $row["id"];?>' id="post_comment" type="submit" name"submit" class="btn" value="Comment">
							<div>
								<?php while($data = mysql_fetch_assoc($retvalCom)){ ?>
								<ul style="list-style: none;">
									<li><h4>First name:</h4> <?php echo $data['first_name']; ?></li>
									<li><h4>Last name:</h4>  <?php echo $data['last_name'] ?> </li>
									<li><h4>Posted at:</h4>  <?php echo $data['posted_at'] ?> </li>
									<li><h4>Comment: <?php echo $data['comment']; ?> </h4></li>
								</ul>
								<?php } ?>
							</div>
			</div>
		<div class="side"><img id="banner2" src=""></div>
		<footer id="footer">(2013) All rights reserved</footer>
		</div>
    </div>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/parsley.js"></script>
</body>
</html>