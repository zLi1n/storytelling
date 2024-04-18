<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

$email="";
$logPassword="";
$logEmail="";
$errorSym='<span class="material-symbols-outlined">error</span>';
$logType="";
function disErr($n,$m){
	$errorSym='<span class="material-symbols-outlined">error</span>';
	$_SESSION['errorMsg']["$n"] = "$errorSym $m";
	header("location:login.php");
}

if(isset($_POST["login"])){
	if(!empty($_POST["email"])){
		$email=$_POST['email'];
		$sql="SELECT * FROM user WHERE email='$email';";
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result)>0) {
			while($row=mysqli_fetch_assoc($result)){
				$logEmail=$row['Email'];
				$logPassword=$row['Password'];
				$logType=$row['Type'];
				$_SESSION["email"] = $_POST["email"];
				//disErr("email","ok") ;
		}
		}else{
			disErr("email","Email doesn't exist") ;
		}
	}else{
		disErr("email","Email cannot be empty");
	}
	if(!empty($_POST["password"])){
		if(!empty($logEmail)){
			if($_POST["password"]==$logPassword){
				//disErr("password","ok");
				if($logType=='A'){
					$_SESSION['login']="2";
					header("location:adminProfile.php");
				}else{
					$_SESSION['login']="1";
					header("location:userProfile.php");
				}
				
				
			}else{
				disErr("password","Password not match");
			}
		}		
	}else{
		disErr("password","Password cannot be empty");
	}
}


mysqli_close($connection);
?>


