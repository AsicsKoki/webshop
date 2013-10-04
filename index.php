<?php
include 'logincheck.php';
include 'common.php';

if (!userLogin($conn)) {
	$msg = "Please log in.";
	messageError($msg);
	header("Location: login.php");
	}
$username = $_SESSION['username'];
//SELECT TABLE INFO
$sql = "SELECT * FROM products LEFT JOIN colors ON products.colorid = colors.color_id WHERE active = 1";

mysql_select_db('webshop');

$retval = mysql_query( $sql, $conn );
if(! $retval ) {
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
?>
<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/jquery.dataTables_themeroller.css">
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">
			<p>Konstantin's web shop</p>
			<div id="cart">
				<div id="content">123</div>
				<a style="position: relative; bottom: -269px;" href="#" id="showCart" class="btn pull-left">Open Cart</a>
			</div>
		</header>
		<?php
			include "partials/loginLogout.php";
			include "partials/navbar.php"; ?>
		<div id="elementOne">
			<div class="menu">
				<ul class="plain"  role="menu" aria-labelledby="dLabel">
					<?php echo renderCategoryMenu(0, 0); ?>
				</ul>
			</div>
				<div id="central">
				<table id="productsTable" class="table table-hover" class="display">
					<thead>
						<th>Product name</th>
						<th>Color</th>
						<th>Price</th>
						<th>Action</th>
						<th>Quantity</th>
					</thead>
					<tbody>
						<?php
							while($row = mysql_fetch_assoc($retval)) {
						 ?>
						<tr>
							<td class="column1"><a href="product.php?id=<?php echo $row["id"]; ?>" target="_blank"><?php echo $row["name"]; ?></a></td>
							<td class="column2"><?php echo $row["color_name"]; ?></td>
							<td class="column3"><i class="icon-tag"></i><?php echo $row["price"]; ?></td>
							<td class="column4"><a class="btn btn-info" target="_blank" href="product.php?id=<?php echo $row["id"]; ?>"><i class="icon-info-sign"></i>More info</a></td>
							<td class="column5"><?php echo $row["quantity"] ?></td>
						</tr>
						<?php
							}
						 ?>
					</tbody>
				</table>
			</div>
			<div class="side"><img id="banner2" src=""></div>
			<input id="checkbox" type="checkbox">rotate banners
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
	</div>
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script>
		var banners  = <?php echo json_encode($banners); ?>;
		var banners2 = <?php echo json_encode($banners2); ?>;
	</script>
</body>
</html>
<?php mysql_close($conn); ?>