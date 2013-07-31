<?php 
	
	// $con = mysqli_connect("localhost","root","","webshop"); 
	// $result = mysqli_query($con,"SELECT * FROM table products");
	
	// var_dump($result);

$conn = mysql_connect("localhost","root","","webshop");
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
$sql = 'SELECT * FROM products';

mysql_select_db('webshop');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
	$full= "SELECT products.id, products.name as product_name, colorid, price, quantity, image, description, colors.id as colors_id, colors.name as colors_name FROM products, colors WHERE (colors.id = colorid)";

	mysql_select_db('webshop');
	$retval2 = mysql_query( $full, $conn );
		if(! $retval2 )
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
</head>
<body id="background">
	<div id="mainElement">
		<header id="header">Konstantin's web shop</header>
		<div id="elementOne">
			<div class="side" >BANNER</div>
			<div id="central">
				<table class="table table-hover">
					<thead>
						<th>Product name</th>
						<th>Color</th>
						<th>Price</th>
						<th>Action</th>
						<th>Quantity</th>
					</thead>
					<tbody>
						<?php 
							while($row = mysql_fetch_assoc($retval2)) {

						 ?>
						<tr>
							<td class="column1"><a href="product.php?id=<?php echo $row["id"]; ?>" target="_blank"><?php echo $row["product_name"]; ?></a></td>
							<td class="column2"><?php echo $row["colors_name"]; ?></td>
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
			<div class="side">BANNER</div>
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
	</div>
	<script src="bootstrap.js"></script>
	<script src="bootstrap.min.js"></script>
	<script src="main.js"></script>
</body>
</html>
<?php mysql_close($conn); ?>