<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/headerFooterstyle.css">
<link rel="stylesheet" href="css/signupStyle.css">
</head>
<body class="homepage">

<div class="header" id="header">
</div>
<div class="topBtn" id="topBtn"> </div>
<div class="login">
<div class="bgStyleContainer">
  <div class="gridItem1">
  	<div class="bgCloud1"></div>
    <div class="bgCloud2"></div>
    <div class="bgCloud3"></div>
    <div class="bgCloud4"></div>
    <div class="bgCloud5"></div>
    <div class="bgCloud6"></div>
  </div>
  <div class="gridItem"></div>
  <div class="gridItem"></div>  
  <div class="gridItem4">
  	<div class="bgCloudCtn">
    	<div class="bgCloud7"></div>
    	<div class="bgCloud8"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud9"></div>
    	<div class="bgCloud10"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud11"></div>
        <div class="bgCloud12"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud13"></div>
    	<div class="bgCloud14"></div>
     </div>
  </div>
</div>
</div>
<div class="signupFormCtn">
<div class="signupForm">
<form action="signupValidate.php" method="POST">
<?php
session_start();
function disMsg($sN,$n){
	echo isset($_SESSION["$sN"]["$n"]) ? $_SESSION["$sN"]["$n"] : '';
}
function selectQ($n,$val){
	echo isset($_SESSION["fromVal"]["$n"]) ?($_SESSION['fromVal']["$n"]=="$val"? "selected" : ''): '';
}
?>
<h1>Sign Up</h1>
	<div class="signupContent">  
    <label>Full Name<span class="red">*</span></label><span class="errMsg"><?php disMsg('errorMsg','fullName');?> </span><br>
    <input type="text" placeholder="Enter Full Name" name="fullName" value="<?php disMsg('fromVal','fullName');?>" required><br>
	
    <label>Email<span class="red">*</span></label><span class="errMsg"><?php disMsg('errorMsg','email');?> </span><br>
    <input type="text" placeholder="Enter Email" name="email" value="<?php disMsg('fromVal','email');?>"  required><br>
		
    <label>Password<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','password');?></span></label><br>
    <input type="password" placeholder="Enter Password" name="password" value="<?php disMsg('fromVal','password');?>" required><br>	
	
    <label>Confirm Password<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','comPassword');?></span></label><br>
    <input type="password" placeholder="Retype Password" name="comPassword" value="<?php disMsg('fromVal','comPassword');?>" required><br>	
	
    <label>Username<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','username');?></span></label><br>
    <input type="text" placeholder="Enter Username" name="username" value="<?php disMsg('fromVal','username');?>" required><br>
	
    <label>Date of Birth<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','DOB');?></span></label><br>
    <input type="date" name="DOB" id="datePickerId" value="<?php disMsg('fromVal','DOB');?>" required><br>
	
	<label>Security Question<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','SQ1');?></span></label><br>
	<select name="SQ1" class="secQ">
		<option value="default">Select one</option>
		<option value="1a" <?php selectQ("SQ1","1a");?>>What is your mother’s maiden name?</option>
		<option value="1b" <?php selectQ("SQ1","1b");?>>What is your pet's name?</option>
		<option value="1c" <?php selectQ("SQ1","1c");?>>What is your favorite movie?</option>
		<option value="1d" <?php selectQ("SQ1","1d");?>>In what city were you born?</option>
		<option value="1e" <?php selectQ("SQ1","1e");?>>On what street did you grow up?</option>
		<option value="1f" <?php selectQ("SQ1","1f");?>>What is the name of your primary school?</option>
		</select></span>	
    <label>Answer of Security Question<span class="red">*</span><span class="errMsg"> <?php disMsg('errorMsg','SQ1ans');?></span></label><br>
    <input type="text" placeholder="Enter Answer" name="SQ1ans" value="<?php disMsg('fromVal','SQ1ans');?>" required><br>
	<span class="required"><span class="red">* required</span></span>
   
    <input type="submit" name="signup" value="Register">
	<div class="log">
	<span>Already have an account?</span><br>
	<a href="login.php">Sign In</a>
	</div>
    </div>	
		
		

</form>
</div></div>
<?php
    unset($_SESSION['errorMsg']);
    unset($_SESSION["fromVal"]);
?>

<footer class="footer" id="footer">
	
</footer>
<script src="js/navBar.js"></script>
<script>
<?php
	if (isset($_SESSION['login'])){
		if ($_SESSION['login'] == '1') {
            echo 'updateLoginLinkU();';
        } else if ($_SESSION['login'] == '2') {
            echo 'updateLoginLinkA();';
        }
	}
?>
var datePickerId = document.getElementById("datePickerId");
datePickerId.max = new Date().toLocaleDateString('fr-ca');
</script>
</body>

</html>


