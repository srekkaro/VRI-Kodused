

	<h3>Fotod</h3>
	
	<div id="gallery">
		<?php 
						foreach($gallery as $picture) { ?>
							<img src= <?php echo $picture['pilt']; ?>  alt= <?php echo $picture['alt']; ?>/>
						<?php	
						};
					?>

	</div>

