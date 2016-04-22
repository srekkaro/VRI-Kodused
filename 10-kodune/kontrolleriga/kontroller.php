<?php
	ini_set("display alarms", 1);
	
	function lopeta_sessioon(){
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
 	 setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
}

	session_start();
	$gallery=array(
			array("pilt"=>"pildid/nameless1.jpg","alt"=>"nimetu 1"),
			array("pilt"=>"pildid/nameless2.jpg","alt"=>"nimetu 2"),
			array("pilt"=>"pildid/nameless3.jpg","alt"=>"nimetu 3"),
			array("pilt"=>"pildid/nameless4.jpg","alt"=>"nimetu 4"),
			array("pilt"=>"pildid/nameless5.jpg","alt"=>"nimetu 5"),
			array("pilt"=>"pildid/nameless6.jpg","alt"=>"nimetu 6"),
		);
	 	$mode="default";
	 	
	if (!empty($_GET['page'])){
		$mode=$_GET['page'];	
	}
	
 	require_once('head.html');
 		switch($mode) {

		case "galerii":
			include('galerii.php');
		break;
		case "vote":
			if (isset($_SESSION['votedfor'])) {
				include('tulemus.php');
			}
			else {
				include('vote.php');
		}
		break;
		case "tulemus":
			include('tulemus.php');	
		break;
		case "cancel":
			lopeta_sessioon();
			include('pealeht.php');
		break;
		default:
			include('pealeht.php');
		break;
	}
 	require_once('foot.html');
 	?>