<?php
	$conn = mysql_connect("localhost","root","","webshop");
	//$query = "SELECT * FROM products where id= '1'";
	//var_dump($query);
	if(! $conn )
	{
	  	die('Could not connect: ' . mysql_error());
	}
	$id = $_GET["id"];
	$sql = "SELECT * FROM products where id= '$id'";
	
	$sqlColors = "SELECT color FROM products where id= '$id'";

	mysql_select_db('webshop');
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not get data: ' . mysql_error());
	}
	$arr = []; // array();

	while($row = mysql_fetch_assoc($retval))
		$arr[] = $row;

	//var_dump($arr);
	$arr[0]["name"];

	$boje = ['Red','Green','Blue','Orange'];//spisak boja u nizu

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
				<div class="columnLeft">
					<?php echo $arr[0]["description"]; 
					echo '<select name="color">';
					foreach($boje AS $boja){
					    echo '<option value="'.$color.'">'.$boja.'</option>';//nesto idk sta radim... smesan rezultat.
					}
					echo '</select>';
					?>
				<footer><button class="btn btn-primary" type="button" style="float: left">Purchase item</button><input style="float: left; width: 120px;" type="text" size="2" placeholder="Enter quantity here!">
				</footer></div>
				<div class="columnRight"><img class="img-polaroid" src="images/<?php echo $arr[0]['image']; ?>"/></div>
			</div>
			<div class="side">BANNER</div>
		</div>
		<footer id="footer">(2013) All rights reserved</footer>
		    <div id="alert" class="modal hide fade">
	    <div  class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>Alert!</h3>
	    </div>
	    <div class="modal-body">
	  	  <p>Nema na lageru</p>
	    </div>
	    <div class="modal-footer">
	   	 <a href="#" class="btn" data-dismiss="modal">Close</a>
	    </div>
    </div>
    <script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/javaShop.js"></script>
	</div>
</body>
</html>
