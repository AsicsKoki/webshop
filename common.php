<?php
error_reporting(E_ALL ^ E_NOTICE);


	$conn = mysql_connect("localhost","root","","webshop");
	if(! $conn ) {
	  	die('Could not connect: ' . mysql_error());
	}

	mysql_select_db('webshop');
//LOGIN CHECK FUNCTION
function loginCheck($connectionParam){
	if (!isset($_SESSION['username']))
		return false;

	$sql    = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND role_id= 1";
	$retval = mysql_query($sql, $connectionParam);
	$role   = mysql_fetch_assoc($retval);
	return $role;
}
function addInfix($name, $infix){
		if (!$infix) return $name;
		$name2 = explode( ".", $name);
		$last = array_pop($name2);
		$penultimate = array_pop($name2);
		array_push($name2, $penultimate."_".$infix);
		array_push($name2, $last);
		$str = implode(".", $name2);
		return $str;
}
//FILE UPLOAD FUNCTION BACK END
 function fileUpload(){
	if ($_FILES["file"]["error"] > 0) {
		return false;
	}

	$infix = "";
	while(file_exists("../files/" . addInfix($_FILES["image"]["name"], $infix) )){
		if($infix == ""){
			$infix = 1;
		} else {
			$infix = $infix + 1;
		}
	}
	$str = addInfix($_FILES["image"]["name"], $infix);

	move_uploaded_file($_FILES["image"]["tmp_name"], "../files/" . $str);
	return $str;
}
//FILE UPLOAD FUNCTION FRONT END
function imageUpload($conn){
	if (file_exists("files/" . $_FILES["image"]["name"])) {
		return false;
	} else {
		move_uploaded_file($_FILES["image"]["tmp_name"], "files/" . $_FILES["image"]["name"]);
		return true;
		}
	}
//FILE DELETE BACK END
function fileDelete($conn){
	$id     = $_GET['id'];
	$sql    = "SELECT * FROM images where id= '$id'";
	$retval = mysql_query( $sql, $conn );

		if(! $retval ) {
			die('Could not get data: ' . mysql_error());
		}

	$row   = mysql_fetch_assoc($retval);
	$image = $row['image_name'];

		if ($image) {
			unlink('../files/' . $image);
			mysql_query("DELETE FROM images WHERE id = '$id'",$conn);
			echo 1;
			return;
		}
		echo 0;
	}

//FILE DELETE FRONT END
	function imageDelete($conn){
	$username = $_SESSION['username'];
	$sql      = "SELECT * FROM images where entity_name= '$username'";
	$retval   = mysql_query( $sql, $conn );

		if(! $retval ) {
			die('Could not get data: ' . mysql_error());
		}

	$row   = mysql_fetch_assoc($retval);
	$image = $row['image_name'];

		if ($image) {
			unlink('files/' . $image);
			mysql_query("DELETE FROM images WHERE entity_name = '$username'",$conn);
			echo 1;
			return;
		}
		echo 0;
	}
//MESSAGE ERROR/SUCCESS
function messageError($msg){
	$_SESSION['messageError'] = $msg;
}
function messageSuccess($msg){
	$_SESSION['messageSuccess'] = $msg;
}
//SELECTS USER PHOTO FOR PROFILE PAGE
function getUserPhoto($user_id){
	$sql      = "SELECT * FROM images where entity_type = 'user' AND entity_id= '$user_id'";
	global $conn;
	$retval   = mysql_query( $sql, $conn );
	$res = mysql_fetch_assoc($retval);
	if($res){
		return $res['image_name'];
	} else {
		return "default.jpg";
	}
}
function getProductPhoto($id){
	$sql      = "SELECT count(*) FROM images WHERE entity_type = 'product' and entity_id = '$id'";
	global $conn;
	$retval   = mysql_query( $sql, $conn );
	$data = mysql_result($retval, 0);
	if($data > 0){
		return 1;
	} else {
		return 0;
	}
}
// DELETES COMMENTS BACKEND
function commentDelete($conn){
	$id  = $_GET['id'];
	$sql = "DELETE FROM comments WHERE id = $id";
	mysql_query( $sql, $conn );
	return 1;
	}
/**
 * Identifies whether something is liked, and decides what to render.
 * @param  [type]  $comment_id [Comment id from comment_likes table]
 * @param  [type]  $user_id    [User id from comment likes]
 * @return boolean             [Resault, if 1(both id's match) returns true and renders "unlike".]
 */
function hasLikes($comment_id, $user_id = null){
	global $conn;

	if ($comment_id and $user_id) {
		$like_query = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
	}
	$retval = mysql_query($like_query, $conn);
	return mysql_result($retval, 0, 0);
}
/**
 * Counts the number of likes per comment.
 * @param  [type] $comment_id [comment id from comment likes, the ammoun of this occurring is the number of likes.]
 * @return [type]             [returns the number of likes]
 */
function countLikes($comment_id){
	global $conn;
	$sql = "SELECT COUNT(1) FROM comment_likes WHERE comment_id = '$comment_id'";
	$retval = mysql_query($sql, $conn);
	$count = mysql_result($retval, 0, 0);
	return $count;
}
/**
 * Reads the names of the useres that liked a comment.
 * @param  [type] $comment_id [comment id from the comment likes table]
 * @return [type]             [description]
 */
function usersThatLiked($comment_id){
	global $conn;
	$sqlPeople = "SELECT * FROM comment_likes LEFT JOIN users ON comment_likes.user_id = users.id WHERE comment_id = '$comment_id'";
	$retvalPeopole = mysql_query($sqlPeople, $conn);
	return $retvalPeopole;
}
 /**
  * Calcutales the average rating of a product, only the product id is passed down.
  */
function calculateRating($productId){
	global $conn;
	$sql     = "SELECT rating FROM product_ratings WHERE product_id = $productId";
	$retval  = mysql_query($sql, $conn);
	$rows = mysql_num_rows($retval);
	if ($rows != 0){
		$ratings = mysql_fetch_array($retval);
		$resault = array_sum($ratings) / count(array_filter($ratings));
		return $resault;
	} else {
		$resault = 0;
		return $resault;
	}

}
/**
 * Renders the stars according to the rating of the product.
 * @param  [type] $result    [average product rating]
 * @param  [type] $productId [product id]
 * @param  [type] $userId    [user id]
 * @return [type]            [html containing the stars]
 */
function renderStars($result, $productId, $userId){
	$html = '';
	$id = $productId;
	$userId = $userId;
	$html = '';
	$mark = $result;
	$rest = 5 - $mark;

	for ($i=0; $i < $mark ; $i++) {
		$html .= '<div class="ratings_stars ratings_over" data-productid="'.$id.'" data-userid="'.$userId.'"></div>';
	}
	for ($i=0; $i < $rest; $i++) {
		$html .= '<div class="ratings_stars" data-productid="'.$id.'" data-userid="'.$userId.'"></div>';
	}
	return $html;
}
/**BACK END
 * Renders the categories parent when adding a new category.
 * @param  [type]  $parentId [parent id passed as 0, decleres where the iteration starts]
 * @param  integer $level    [level of subcategory]
 * @return [type]            [colection of option tags to use in select tag]
 */
function renderCategories($parentId, $level = 0){
	global $conn;
	$html = "";
	if($parentId)
		$sql = "SELECT * FROM categories WHERE parent_id = $parentId";
	else
		$sql = "SELECT * FROM categories WHERE ISNULL(parent_id)";

	$query = mysql_query($sql, $conn);
	while($res = mysql_fetch_assoc($query)){
		$currentId = $res['id'];
		$html .= "<option value=".$currentId.">";
 		$html .= str_repeat("-", $level);
		$html .= $res['name']."</option>";
		$html .= renderCategories($currentId, $level+1);
	}
	return $html;
}
/**FRONT END
 * Renders the categories parent when selecting a new category.
 * @param  [type]  $parentId [description]
 * @param  integer $level    [description]
 * @return [type]            [front end render html]
 */
function renderCategorySelection($parentId, $level = 0, $productId = NULL){
	global $conn;
	$html = "";
	if($productId)
		$join = "LEFT JOIN categorized_products ON categories.id = categorized_products.category_id";
	else
		$join = "";


	if($parentId)
		$sql = "SELECT * FROM categories $join WHERE parent_id = $parentId";
	else
		$sql = "SELECT * FROM categories $join WHERE ISNULL(parent_id)";

	$query = mysql_query($sql, $conn);
	while($res = mysql_fetch_assoc($query)){
		$checked = $res['product_id']? "checked = checked": "";
		$currentId = $res['id'];
		$html .= "<li><input type='checkbox'".$checked." name='category[]' class='categoryCheck' data-productId=".$productId." data-categoryId=".$currentId." value=".$currentId.">";
 		$html .= str_repeat(" - ", $level);
		$html .= $res['name']."</li>";
		$html .= renderCategorySelection($currentId, $level+1, $productId);
	}
	return $html;
}
/**
 * [renderCategories description]
 * @param  [type]  $parentId [description]
 * @param  integer $level    [description]
 * @return [type]            [description]
 */
function renderCategoryMenu($parentId, $level = 0){
	global $conn;
	$html = "";
	if($parentId)
		$sql = "SELECT * FROM categories WHERE parent_id = $parentId";
	else
		$sql = "SELECT * FROM categories WHERE ISNULL(parent_id)";

	$query = mysql_query($sql, $conn);
	while($res = mysql_fetch_assoc($query)){
		$currentId = $res['id'];
		$html .= "<li><a href='products.php?id=".$currentId."'>";
 		$html .= str_repeat(" - ", $level);
		$html .= $res['name']."</a></li>";
		$html .= renderCategoryMenu($currentId, $level+1);
	}
	return $html;
}
/**
 * Shopping cart item add.
 * @param [type] $id [Product id passed via post]
 * @param [type] $quantity  [Quantity of an item]
 */
function addToCart($id, $quantity){
	if($quantity < 1) return;
	session_start();
//Checks if the cart exists, if not, sets it.
	if (!isset($_SESSION['cart']))
		$_SESSION['cart']=array();
//Checks if the cart items exists, of not creates it,
	if (!isset($_SESSION['cart'][$id])) {
		$_SESSION['cart'][$id] = $quantity;
	} else {
//if it does, it updates quantity.
		$_SESSION['cart'][$id] += $quantity;
	}
}
/**
 * Prints out the rows for the shopping cart.
 * @return [type] [Full set of html rows]
 */
function readFromCart(){
	global $conn;
	if($_SESSION['cart']){
		$totalPrice = 0;
		$html = "<tr>";
		foreach ($_SESSION['cart'] as $id => $quantity) {
			$sql = "SELECT * FROM products WHERE id = $id";
			$query = mysql_query($sql, $conn);
			$data  = mysql_fetch_assoc($query);
			$price = $data['price'];
			$sum   = $price*$quantity;
			$totalPrice = $totalPrice + $sum;
			$html .= "<td>".$data['name']."</td>";
			$html .= "<td>".$quantity."</td>";
			$html .= "<td>".$data['price']."</td>";
			$html .= "<td><a href=# class='delete btn' data-id=".$id.">Remove</a></td>";
			$html .= "<td>".$sum."</td>";
			$html .= "</tr>";
		}
		$html .= "<div><h4>Total price: ".$totalPrice."</h4></div>";
		return $html;
	} else {
		return "Empty!";
	}
}
function printOrder(){
global $conn;
	if($_SESSION['cart']){
		$totalPrice = 0;
		$html = "<tr>";
		foreach ($_SESSION['cart'] as $id => $quantity) {
			$sql = "SELECT * FROM products WHERE id = $id";
			$query = mysql_query($sql, $conn);
			$data  = mysql_fetch_assoc($query);
			$price = $data['price'];
			$sum   = $price*$quantity;
			$totalPrice = $totalPrice + $sum;
			$html .= "<td>".$data['name']."</td>";
			$html .= "<td>".$quantity."</td>";
			$html .= "<td>".$data['price']."</td>";
			$html .= "<td>".$sum."</td>";
			$html .= "</tr>";
		}
		$html .= "<div class='pull-right'><h4>Total price:</h4> ".$totalPrice."$</div>";
		return $html;
	} else {
		return "Empty!";
	}
}
?>