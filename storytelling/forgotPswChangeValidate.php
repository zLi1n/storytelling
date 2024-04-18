<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}
$email="";
$fgPassword="";
$fgComPassword="";
$count=0;
$errorSym='<span class="material-symbols-outlined">error</span>';
function disErr($n,$m){
	$errorSym='<span class="material-symbols-outlined">error</span>';
	$_SESSION['errorMsg']["$n"] = "$errorSym $m";
	header("location:forgotPswChange.php");
}
function recordVal($x){
	$_SESSION['fromVal']["$x"] = $_POST["$x"];
}
if(isset($_POST["rePassword"])){
	if(!empty($_POST["email"])){
		$email=$_POST['email'];
		
	}else{
		disErr("email","Email cannot be empty");
	}
	if(!empty($_POST["newPassword"])){	
		if(strlen($_POST["newPassword"])<20){	
			if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,20}$/", $_POST["newPassword"])) {
				$fgPassword=$_POST["newPassword"];
				recordVal("newPassword");
				$count+=1;
				if(!empty($_POST["comPassword"])){		
					if($_POST["comPassword"]==$_POST["newPassword"]){
						$fgComPassword=$_POST["comPassword"];
						$count+=1;
					}else{
						disErr('comPassword','Comfirm password must be same as password');
					}
				}else{
					disErr('comPassword','Please re-type your password');
				}
			}else{
				disErr('newPassword','Minimum 8 characters, at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character');
			}
		}else{
		disErr('newPassword','Maximum 20 characters');
		}
	}else{
		disErr('newPassword','Password cannot be empty');
	}
	
	
}
//update user table
if($count==2){
	$sql="UPDATE user SET password ='$fgComPassword' WHERE email = '$email';";

	$result = mysqli_query($connection, $sql);
	if ($result) {
		header("location:forgotPswChangeSuccess.php");
	}else{
		die ("Password changed failed: ".mysqli_error());
	}
}


mysqli_close($connection);
?>

