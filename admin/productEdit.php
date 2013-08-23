<?php
	include '../common.php';
	include '../notice.php';



	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "Please log in!";
		header("Location: login.php");
	}

	$id = $_GET['id'];
	if(!empty($_POST)){
		$name        = $_POST['name'];
		$quantity    = $_POST['quantity'];
		$price       = $_POST['price'];
		$description = $_POST['description'];
		$color       = $_POST['color'];
		$image       = $_FILES['image']['name'];
		if(is_numeric($quantity) AND $quantity >= 0){

			mysql_query("UPDATE products SET quantity = '$quantity', name = '$name', price = '$price', description = '$description', colorid = '$color' WHERE id = '$id'",$conn);
			$_SESSION['messageSuccess'] = "Saved!";
		} else {
			$_SESSION['messageError'] = "Please enter valid quantity";
		}
		if ($_FILES["image"]["name"]) {

			if (fileUpload($conn)){
				mysql_query("INSERT INTO images (image_name, entity_id, entity_type)VALUES ('$image', '$id', 'product')", $conn);
			} 
		}
		header('Location: productEdit.php?id='.$_GET['id']);
	}

	//GETS THE DATA FROMT THE TABLE
	$sql = "SELECT * FROM products where id= '$id'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);

	// COLOR SELECTION
	$boje= "SELECT * FROM colors";

	$retvalColor = mysql_query( $boje, $conn );
	if(! $retvalColor ) {
	  die('Could not get data: ' . mysql_error());
	}
	//IMAGE QUERY
	$imgQuery = "SELECT * FROM images WHERE entity_type = 'product' and entity_id = '$id'";

	$retvalImg = mysql_query( $imgQuery, $conn );
	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
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
		<?php include 'sidebar.php'; ?>
			  </div>
			<div id="central">
				<form action="" method="post" data-validate="parsley" enctype="multipart/form-data">
				<ul style="list-style: none;">
				<li>Name:<input type="text" name="name" value="<?php echo $row["name"];?>" data-minlength="3" data-required="true"/></li>
				<li>Price:<input type="text" name="price" value="<?php echo $row["price"] ;?>" data-required="true" data-type="number"/></li>
				<li>Quantity:<input type="number" name="quantity" value="<?php echo $row["quantity"];?>" data-required="true" data-type="number"/></li>
				<li>Description:<textarea name="description" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["description"] ;?></textarea></li>
				<li><select name='color'>
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
				</select></li>
				<div class="uploadFile"><li><label for="file">Filename:</label></li>
					<li><input type="file" name="image"><br></li>
					<li><input type="submit" name"submit" class="btn" value="Save"></li>
				</div>
				</ul>
				</form>
					<ul style="list-style: none;">
					<?php while ($image = mysql_fetch_assoc($retvalImg)){ ?>
						<li><img src="../files/<?php echo $image['image_name'] ?>"></img>
						<div>
						<a class="deleteFile" href="#" data-id='<?php echo $image["id"];?>'>Delete image</a></div></li>
					<?php } ?>
					</ul>
			</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/parsley.js"></script>
	<script type="text/javascript">
	</script>
</body>
</html>