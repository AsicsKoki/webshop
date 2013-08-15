<?php

		include '../common.php';
		include '../notice.php';


	if (!loginCheck($conn)) {
		$_SESSION['messageError'] = "You don't have permissions to view this page.";
		header("Location: login.php");
	}


	$full = "SELECT * FROM users";

	mysql_select_db('webshop');
		$retval2 = mysql_query( $full, $conn );
	if(! $retval2 ) {
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
<!-- 			      <li><a href="#layouts"><i class="icon-chevron-right"></i> Layouts</a></li>
			      <li><a href="#responsive"><i class="icon-chevron-right"></i> Responsive design</a></li> -->
			    </ul>
			  </div>
			<div id="central">
				<table class="table table-hover">
					<thead>
						<th>First name</th>
						<th>Last name</th>
						<th>username</th>
						<th>email</th>
						<th>Action</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							while($row = mysql_fetch_assoc($retval2)) {
						 ?>
						<tr>
							<td class="column1"><?php echo $row["first_name"]; ?></a></td>
							<td class="column2"><?php echo $row["last_name"]; ?></td>
							<td class="column3"><?php echo $row["username"]; ?></td>
							<td class="column4"><?php echo $row["email"]; ?></a></td>
							<td class="column4"><a class="btn btn-warning" href="userEdit.php?id=<?php echo $row["id"]; ?>"><i class="icon-info-sign"></i>Edit</a></td>
							<td class="column4"><a class="btn btn-danger" href="userDelete.php?id=<?php echo $row["id"]; ?>"><i class="icon-info-sign"></i>Delete</a></td>
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
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>