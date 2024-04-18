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
<link rel="stylesheet" href="css/loginStyle.css">
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
<div class="loginForm">
<?php
session_start();
function disMsg($sN,$n){
	echo isset($_SESSION["$sN"]["$n"]) ? $_SESSION["$sN"]["$n"] : '';
}

?>
<form action="loginValidate.php" method="POST">
<h1>Sign In</h1>
	<div class="loginContent">  
    <label><b>Email</b></label><span class="errMsg"><?php disMsg('errorMsg','email');?> </span><br>
    <input type="text" placeholder="Enter Email" name="email" value="<?=isset($_SESSION["email"]) ? $_SESSION["email"] : '';?>"  required><br>
	
    <label><b>Password</b><span class="errMsg"> <?php disMsg('errorMsg','password');?></span></label><br>
    <input type="password" placeholder="Enter Password" name="password"  required><br>
	
    <span class="psw"><a href="forgotPsw.php">Forgot password?</a></span><br>    
    <input type="submit" name="login" value="Sign in">
	<div class="createAcc">
	<span>Don't have an account?</span><br>
	<a href="signup.php">Sign Up</a>
	</div>
    </div>
</form>
</div>
<?php
    unset($_SESSION['errorMsg']);
    unset($_SESSION["email"]);
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
</script>
</body>

</html>


