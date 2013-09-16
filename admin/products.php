<?php

		include '../common.php';
		include '../notice.php';


	if (!loginCheck($conn)) {
		$msg = "You do not have permissions to enter this page.";
		messageError($msg);
		header("Location: login.php");
	}


	$full = "SELECT * FROM products LEFT JOIN colors ON products.colorid = colors.color_id";


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
				<table id="productsTable" class="table table-hover" class="display">
					<thead>
						<th>Product name</th>
						<th>Color</th>
						<th>Price</th>
						<th>Action</th>
						<th>Action</th>
						<th>Quantity</th>
						<th>Active</th>
					</thead>
					<tbody>
						<?php
							while($row = mysql_fetch_assoc($retval2)) {
								$active = $row['active'];
						 ?>
						<tr>
							<td class="column1"><a href="../product.php?id=<?php echo $row["id"]; ?>" target="_blank" ><?php echo $row["name"]; ?></a></td>
							<td class="column2"><?php echo $row["color_name"]; ?></td>
							<td class="column3"><i class="icon-tag"></i><?php echo $row["price"]; ?></td>
							<td class="column4"><a class="btn btn-warning" href="productEdit.php?id=<?php echo $row["id"]; ?>"><i class="icon-info-sign"></i>Edit</a></td>
							<td class="column4"><a data-id='<?php echo $row["id"]; ?>' class="delete" class="btn btn-danger"><i class="icon-info-sign"></i>Delete</a></td>
							<td class="column5"><?php echo $row["quantity"] ?></td>
							<td>
								<input class="active" type="checkbox" data-id='<?php echo $row["id"];?>' <?php echo $active ? "checked": ""; ?>>
							</td>
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
	<script type="text/javascript">
		//AJAX ACTIVE CONTROLS
		$('.active').click(function(e){
			var id = $(this).data('id');
			var active = $(this).is(':checked');
			$.ajax({
				url: "changeState.php",
				type: "get",
				data: {
					id: id,
					active: active?1:0
				},
				success: function(data){
					if (!data){
						e.preventDefault();
					}
				}
			});
		});
	</script>
</body>
</html>