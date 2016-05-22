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
				$p2ring="SELECT id, role FROM srekkaro_kylastajad WHERE username = '$kasutaja' AND passw = SHA1('$parool')";
				$result=mysqli_query($connection, $p2ring);
				if (mysqli_num_rows($result)>0){
					$rida=mysqli_fetch_assoc($result);
					$_SESSION['user']=$rida['id'];
					$_SESSION['roll']=$rida['role'];
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
		$loomade_p2ring="SELECT id, liik FROM srekkaro_loomaaed WHERE puur=$mitmes_puur";
		$tulemus2=mysqli_query($connection, $loomade_p2ring) or die ("Viga andmebaasis - ".mysqli_error($connection));
		while ($rida2 = mysqli_fetch_assoc($tulemus2)){
				$puurid[$rida['puur']][$rida2['id']]=$rida2['liik'];
			}
	}
	ksort($puurid);
/*
	?><pre><?php
	print_r($puurid);
	?></pre><?php
*/	
	include_once('views/puurid.html');
	
}

function hangi_loom($id) {
	global $connection;
	$leialoom="SELECT * FROM srekkaro_loomaaed WHERE id=$id";
	$tulemus3=mysqli_query($connection, $leialoom) or die ("Viga andmebaasis -".mysqli_error($connection));
	if (mysqli_num_rows($tulemus3)==0) {
		header("Location: ?page=loomad");	
	}
	else {
		return mysqli_fetch_assoc($tulemus3);
	}	
}

function lisa(){
	global $connection;
	$asukoht="";
	$roll="admin";
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");	
	}
	if ($_SESSION['roll']!=$roll){
		header("Location: ?page=loomad");	
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

function muuda(){
	global $connection;	
	$asukoht="";
	if (empty($_SESSION['user'])){
		header("Location: ?page=login");	
	}
	if ($_SESSION['roll']!="admin"){
		header("Location: ?page=loomad");	
	}
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		if ($_GET['id']=="") {
			header("Location: ?page=loomad");	
			}
		else {
			$loomaid=htmlspecialchars($_GET['id']);	
		}
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		if ($_POST['id']=="") {
			header("Location: ?page=loomad");	
			}
		else {
			$loomaid=htmlspecialchars($_POST['id']);	
		}
	}
	
	$loom=hangi_loom($loomaid);
	
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		$nimi=$loom['nimi'];
		$puur=$loom['puur'];
		$vanus=$loom['vanus'];
		include_once('views/editvorm.html');
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
				$nimi=mysqli_real_escape_string($connection, $_POST["nimi"]);
				$puur=mysqli_real_escape_string($connection, $_POST["puur"]);
				$vanus=mysqli_real_escape_string($connection, $_POST["vanus"]);
				$id=mysqli_real_escape_string($connection, $_POST["id"]);
				if (empty($errors)){
					$sql= "UPDATE srekkaro_loomaaed SET nimi='$nimi', vanus='$vanus', puur='$puur' WHERE id='$id'";
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
		if ($asukoht!=""){
			$nimi=mysqli_real_escape_string($connection, $_POST["nimi"]);
			$puur=mysqli_real_escape_string($connection, $_POST["puur"]);
			$vanus=mysqli_real_escape_string($connection, $_POST["vanus"]);
			$id=mysqli_real_escape_string($connection, $_POST["id"]);
			$tmp=explode(".", $asukoht);
			$tmp2=explode("/", $tmp[0]);
			$liik=end($tmp2);
			$liik=mysqli_real_escape_string($connection, $liik);	
			if (empty($errors)){
				$sql= "UPDATE srekkaro_loomaaed SET nimi='$nimi', vanus='$vanus', puur='$puur', liik='$liik' WHERE id='$id'";
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
	}
	include_once('views/editvorm.html');	
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