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

			mysql_query("UPDATE products SET quantity = '$quantity', name = '$name', price = '$price', description = '$description', colorid = '$color', image = '$image' WHERE id = '$id'",$conn);
			$_SESSION['messageSuccess'] = "Saved!";
		} else {
			$_SESSION['messageError'] = "Please enter valid quantity";
		}
		if ($_FILES["image"]["name"]) {
			fileUpload($conn);
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

	$retvalcolor = mysql_query( $boje, $conn );
	if(! $retvalcolor )
	{
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
				<img src="../files/<?php echo $row['image'] ?>"></img>
				<form action="" method="post" data-validate="parsley" enctype="multipart/form-data">
				<ul>
				<li>Name:<input type="text" name="name" value="<?php echo $row["name"];?>" data-minlength="3" data-required="true"/></li>
				<li>Price:<input type="text" name="price" value="<?php echo $row["price"] ;?>" data-required="true" data-type="number"/></li>
				<li>Quantity:<input type="number" name="quantity" value="<?php echo $row["quantity"];?>" data-required="true" data-type="number"/></li>
				<li>Description:<textarea name="description" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["description"] ;?></textarea></li>
				<select name='color'>
				<?php
					while ($color= mysql_fetch_assoc($retvalcolor)) {
						if ($row['colorid'] == $color["color_id"]) { ?>
							<option selected="selected"  value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						} else { ?>
							<option value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						}
					} ?>
				</select>
				<?php
					if ($row['image']) {?>
						<li><a href="fileDelete.php?id=<?php echo $row["id"]; ?>">Delete image</a></li>
			<?php } else { ?>
						<li><label for="file">Filename:</label></li>
						<li><input type="file" name="image"><br></li>
						<li><input type="submit" name"submit" class="btn" value="Save"></li>
						<?php } ?>
				</ul>
				</form>
			</div>
		</div>
	<footer id="footer">(2013) All rights reserved</footer>
</div>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/parsley.js"></script>
</body>
</html>