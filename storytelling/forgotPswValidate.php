<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}
$email="";
$fpEmail="";
$fpSQ1="";
$fpSQ1ans="";
$errorSym='<span class="material-symbols-outlined">error</span>';
$count=0;
function disErr($n,$m){
	$errorSym='<span class="material-symbols-outlined">error</span>';
	$_SESSION['errorMsg']["$n"] = "$errorSym $m";
	header("location:forgotPsw.php");
}
function recordVal($x){
	$_SESSION['fromVal']["$x"] = $_POST["$x"];
}
if(isset($_POST["rePassword"])){
	if(!empty($_POST["email"])){
		$email=$_POST['email'];
		$sql="SELECT * FROM user WHERE email='$email';";
		//fire the query
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result)>0) {
			while($row=mysqli_fetch_assoc($result)){
				$fpEmail=$row['Email'];
				$fpSQ1=$row['SecurityQuestion'];
				$fpSQ1ans=$row['SecurityQuestionAns'];
				recordVal("email");
				$_SESSION['email']=$_POST['email'];
				$count+=1;
			}
		}else{
			disErr("email","Email doesn't exist") ;
		}
	}else{
		disErr("email","Email cannot be empty");
	}
	if($_POST["SQ1"]!="default"){
		if(!empty($fpSQ1)){
			recordVal("SQ1");
			if($_POST["SQ1"]==$fpSQ1){
				$count+=1;	
				if(!empty($_POST["SQ1ans"])){
					recordVal("SQ1ans");
					if(!empty($fpSQ1ans)){
						if($_POST["SQ1ans"]==$fpSQ1ans){
							$count+=1;
						}else{
							disErr("SQ1ans","Answer not match");
						}
					}		
				}else{
					disErr("SQ1ans","Answer cannot be empty");
				}				
				
			}else{
				disErr('SQ1','Invalid security question selected');
			}
		}else{
			disErr('SQ1','Please enter your email before selecting a question');
		}
	}else{
		disErr('SQ1','Please select one question');
	}
	
	if($count==3){
		header("location:forgotPswChange.php");
	}
}


mysqli_close($connection);
?>