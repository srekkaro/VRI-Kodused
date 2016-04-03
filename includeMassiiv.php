

<?php

	$koduloomad= array(
		array('loom'=>'koer', 'nimi'=>'Muki', 'vanus'=>'2 aastat', 'v2rv'=>'sinine', 'toit'=>'Chappy', 'omanik'=>'Gunnar', 'link'=>'https://jakmeedia.com/wp-content/uploads/2014/07/1486037_574501942620807_510514765_o.jpg'),
		array('loom'=>'kass', 'nimi'=>'Miisu', 'vanus'=>'7 kuud', 'v2rv'=>'roheline', 'toit'=>'Whiskas', 'omanik'=>'Gennadi', 'link'=>'https://jakmeedia.com/wp-content/uploads/2014/07/1486037_574501942620807_510514765_o.jpg'),
		array('loom'=>'lehm', 'nimi'=>'Milla', 'vanus'=>'5 aastat', 'v2rv'=>'valge', 'toit'=>'hein', 'omanik'=>'Elmar', 'link'=>'https://jakmeedia.com/wp-content/uploads/2014/07/1486037_574501942620807_510514765_o.jpg'),
		array('loom'=>'hamster', 'nimi'=>'Charlie', 'vanus'=>'3 aastat', 'v2rv'=>'oranz', 'toit'=>'P2hklid', 'omanik'=>'V2ike Ylo', 'link'=>'https://jakmeedia.com/wp-content/uploads/2014/07/1486037_574501942620807_510514765_o.jpg'),	
	);

	foreach($koduloomad as $muutuja) {
		
		include('dokument.html');
	}
	
?>