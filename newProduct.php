<?php
	include 'common.php';
	include 'notice.php';
	include 'logincheck.php';

	if (!userLogin($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}

	$username = $_SESSION['username'];
	//GETS THE DATA FROM THE TABLE
	$sql = "SELECT * FROM users WHERE username = '$username'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);
	$id = $row['id'];

	if(!empty($_POST)){
		$name        = $_POST['productName'];
		$quantity    = $_POST['quantity'];
		$price       = $_POST['price'];
		$description = $_POST['description'];
		$color       = $_POST['color'];
		$image       = $_FILES['image']['name'];
		if(is_numeric($quantity) AND $quantity > 0){

		mysql_query("INSERT INTO products (user_id, name, colorid, price, quantity, description) VALUES ('$id', '$name', '$color', '$price', '$quantity', '$description')",$conn);
			$msg = "Saved";
			messageSuccess($msg);
		} else {
			$msg = "Enter valid quantity.";
			messageError($msg);
		}
		if ($_FILES["image"]["name"]) {
			$fileName = fileUpload($conn);
			mysql_query("INSERT INTO images (image_name, entity_id, entity_type) VALUES ('$fileName', '$id', 'product')", $conn);
		}
		header('Location: index.php');
	}

	//IMAGE QUERY
	$imgQuery = "SELECT * FROM images WHERE entity_type = 'product' and entity_name = '$productName'";

	$retvalImg = mysql_query( $imgQuery, $conn );
	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}
	// COLOR SELECTION
	$boje= "SELECT * FROM colors";

	$retvalColor = mysql_query( $boje, $conn );
	if(! $retvalColor ) {
	  die('Could not get data: ' . mysql_error());
	}
?>
<!doctype HTML>
<html>
<head>
	<link rel ="stylesheet" href="css/styles.css">
	<link rel ="stylesheet" href="css/bootstrap.css">
	<link rel ="stylesheet" href="css/bootstrap.min.css">
	<link rel ="stylesheet" href="css/bootstrap-responsive.css">
	<link rel ="stylesheet" href="css/bootstrap-responsive.min.css">
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop</header>
		<div style="float: right;">
			<a href="profile.php"><button class="btn-info">Profile</button></a>
			<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a>
		</div>
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
			<div id="elementOneNewProduct">
				<!-- SUBMISION FORM -->
		<form class="form-horizontal pull-left" method="post" data-validate="parsley" enctype="multipart/form-data">
	        <div class="control-group">
	            <label class="control-label" for="productName">Product Name:</label>
	                <div class="controls">
						<input input type="text" name="productName" data-required="true">
	                </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" for="description">About me:</label>
	                <div class="controls">
	                    <textarea name="description" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["description"] ;?></textarea>
	                </div>
	        </div>
	         <div class="control-group">
	            <label class="control-label" for="price">Price:</label>
	                <div class="controls">
	                    <input name="price" placeholder="enter price"></input>
	                </div>
	        </div>
			<div class="control-group">
	            <label class="control-label" for="quantity">Quantity:</label>
	                <div class="controls">
	                    <input name="quantity" placeholder="enter quantity"></input>
	                </div>
	        </div>
			<div class="control-group">
	        	<div class="controls">
					<select name='color'>
						<?php
						while ($color= mysql_fetch_assoc($retvalColor)) {
							if ($row['colorid'] == $color["color_id"]) { ?>
								<option selected="selected"  value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						} else { ?>
								<option value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
							<?php
							}
						} ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-lable ctr_group" for="file">Filename:</label>
	                <div class="controls">
	                    <input class="fileNamePadding" type="file" name="image">
	            	</div>
	        </div>
	        <input type="submit" name"submit" class="btn" value="Save">
		</form>
		</div>
	</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/parsley.js"></script>
</body>
</html>