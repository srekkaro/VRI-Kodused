<?php
	$c=count($gallery)+1;
	if (isset($_SESSION['votedfor'])) {
		$q = "Oled juba oma valiku teinud, sinu valik oli: ".$_SESSION['votedfor'];
	}
	elseif (!empty($_POST)){
		if (!empty($_POST["pilt"]) && $_POST["pilt"] != '0' && $_POST["pilt"] <= $c) {
			$q = "Sinu valik oli pilt number: ".$_POST['pilt'].".";
			$_SESSION['votedfor']=$_POST['pilt'];
			}
		else {
			$q="Sinu valitud pilti ei eksisteeri!";	
		} 
	}
	else {
		$q="Palun vali pilt!";
	}
?>
	
	<h3>Valiku tulemus</h3>
	<p><?php echo $q; ?></p>
