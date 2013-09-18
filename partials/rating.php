<div id="r1" class="rate_widget">
	<div class="ratings_stars" data-rating="1" data-productid="<?php echo $id; ?>" data-userid="<?php echo $userId; ?>"></div>
	<div class="ratings_stars" data-rating="2" data-productid="<?php echo $id; ?>" data-userid="<?php echo $userId; ?>"></div>
	<div class="ratings_stars" data-rating="3" data-productid="<?php echo $id; ?>" data-userid="<?php echo $userId; ?>"></div>
	<div class="ratings_stars" data-rating="4" data-productid="<?php echo $id; ?>" data-userid="<?php echo $userId; ?>"></div>
	<div class="ratings_stars" data-rating="5" data-productid="<?php echo $id; ?>" data-userid="<?php echo $userId; ?>"></div>
	<div class='pull-right'>Current rating: <?php echo calculateRating($id); ?></div>
</div>
<!-- http://net.tutsplus.com/tutorials/html-css-techniques/building-a-5-star-rating-system-with-jquery-ajax-and-php/ -->

<!-- render rating -funkcija, prosledjujemo calculate rating funkciju -->