<?php
	include 'logincheck.php';
	include 'common.php';
	//PRODUCT DATA
	$id = $_GET["id"];
	$result= mysql_query("SELECT COUNT(*) FROM products WHERE id='$id'",$conn);
	$row = mysql_fetch_assoc($result);
	if (!$row["COUNT(*)"]) {
		header("Location: /webshop/index.php");
		die();
	}

	$sql = "SELECT * FROM products where id= '$id'";

	$retval = mysql_query( $sql, $conn );
		if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$arr = [];

		while($row = mysql_fetch_assoc($retval))
	$arr[] = $row;
	$arr[0]["name"];

	// COLOR SELECTION
	$boje= "SELECT * FROM colors";

	$retval = mysql_query( $boje, $conn );
	if(! $retval )
	{
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



 ?>
<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop
			<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a>
		</header>
		<div id="elementOne">

			<div class="side"><img id="banner" src=""></div>
			<div id="central">
				<?php
				//ERROR/success CHECK AND POPUP
					include 'notice.php';
						 ?>
				<div class="columnLeft">
					<?php echo $arr[0]["description"];

					echo "<select>";
					while ($color= mysql_fetch_assoc($retval)) {
						if ($arr[0]["colorid"] == $color["id"]) { ?>
							<option selected="selected"  value="<?php echo $color["name"]?>"><?php echo $color["name"] ?></option>
						<?php
						} else { ?>
							<option value="<?php echo $color["name"]?>"><?php echo $color["name"] ?></option>
						<?php
						}
					}
					echo "</select>";
				?>
				<footer>
					<form action="" method="post">
						<label for="quantity">quantity: </label>
						<input type="submit" value="purchase">
						<input name="quantity" style="float: left; width: 120px;" type="text" size="2" placeholder="Enter quantity here!">
					</form>
				</footer>
			</div>
				<div class="columnRight"><img class="img-polaroid" src="images/<?php echo $arr[0]['image']; ?>"/>
					<input id="checkbox" type="checkbox">rotate banners
				</div>
			</div>

			<div class="side"><img id="banner2" src=""></div>
		</div>
		<footer id="footer">(2013) All rights reserved</footer>

    </div>
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/javaShop.js"></script>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
	<script src="js/main.js"></script>
	</div>
</body>
</html>