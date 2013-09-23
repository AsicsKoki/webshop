<?php
	include '../common.php';
	include '../notice.php';

	if (!loginCheck($conn)) {
		$msg = "You do not have permissions to enter this page.";
		messageError($msg);
		header("Location: login.php");
	}

	$full = "SELECT * FROM categories";
	$retval = mysql_query( $full, $conn );

	$full2 = "SELECT * FROM categories";
	$retval2 = mysql_query( $full2, $conn );
?>
<!doctype HTML>
<html>
<head>
	<link rel ="stylesheet" href="../css/styles.css">
	<link rel ="stylesheet" href="../css/bootstrap.css">
	<link rel ="stylesheet" href="../css/bootstrap.min.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.css">
	<link rel ="stylesheet" href="../css/bootstrap-responsive.min.css">
	<link rel ="stylesheet" href="../css/jquery.dataTables.css">
	<link rel ="stylesheet" href="../css/jquery.dataTables_themeroller.css">
</head>
<body id="background">
<div id="mainElement">
	<header id="header">Konstantin's web shop
	<a href="logout.php"><button class="btn-danger" src="logout.php">Log out!</button></a></header>
		<div id="elementOne">
		<?php include 'sidebar.php'; ?>
			  </div>
			<div id="central">
				<a href="addCategory.php" class="btn pull-left">Add category</a>
				<table id="categoryTable" class="table table-hover" class="display">
					<thead>
						<th>Id</th>
						<th>Category</th>
						<th>Parent id</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							while($info = mysql_fetch_assoc($retval2)) {
						?>
						<tr>
							<th><?php echo $info["id"]?></th>
							<th><?php echo $info["name"]?></th>
							<th><?php echo $info['parent_id']?></th>
							<th>
								<a href="#" class="btn delete_category" data-categoryid='<?php echo $info['id'] ?>'>Delete</a>
							</th>
						</tr>
						<?php
							}
						 ?>
					</tbody>
				</table>
			</div>
		</div>
	<footer id="footer">(2013) All rights reserved</footer>
</div>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
</body>
</html>