<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Teksti kujundaja. Kodune 10</title>
		<script>
			<?php 
				$bg_col="#FFFFFF"; // taust vaikimisi valge
				$txt_col="#000000"; //tekst vaikimisi must
				$line_width="1"; //joon vaikimisi 1 piksli paksune
				$line_style="solid"; //joone tyyp vaikimisi pidev
				$line_col="#FF0000"; //joon vaikimisi 
				$bor_ra="0"; //teksti ala nurga raadius vaikimisi 0
				$text="Siia tuleb tekst!"; //siin on muudetav tekst
				
				if (isset($_POST['tekst']) && $_POST['tekst']!="") {
					$text=htmlspecialchars($_POST['tekst']);
				}
				if (isset($_POST['taust']) && $_POST['taust']!="") {
    				$bg_col=htmlspecialchars($_POST['taust']);
				} 
				if (isset($_POST['tekstitoon']) && $_POST['tekstitoon']!="") {
    				$txt_col=htmlspecialchars($_POST['tekstitoon']);
				} 
				if (isset($_POST['joonelaius']) && $_POST['joonelaius']!="") {
    				$line_width=htmlspecialchars($_POST['joonelaius']);
				} 
				if (isset($_POST['joonestiil']) && $_POST['joonestiil']!="") {
    				$line_style=htmlspecialchars($_POST['joonestiil']);
				} 
				if (isset($_POST['piirjoonetoon']) && $_POST['piirjoonetoon']!="") {
    				$line_col=htmlspecialchars($_POST['piirjoonetoon']);
				} 
				if (isset($_POST['nurgasuurus']) && $_POST['nurgasuurus']!="") {
    				$bor_ra=htmlspecialchars($_POST['nurgasuurus']);
				} 		
			?>		
		</script>
		<style type="text/css">
			#sisu { width:60%;
					margin-top:5%;
					margin-left: auto;
					margin-right: auto;				
					text-align:left;
				}
			#ekraan {height:10%;
					border-width:<?php echo $line_width."px"; ?>;
					border-style:<?php echo $line_style; ?>;
					border-color:<?php echo $line_col; ?>;
					border-radius:<?php echo $bor_ra."px"; ?>;
					background-color:<?php echo $bg_col; ?>;
					color:<?php echo $txt_col; ?>;
					text-align: center;
			}
		</style>
	</head>
	<body>
		<div id="sisu">
			<div id="ekraan">
				<p><?php echo $text; ?></p>
			</div>
			<hr>
			<div id="sisestus">
				<textarea name="tekst" form="vorm1" cols="50" rows="10"><?php echo $text; ?></textarea>		
				<form method="post" action="kymme-yl1.php" id="vorm1">
					<input type="color" name="taust" value=<?php echo $bg_col; ?>>
					<label for="taust">Taustav&auml;rv</label>
					<br>
					<input type="color" name="tekstitoon" value=<?php echo $txt_col; ?>>
					<label for="tekstitoon">Tekstiv&auml;rv</label><br>
					<!--Siit hakkab piirjoone osa -->
					<fieldset>
						<legend>Piirjoon</legend>
							<input type="number" name="joonelaius" min="0" max="20" value=<?php echo $line_width; ?>>
						<label for="joonelaius">Piirjoone laius (0-20px)</label><br>
						<select name="joonestiil">
							<option value =<?php echo $line_style; ?> selected><?php echo $line_style; ?></option>
							<option value="solid">Solid</option>
							<option value="dotted">Dotted</option>
							<option value="dashed">Dashed</option>
							<option value="double">Double</option>
							<option value="groove">Groove</option>
							<option value="ridge">Ridge</option>
							<option value="inset">Inset</option>
							<option value="outset">Outset</option>
							<option value="none">None</option>
						</select>
						<label for="joonestiil">Joonestiili valik</label><br>
						<input type="color" name="piirjoonetoon" value=<?php echo $line_col; ?> >
						<label for="piirjoonetoon">Piirjoone v&auml;rvus</label><br>
						<input type="number" name="nurgasuurus" min="0" max="100" value=<?php echo $bor_ra; ?> >
						<label for="nurgasuurus">Piirjoone nurga raadius (0-100px)</label><br>				
					</fieldset>
					<input type="submit" value="Sisesta tekst!"/>
				</form>				
			</div>
		</div>
	</body>
</html>
