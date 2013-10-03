<?php
include 'logincheck.php';
include 'common.php';
	session_start();
	$_SESSION['username'] = $username;
	if(!isset($_SESSION['cart']))
		header("Location: index.php");

	foreach ($_SESSION['cart'] as $id => $quantity) {
		mysql_query("UPDATE products SET quantity= quantity - '$quantity' WHERE id = '$id'",$conn);
	}

	mysql_query("INSERT INTO orders (user_name) VALUES ($username)",$conn);



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
		<header id="header">Konstantin's web shop</header>
		<?php
			include "partials/loginLogout.php";
			include "partials/navbar.php"; ?>
		<div id="elementOne">
			<div id="central">
				<table class="table table-hover pull-left" class="display">
					<thead>
						<th>Name</th>
						<th>Quantity</th>
						<th>Price per item</th>
						<th>Total price</th>
					</thead>
					<tbody>
						<?php echo printOrder();  ?>
					</tbody>
				</table>
				<div>
					
				</div>
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
		<script type="text/javascript">
		$('.delete').click(function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var self = this;
		$.ajax({
			url: "cartDelete.php",
			type: "POST",
			data: {
				id: id
			},
			success: function(data){
				$(self).parents("tr").remove();
				}
			});
		});
	</script>
</body>
</html>
<?php mysql_close($conn);
unset($_SESSION['cart']); ?>\