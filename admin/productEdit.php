<?php
	include '../common.php';
	include '../notice.php';

	if (!loginCheck($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}

	$id = $_GET['id'];
	if(!empty($_POST)){
		$name        = $_POST['name'];
		$quantity    = $_POST['quantity'];
		$price       = $_POST['price'];
		$description = $_POST['description'];
		$color       = $_POST['color'];
		$image       = $_FILES['image']['name'];
		if(is_numeric($quantity) AND $quantity >= 0){

			mysql_query("UPDATE products SET quantity = '$quantity', name = '$name', price = '$price', description = '$description', colorid = '$color' WHERE id = '$id'",$conn);
				$msg = "Saved";
				messageSuccess($msg);
		} else {
				$msg = "Enter valid quantity.";
				messageError();
		}
		if ($_FILES["image"]["name"]) {

			$fileName = fileUpload($conn);
			mysql_query("INSERT INTO images (image_name, entity_id, entity_type) VALUES ('$fileName', '$id', 'product')", $conn);
		}
		header('Location: productEdit.php?id='.$_GET['id']);
	}

	//GETS THE DATA FROMT THE TABLE
	$sql = "SELECT * FROM products where id= '$id'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);

	// COLOR SELECTION
	$boje= "SELECT * FROM colors";

	$retvalColor = mysql_query( $boje, $conn );
	if(! $retvalColor ) {
	  die('Could not get data: ' . mysql_error());
	}
	//IMAGE QUERY
	$imgQuery = "SELECT * FROM images WHERE entity_type = 'product' and entity_id = '$id'";

	$retvalImg = mysql_query( $imgQuery, $conn );
	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}
	//COMMENT SECTION
	$query = "SELECT *, comments.id AS comment_id FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE product_id = $id";
	$retvalCom = mysql_query( $query, $conn );
		if(! $retvalCom )
	{
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
			<?php include 'sidebar.php'; ?>
		</div>
			<div id="central">
		<form class="form-horizontal pull-left" method="post" data-validate="parsley" enctype="multipart/form-data">
	        <div class="control-group">
	            <label class="control-label" for="name">Product name:</label>
	                <div class="controls">
						<input style="height: 30px;" type="text" name="name" value="<?php echo $row["name"];?>" data-minlength="3" data-required="true"/>
	                </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" for="price">Price:</label>
	                <div class="controls">
	                    <input style="height: 30px;" type="text" name="price" value="<?php echo $row["price"] ;?>" data-required="true" data-type="number" data-range="[1, 9999999]"/>
	                </div>
	        </div>
	         <div class="control-group">
	            <label class="control-label" for="quantity">Quantity</label>
	                <div class="controls">
	                    <input style="height: 30px;" type="number" name="quantity" value="<?php echo $row["quantity"];?>" data-required="true" data-type="number" data-range="[1, 9999999]"/>
	                </div>
	        </div>
	         <div class="control-group">
	            <label class="control-label" for="description">Product description</label>
	                <div class="controls">
	                    <textarea name="description" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["description"] ;?></textarea>
	                </div>
	        </div>
	        <div class="control-group">
	        	<div class="controls">
					<select name='color'>
						<?php
						while ($color= mysql_fetch_assoc($retvalColor)) {
							if ($row['colorid'] == $color["color_id"]) { ?>
								<option selected="selected"  value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
						<?php
						} else { ?>
								<option value="<?php echo $color["color_id"]?>"><?php echo $color["color_name"] ?></option>
							<?php
							}
						} ?>
					</select>
				</div>
			</div>
	        <div class="control-group">
	            <label style="float:left; padding-left: 100px;" class="control-lable" for="file">Filename:</label>
	                <div class="controls">
	                    <input style="padding-left: 50px;:" type="file" name="image">
	                </div>
	        </div>
	        <input type="submit" name"submit" class="btn" value="Save">
			<div id="comment_content_backend">
				<?php while($data = mysql_fetch_assoc($retvalCom)){ ?>
				<div class="well">
					<a href="user.php?id=<?php echo $data['user_id'] ?>"><?php echo "<b>".$data['username']."</b>";?></a>
						<?php
						echo "  Posted at:  ";
						echo "<i>".$data['posted_at']."</i>";
					 ?>
					 <a class="deleteComment" href="#" data-id='<?php echo $data["comment_id"]; ?>'>Delete</a>
					</header>
				<p><?php echo $data['comment']; ?> </p>
				</div>
				<?php } ?>
			</div>
		</form>
			<ul style="list-style: none;">
				<?php while ($image = mysql_fetch_assoc($retvalImg)){ ?>
					<li><img src="../files/<?php echo $image['image_name'] ?>"></img>
						<div>
						<a class="deletePhoto" href="#" data-id='<?php echo $image["id"];?>'>Delete image</a></div>
					</li>
				<?php } ?>
			</ul>
		</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/parsley.js"></script>
	<script type="text/javascript">
	</script>
</body>
</html>