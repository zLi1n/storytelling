<?php
session_start();

$sgUsername="";
$sgDOB="";
$signature="";
$avatar="";

$errorSym='<span class="material-symbols-outlined">error</span>';
function disErr($n,$m){
	$errorSym='<span class="material-symbols-outlined">error</span>';
	$_SESSION['errorMsg']["$n"] = "$errorSym $m";
	header("location:editProfile.php");
}
function recordVal($x){
	$_SESSION['fromVal']["$x"] = $_POST["$x"];
}
function validateVar($var,$max,&$varName,$con,$err1,$err2,$err3){	
	$errorSym='<span class="material-symbols-outlined">error</span>';
	if(!empty($_POST["$var"])){
		if(strlen($_POST["$var"])<=$max){
			$_SESSION['fromVal']["$var"] = $_POST["$var"];
			if(preg_match($con, $_POST["$var"])){
				$varName=$_POST["$var"];
			}else{					
			$_SESSION['errorMsg']["$var"] = "$errorSym $err3";
			header("location:editProfile.php");
			}
		}else{		
		$_SESSION['errorMsg']["$var"] = "$errorSym $err2";
		header("location:editProfile.php");
		}
	}else{		
		$_SESSION['errorMsg']["$var"] = "$errorSym $err1";
		header("location:editProfile.php");
	}
}
if(isset($_POST["edit"])){

	validateVar('username',100 ,$sgUsername,'/^[a-zA-Z0-9!@#&*_+~-][a-zA-Z0-9!@#&*_+~\-\s]{0,99}$/','Username cannot be empty','Maximum 100 characters','Username must contain only letters, numbers, and !@#&*_+~-');
	
	validateVar('DOB', 255, $sgDOB, '/^\d{4}-\d{2}-\d{2}$/', 'DOB cannot be empty', 'DOB is too long', 'Invalid characters in DOB');
	
	if(!empty($_POST["signature"])){
		if(strlen($_POST["signature"])<= 200){
			$_SESSION['fromVal']["signature"] = $_POST["signature"];
			if(preg_match('/^[a-zA-Z0-9!@#&*_+~-][a-zA-Z0-9!@#&*_+~\-\s]{0,199}$/', $_POST["signature"])){
				$signature=$_POST["signature"];
			}else{					
			$_SESSION['errorMsg']["signature"] = "$errorSym Signature must contain only letters, numbers, and !@#&*_+~-";
			header("location:editProfile.php");
			}
		}else{		
			$_SESSION['errorMsg']["signature"] = "$errorSym Maximum 200 characters";
			header("location:editProfile.php");
		}
	}
	
	if(!empty($_POST["avatar"]))
		$avatar = $_POST["avatar"];
}

$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

if(!empty($sgUsername)&&!empty($sgDOB)){
$email = $_SESSION['email'];

$sql = "UPDATE User SET 
  Username = '$sgUsername', 
  DOB = '$sgDOB', 
  ".(empty($avatar) ? "" : "Avatar = '$avatar', ") . " 
  Signature = " . (empty($signature) ? "NULL" : "'$signature'") . "
WHERE Email = '$email'";

	$result = mysqli_query($connection, $sql);
	if ($result) {
		header("location:userProfile.php");
	}else{
		die ("Connection failed: ".mysqli_error());
		//header("location:signup.php");
	}

}

mysqli_close($connection);
?>
