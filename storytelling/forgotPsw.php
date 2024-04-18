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
<link rel="stylesheet" href="css/forgotPswStyle.css">
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
<div class="forgotPswForm">
<?php
session_start();
function disMsg($sN,$n){
	echo isset($_SESSION["$sN"]["$n"]) ? $_SESSION["$sN"]["$n"] : '';
}
function selectQ($n,$val){
	echo isset($_SESSION["fromVal"]["$n"]) ?($_SESSION['fromVal']["$n"]=="$val"? "selected" : ''): '';
}
?>
<form action="forgotPswValidate.php" method="POST">
<a href="login.php" class="back"><span class="material-symbols-outlined">arrow_back</span></a>
<h1>Forgot Password</h1>
	<div class="forgotPswContent">  
    <label>Email*</label><span class="errMsg"><?php disMsg('errorMsg','email');?> </span><br>
    <input type="text" placeholder="Enter Email" name="email" value="<?=isset($_SESSION["email"]) ? $_SESSION["email"] : '';?>"  required><br>
	
	<label>Security Question*<span class="errMsg"> <?php disMsg('errorMsg','SQ1');?></span></label><br>
	<select name="SQ1" class="secQ">
		<option value="default">Select one</option>
		<option value="1a" <?php selectQ("SQ1","1a");?>>What is your mother’s maiden name?</option>
		<option value="1b" <?php selectQ("SQ1","1b");?>>What is your pet's name?</option>
		<option value="1c" <?php selectQ("SQ1","1c");?>>What is your favorite movie?</option>
		<option value="1d" <?php selectQ("SQ1","1d");?>>In what city were you born?</option>
		<option value="1e" <?php selectQ("SQ1","1e");?>>On what street did you grow up?</option>
		<option value="1f" <?php selectQ("SQ1","1f");?>>What is the name of your primary school?</option>
		</select></span>	<br>
    <label>Answer of Security Question*<span class="errMsg"> <?php disMsg('errorMsg','SQ1ans');?></span></label><br>
    <input type="text" placeholder="Enter Answer" name="SQ1ans" value="<?php disMsg('fromVal','SQ1ans');?>" required><br>
	<span class="required">* required</span>
		<input type="submit" class="submitBtn" value="Submit" name="rePassword">
	</div>
    
</form>
</div>
<?php
    unset($_SESSION['errorMsg']);
    unset($_SESSION["fromVal"]);
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


