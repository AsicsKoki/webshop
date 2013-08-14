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

		if(is_numeric($quantity) AND $quantity >= 0){

			mysql_query("UPDATE products SET quantity = '$quantity', name = '$name', price = '$price', description = '$description', colorid = '$color' WHERE id = '$id'",$conn);
			$_SESSION['messageSuccess'] = "Saved!";
			header('Location: productEdit.php?id='.$_GET['id']);
		} else {
			$_SESSION['messageError'] = "Please enter valid quantity";
			header('Location: productEdit.php?id='.$_GET['id']);
		}
	}

	//GETS THE DATA FROMT HE TABLE
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
			 <div class="span3 bs-docs-sidebar">
			    <ul class="nav nav-list bs-docs-sidenav affix-top" data-spy="affix" data-offset-top="100">
			      <li class="header"><h3>Menu</h3></li>
			      <li class="active"><a href="panel.php"><i class="icon-chevron-right"></i> Panel home </a></li>
			      <li><a href="products.php"><i class="icon-chevron-right"></i> Products </a></li>
			      <li><a href="Users.php"><i class="icon-chevron-right"></i> Users </a></li>
			    </ul>
			  </div>
			<div id="central">
				<form action="" method="post" data-validate="parsley">
				<ul>
				<li>Name:<input type="text" name="name" value="<?php echo $row["name"];?>" data-minlength="3" data-required="true"/></li>
				<li>Price:<input type="text" name="price" value="<?php echo $row["price"] ;?>" data-required="true" data-type="number"/></li>
				<li>Quantity:<input type="number" name="quantity" value="<?php echo $row["quantity"];?>" data-required="true" data-type="number"/></li>
				<li>Description:<textarea name="description" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["description"] ;?></textarea></li>
				<select name='color'>
				<?php
					while ($color= mysql_fetch_assoc($retvalcolor)) {
						if ($row['colorid'] == $color["id"]) { ?>
							<option selected="selected"  value="<?php echo $color["id"]?>"><?php echo $color["name"] ?></option>
						<?php
						} else { ?>
							<option value="<?php echo $color["id"]?>"><?php echo $color["name"] ?></option>
						<?php
						}
					}
				?>
				</select>
				<li><input type="submit" name"submit" class="btn" value="Save"></li>
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