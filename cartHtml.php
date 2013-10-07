<div id="cart">
	<div id="content">
		<table class="table table-hover" class="display">
		<thead>
			<th>Name</th>
			<th>Quantity</th>
			<th>Price per item</th>
			<th>Action</th>
			<th>Total price</th>
		</thead>
		<tbody>
			<?php echo readFromCart();  ?>
		</tbody>
	</table>
	</div>
<a style="position: relative; bottom: -269px;" href="#" id="showCart" class="btn pull-left">Open Cart</a>
</div>