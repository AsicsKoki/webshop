<?php 
	session_start();
function successMessage(){
	if(isset($_SESSION['messageSuccess'])){
		echo "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>{$_SESSION['messageSuccess']}</div>";
		unset($_SESSION['messageSuccess']);
	}
}
function errorMessage(){
	if(isset($_SESSION['messageError'])){
		echo "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>{$_SESSION['messageError']}</div>";
		unset($_SESSION['messageError']);
	}
}
 ?>