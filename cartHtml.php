<div id="cart" >
	<div id="content">
		<table class="table table-hover cart" class="display" style="overflow-y: scroll;">
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
		<div><a href="#" id="showCart" class="btn btnStyle pull-left">Open Cart</a></div>
</div>