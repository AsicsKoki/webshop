<?php 
	if(isset($error)){
		echo "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>$error</div>";
	}
	if(isset($sucsses)){
		echo "<div class='alert alert-sucsses'> <button type='button' class='close' data-dismiss='alert'>&times;</button>$sucsses</div>";
	}

 ?>