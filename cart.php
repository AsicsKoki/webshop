<?php
include 'logincheck.php';
include 'common.php';

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
		<header id="header">Konstantin's web shop
		</header>
		<?php
			include "partials/loginLogout.php";
			include "partials/navbar.php"; ?>
		<div id="elementOne">
			<div id="central">
				<?php while($data = mysql_fetch_assoc($retval)){ ?>
				<div style="width=400px">
					<div class="thumbnail pull-left" style="width: 300px;">
						<img src="files/<?php echo $data['image_name']; ?>" alt="">
						<h3><?php echo $data['name']; ?></h3>
						<p><?php echo $data['description']; ?></p>
						<a class="btn btn-info" target="_blank" href="product.php?id=<?php echo $data["id"]; ?>"><i class="icon-info-sign"></i>More info</a>
					</div>
				</div>
				<?php } ?>
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