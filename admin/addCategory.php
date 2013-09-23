<?php
include '../common.php';
include '../notice.php';

$full = "SELECT * FROM categories";
$retval = mysql_query( $full, $conn );


if (!empty($_POST)) {
	$name = $_POST['category_name'];
	$parent = $_POST['parent'];
	mysql_query("INSERT INTO categories (name, parent_id) VALUES ('$name','$parent')", $conn);
	header("Location: categories.php");
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
					<form form-horizontal method="post">
					<div class="control-group">
			            <label class="control-label" for="category_name">Category name</label>
			                <div class="controls">
								<input class="input_height" type="text" name="category_name"  data-required="true"/>
			                </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label" for="parent">Parent</label>
			                <div class="controls">
								<select name="parent">
								<?php
									echo renderCategories(0, 0); ?>
								</select>
			                </div>
			        </div>
			        <input type="submit" name"submit" class="btn" value="Add">
				</form>
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