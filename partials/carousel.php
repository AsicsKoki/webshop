<div id="slider1">
	<a class="buttons prev" href="#">left</a>
		<div class="viewport">
			<ul class="overview">
			<?php while($image = mysql_fetch_assoc($retvalImg)){ ?>
				<li><img src="files/<?php echo $image['image_name'] ?>"></img></li>
			<?php } ?>
			</ul>
		</div>
	<a class="buttons next" href="#">right</a>
</div>