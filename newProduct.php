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
			$productId =  mysql_insert_id();
			$msg = "Saved";
			messageSuccess($msg);
		} else {
			$msg = "Enter valid quantity.";
			messageError($msg);
		}
		foreach ($_POST['category'] as $categoryId) {
			mysql_query("INSERT INTO categorized_products (product_id, category_id) VALUES ('$productId', '$categoryId')", $conn);
		}
		header('Location: index.php');
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
					<li><a href="index.php">Products</a></li>
					<li><a href="users.php">Users</a></li>
					<li><a href="newProduct.php">Sell item</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</div>
		</div>
		<div id="elementOne">
			<div>
				<!-- SUBMISION FORM -->
		<form class="form-horizontal pull-left" method="post" data-validate="parsley" enctype="multipart/form-data">
		<div>
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
	        <input type="submit" name"submit" class="btn" value="Save">
		</div>
		<div id="categorySelect">
			<ul style='list-style: none; text-align: left;'>
			<h4>Please select item category:</h4>
			<?php echo renderCategorySelection(0,0); ?>
			</ul>
		</div>
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