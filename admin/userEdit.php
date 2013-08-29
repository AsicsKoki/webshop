<?php
	include '../common.php';
	include '../notice.php';

	if (!loginCheck($conn)) {
		$msg = "Please log in.";
		messageError($msg);
		header("Location: login.php");
	}

	$username = $_SESSION['username'];
	$id = $_GET['id'];
	if(!empty($_POST)){
		$first_name = $_POST['first_name'];
		$last_name  = $_POST['last_name'];
		$username   = $_POST['username'];
		$role_id    = $_POST['role_id'];
		$email      = $_POST['email'];
		$about      = $_POST['bio'];
		$image      = $_FILES['image']['name'];


		mysql_query("UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', username = '$username', role_id = '$role_id', bio = '$about' WHERE id = '$id'",$conn);
		$_SESSION['messageSuccess'] = "Saved!";

		if ($_FILES["image"]["name"]) {
			if (fileUpload($conn)) {
				mysql_query("INSERT INTO images (image_name, entity_id, entity_type, entity_name) VALUES ('$image', '$id', 'user', '$username')", $conn);
			}
		}
		header('Location: userEdit.php?id='.$_GET['id']);
	}

	//GETS THE DATA FROMT HE TABLE
	$sql = "SELECT * FROM users WHERE id = '$id'";

	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$row = mysql_fetch_assoc($retval);


	//roles
	$sql2 = "SELECT * FROM roles";
	$roles = mysql_query( $sql2, $conn );
	if(! $roles )
	{
		die('Could not get data: ' . mysql_error());
	}

	//IMAGE QUERY
	$imgQuery = "SELECT * FROM images WHERE entity_type = 'user' and entity_name = '$username'";

	$retvalImg = mysql_query( $imgQuery, $conn );
	if(! $retval ) {
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
				<!-- SUBMISION FORM -->
				<form class="form-horizontal pull-left" method="post" data-validate="parsley" enctype="multipart/form-data">
			        <div class="control-group">
			            <label class="control-label" for="first_name">First name:</label>
			                <div class="controls">
								<input style="height: 30px;" type="text" name="first_name" value="<?php echo $row["first_name"];?>" data-required="true"/>
			                </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label" for="last_name">Last name:</label>
			                <div class="controls">
								<input style="height: 30px;" type="text" name="last_name" value="<?php echo $row["last_name"];?>" data-required="true"/>
			                </div>
			        </div>
			         <div class="control-group">
			            <label class="control-label" for="username">Username</label>
			                <div class="controls">
			                   <input style="height: 30px;" type="text" name="username" value="<?php echo $row["username"];?>" data-required="true"/>
			                </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label" for="email">Email:</label>
			                <div class="controls">
			                  <input style="height: 30px;" type="text" name="email" value="<?php echo $row["email"];?>" data-required="true" data-type="email"/>
			                </div>
			        </div>
			        <div class="control-group">
			            <label class="control-label" for="bio">About me:</label>
			                <div class="controls">
			                  <textarea name="bio" cols="100" rows="10" data-rangelength="[20,400]"><?php echo $row["bio"] ;?></textarea>
			                </div>
			        </div>
			        <div class="control-group">
			        	<div class="controls">
							<select name='role_id'>
								<?php
									while ($role= mysql_fetch_assoc($roles)) {
										if ($row['role_id'] == $role["id"]) { ?>
											<option selected="selected"  value="<?php echo $role["id"]?>"><?php echo $role["role"] ?></option>
										<?php
										} else { ?>
											<option value="<?php echo $role["id"]?>"><?php echo $role["role"] ?></option>
										<?php
										}
									}
								?>
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
				</form>
				<ul style="list-style: none;">
					<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
					<li><img src="../files/<?php echo $image['image_name'] ?>"></img>
					<div><a class="deletePhoto" href="#" data-id='<?php echo $image["id"];?>'>Delete image</a></div></li>
					<?php } ?>
				</ul>
			</div>
</div>
	<footer id="footer">(2013) All rights reserved</footer>
	<script src="../js/jquery-1.10.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/parsley.js"></script>
</body>
</html>