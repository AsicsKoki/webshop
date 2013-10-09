<!doctype html>
<html>
<head>
	<title>OOP ucenje</title>
	<?php include "oop_lib.php"; ?>
</head>
<body>
<?php
	$koki = new person();
	$mika = new person();
	$koki->set_name("Konstantin Velickovc");
	$mika->set_name("Miljana Brankovic");

	echo $koki->get_name();
	echo $mika->get_name();

 ?>
</body>
</html>