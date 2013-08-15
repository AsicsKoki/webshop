<?php
	include '../common.php';
	include '../notice.php';


	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "Please log in!";
		header("Location: login.php");
	}

	$id = $_GET['id'];
	if(!empty($_POST)){
		$first_name = $_POST['first_name'];
		$last_name  = $_POST['last_name'];
		$username   = $_POST['username'];
		$role_id    = $_POST['role_id'];
		$email      = $_POST['email'];


		mysql_query("UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', username = '$username', role_id = '$role_id' WHERE id = '$id'",$conn);
		$_SESSION['messageSuccess'] = "Saved!";
		header('Location: userEdit.php?id='.$_GET['id']);
	}

	//GETS THE DATA FROMT HE TABLE
	$sql = "SELECT * FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.id = '$id'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);
	//FETCH ROLES


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
				<!-- SUBMISION FORM -->
				<form action="" method="post" data-validate="parsley">
				<ul>
				<li>First name:<input type="text" name="first_name" value="<?php echo $row["first_name"];?>" data-minlength="3" data-required="true"/></li>
				<li>Last name:<input type="text" name="last_name" value="<?php echo $row["last_name"] ;?>" data-required="true" ></li>
				<li>Username:<input type="text" name="username" value="<?php echo $row["username"];?>" data-required="true"></li>
				<li>email:<input type="text" name="email" value="<?php echo $row["email"] ;?>" data-required="true" data-type="email" ></li>
				<li>Role:<input type="number" name="role_id" value="<?php echo $row["role_id"] ;?>" data-required="true" data-type="number"></li>
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