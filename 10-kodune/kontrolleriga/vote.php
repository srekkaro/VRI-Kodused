
	<h3>Vali oma lemmik :)</h3>
	<form action="?page=tulemus" method="POST">
		<?php 
						$i=1;
						foreach($gallery as $picture) { 
							$p='v'.$i;
							?>
							<p>
							<label for=<?php echo $p; ?>>
							<img src= <?php echo $picture['pilt']; ?>  alt= <?php echo $picture['alt']; ?>/>
							</label>
							<input type="radio" value= <?php echo $i; ?> id = <?php echo $p; ?> name="pilt"/>
							</p>
						<?php	
						$i++;
						};
					?>

		<br/>
		<input type="submit" value="Valin!"/>
	</form>
