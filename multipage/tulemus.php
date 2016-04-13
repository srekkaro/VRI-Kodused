<?php
	ini_set("display errors",1);
	require_once('head.html');
	$gallery=array(
			array("pilt"=>"pildid/nameless1.jpg","alt"=>"nimetu 1"),
			array("pilt"=>"pildid/nameless2.jpg","alt"=>"nimetu 2"),
			array("pilt"=>"pildid/nameless3.jpg","alt"=>"nimetu 3"),
			array("pilt"=>"pildid/nameless4.jpg","alt"=>"nimetu 4"),
			array("pilt"=>"pildid/nameless5.jpg","alt"=>"nimetu 5"),
			array("pilt"=>"pildid/nameless6.jpg","alt"=>"nimetu 6"),
		);
	$c=count($gallery)+1;
	if (!empty($_GET)){
	if (!empty($_GET["pilt"]) && $_GET["pilt"] != '0' && $_GET["pilt"] <= $c) {
		$q = "Sinu valik oli pilt number: ".$_GET['pilt'].".";
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
<?php
	require_once('foot.html');
	?>
