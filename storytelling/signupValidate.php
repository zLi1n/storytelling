<?php
session_start();

$sgFullName="";
$sgPassword="";
$sgComPassword="";
$sgEmail="";
$sgUsername="";
$sgDOB="";
$sgSQ1="";
$sgSQ1ans="";

$_SESSION['fromVal']['count']=0;
$errorSym='<span class="material-symbols-outlined">error</span>';
function disErr($n,$m){
	$errorSym='<span class="material-symbols-outlined">error</span>';
	$_SESSION['errorMsg']["$n"] = "$errorSym $m";
	header("location:signup.php");
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
				$_SESSION['fromVal']['count']+=1;
			}else{					
			$_SESSION['errorMsg']["$var"] = "$errorSym $err3";
			header("location:signup.php");
			}
		}else{		
		$_SESSION['errorMsg']["$var"] = "$errorSym $err2";
		header("location:signup.php");
		}
	}else{		
		$_SESSION['errorMsg']["$var"] = "$errorSym $err1";
		header("location:signup.php");
	}
}
if(isset($_POST["signup"])){
	validateVar('fullName',100 ,$sgFullName,'/^[a-zA-Z ]{1,100}$/','Name cannot be empty','Maximum 100 characters','Name must contain only characters');
	
	validateVar('email',150 ,$sgEmail,'/^[a-zA-Z0-9\.-_]{1,100}@[a-zA-Z]{3,40}\.com$/','Email cannot be empty','Maximum 150 characters','Invalid email address');	
	
	if(!empty($_POST["password"])){	
		if(strlen($_POST["password"])<20){	
			if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,20}$/", $_POST["password"])) {
				$sgPassword=$_POST["password"];
				$_SESSION['fromVal']['count']+=1;
				recordVal("password");	if(!empty($_POST["comPassword"])){		
		if($_POST["comPassword"]==$_POST["password"]){
			$sgComPassword=$_POST["comPassword"];
			$_SESSION['fromVal']['count']+=1;
			recordVal("comPassword");
		}else{
			disErr('comPassword','Comfirm password must be same as password');
		}
	}else{
		disErr('comPassword','Please re-type your password');
	}
			}else{
				disErr('password','Minimum 8 characters, at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character');
			}
		}else{
		disErr('password','Maximum 20 characters');
		}
	}else{
		disErr('password','Password cannot be empty');
	}
	

	
	validateVar('username',100 ,$sgUsername,'/^[a-zA-Z0-9!@#&*_+~-][a-zA-Z0-9!@#&*_+~\-\s]{0,99}$/','Username cannot be empty','Maximum 100 characters','Username must contain only letters, numbers, and !@#&*_+~-');
	
	validateVar('DOB', 255, $sgDOB, '/^\d{4}-\d{2}-\d{2}$/', 'DOB cannot be empty', 'DOB is too long', 'Invalid characters in DOB');
	
	if($_POST["SQ1"]!="default"){
		$sgSQ1=$_POST["SQ1"];
		$_SESSION['fromVal']['count']+=1;
		recordVal("SQ1");
		validateVar('SQ1ans',200 ,$sgSQ1ans,'/^[a-zA-Z0-9\. ]{1,200}$/','Answer cannot be empty','Maximum 200 characters','Answer must contain only characters');
	}else{
		disErr('SQ1','Please select one question');
	}
	
	
	
}

$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

if($_SESSION['fromVal']['count']==8){
date_default_timezone_set("Asia/Kuala_Lumpur");
$currentDate = date("Y-m-d");
$avatar = "avatar.jpg";
$sql="INSERT INTO User (Email, Username, Name, DOB, Password, Avatar, Signature, RegistrationDate, Type, SecurityQuestion, SecurityQuestionAns) VALUES ('$sgEmail', '$sgUsername', '$sgFullName', '$sgDOB', '$sgComPassword', '$avatar', NULL, '$currentDate', 'U', '$sgSQ1', '$sgSQ1ans')";

$ckuser="SELECT * FROM user WHERE email='$sgEmail';";

$ckuserResult = mysqli_query($connection, $ckuser);
if (mysqli_num_rows($ckuserResult)>0) {
	$_SESSION['errorMsg']['email'] = "$errorSym Email already exist. Please enter another email.";
	header("location:signup.php");
	
}else{
	$result = mysqli_query($connection, $sql);
	if ($result) {
		header("location:signupSuccess.php");
	}else{
		die ("Connection failed: ".mysqli_error());
		//header("location:signup.php");
	}
}
}

mysqli_close($connection);
?>
