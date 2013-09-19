<div id="r1" class="rate_widget">
	<?php echo renderStars(calculateRating($id), $id, $userId);
	?>
	<div class='pull-right'>Current rating: <?php echo calculateRating($id); ?></div>
</div>

