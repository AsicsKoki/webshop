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
	$query = "SELECT *, users.id as user_id FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE product_id = $id";
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
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/flexslider.css">
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/parsley.js"></script>
	<script type="text/template" id="comment_box_temp">
		<div class="comment">
			<header><?php echo $_SESSION['username']; ?> Just now... </header>
		{{text}}
		</div>
	</script>
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop</header>
		<?php
			include "partials/loginLogout.php";
			include "partials/navbar.php";
		?>
		<div id="elementOne">
			<div class="row">
				<!-- IMAGE SLIDER AND COMMENTS -->
				<div class="span4">
					<div class="flexslider">
						<ul class="slides">
							<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
							<li><img src="files/<?php echo $image['image_name'] ?>"/></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<!-- PAGE CONTENT -->
				<div class="span6">
					<h3> <?php echo $name ?> </h3>
					<div>
						<dl class="dl-horizontal">
							<dt>Description:</dt>
							<dd class='text-left'> <?php echo $description ?><button id="readMore">Read more</button> </dd>
							<div id="more" class="hide">
								Lorem ipsum enim aliquip in et nulla deserunt esse anim ullamco officia proident id reprehenderit sint exercitation tempor amet in enim culpa.
							</div>
							<dt>Price:</dt>
							<dd class='text-left'> <?php echo $price ?> </dd>
							<dt>In stock:</dt>
							<dd class='text-left'> <?php echo $quantity ?> </dd>
						</dl>
					</div>
					<form data-validate="parsley" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="control-group">
	           			<label class="control-label" for="name">Quantity: </label>
	               			<div class="controls">
								<input class="pull-left" name="quantity" data-range="[1, 9999999]" type="text" size="2" placeholder="Enter quantity here!">
							</div>
	        			</div>
	        			<div class="control-group">
	            		<label class="control-label">Select color:</label>
	               		<div class="controls">
						<select class="pull-left">
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
	                	</div>
				 		</div>
	      				<input type="submit" value="purchase">
					</form>
				</div>
			</div>
			<div id="comment_content">
				<div class="comment_thumbnail"><img class="image_thumb" src="<?php echo 'files/'.getUserPhoto($user_id)?>"></div>
				<?php while($data = mysql_fetch_assoc($retvalCom)){ ?>
				<div class="well" style="padding-left: 75px;">
					<header class="com_header">
						<a href="user.php?id=<?php echo $data['user_id'] ?>"><?php echo "<b>".$data['username']."</b>";?></a>
						<?php
						echo "  Posted at:  ";
						echo "<i>".$data['posted_at']."</i>";
					 ?></header>
				<p><?php echo $data['comment']; ?> </p>
				</div>
				<?php } ?>
			</div>
			<div class='pull-left comment_input'>
				<textarea id="comment" name="comment" cols="100" rows="10"></textarea>
				<input data-id='<?php echo $row["id"];?>' id="post_comment" type="submit" name"submit" class="btn" value="Comment">
			</div>
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
    </div>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
	<script src="js/jquery.flexslider-min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(window).load(function() {
		$('.flexslider').flexslider();
	});
</script>
</body>
</html>