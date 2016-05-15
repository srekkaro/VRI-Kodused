<?php
$errors=array();

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
	global $connection;
	global $errors;
	if (!empty($_SESSION['user'])){
		header("Location: ?page=loomad");	
	}
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		include_once('views/login.html');
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		if (empty($_POST["user"])){
			$errors[]= "Kasutajaväli ei saa olla tühi!";
		}
		if (empty($_POST["pass"])){
			$errors[]="Parool ei saa olla tühi!";
		}
		if (!empty($errors)){
				include_once('views/login.html');
				}
		}
		if (!empty($_POST)){
				$kasutaja= mysqli_real_escape_string($connection, $_POST["user"]);
				$parool= mysqli_real_escape_string($connection, $_POST["pass"]);
				$p2ring="SELECT id FROM srekkaro_kylastajad WHERE username = '$kasutaja' AND passw = SHA1('$parool')";
				$result=mysqli_query($connection, $p2ring);
				if (mysqli_num_rows($result)>0){
					$_SESSION['user']=$p2ring['id'];
					header("Location: ?page=loomad");
				}
				if (mysqli_num_rows($result)==0){
				$errors[]= "Sellist kasutajat ei leitud!";
				include_once('views/login.html');
			}
		}
	}


function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function kuva_puurid(){
	global $connection;
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");	
	}
	$puurid=array();
	$puuride_numbrid="SELECT DISTINCT puur FROM srekkaro_loomaaed";

	$tulemus= mysqli_query($connection, $puuride_numbrid) or die ("Viga andmebaasis - ".mysqli_error($connection));
	while ($rida = mysqli_fetch_assoc($tulemus)){
		$mitmes_puur=$rida['puur'];
		$loomade_p2ring="SELECT liik FROM srekkaro_loomaaed WHERE puur=$mitmes_puur";
		$tulemus2=mysqli_query($connection, $loomade_p2ring) or die ("Viga andmebaasis - ".mysqli_error($connection));
		while ($rida2 = mysqli_fetch_assoc($tulemus2)){
				$puurid[$rida['puur']][]=$rida2['liik'];
			}
	}
	ksort($puurid);
/*	?><pre><?php
	print_r($puurid);
	?></pre><?php
*/
	include_once('views/puurid.html');
	
}

function lisa(){
	global $connection;
	$asukoht="";
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");	
	}
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		include_once('views/loomavorm.html');
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		if (empty($_POST["nimi"])){
			$errors[]= "Loomal peab olema nimi!";
		}
		if (empty($_POST["puur"])){
			$errors[]="Loomal peab olema puur!";
		}
		if (!empty($_FILES['pilt']['name'])){
			$asukoht=upload('pilt');
		}
		if ($asukoht==""){
				$errors[]="Loomal peab olema liik/pilt!";
			}
		$nimi=mysqli_real_escape_string($connection, $_POST["nimi"]);
		$puur=mysqli_real_escape_string($connection, $_POST["puur"]);
		$vanus=mysqli_real_escape_string($connection, $_POST["vanus"]);
		$tmp=explode(".", $asukoht);
		$tmp2=explode("/", $tmp[0]);
		$liik=end($tmp2);
		$liik=mysqli_real_escape_string($connection, $liik);	
		if (empty($errors)){
				$sql= "INSERT INTO srekkaro_loomaaed ( nimi, vanus, puur, liik) VALUES ('$nimi', '$vanus', '$puur', '$liik')";
				$tulemus=mysqli_query($connection, $sql);
				$viga= mysqli_error($connection);
				print_r($viga);	
					if ($tulemus){
						if(mysqli_affected_rows($connection)>0){
							header("Location: ?page=loomad");
						}
					}
				}
			
	}
	
	include_once('views/loomavorm.html');
	
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$ajutine = explode(".", $_FILES[$name]["name"]);
	$extension = end($ajutine);

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>