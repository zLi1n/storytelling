<!DOCTYPE html>
<html lang="en">
<head>
<title>Thank You Signing Up</title>
<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/headerFooterstyle.css">
<link rel="stylesheet" href="css/signupSuccessStyle.css">
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
<div class="tq">
<div class="tqContent">
<p class="check">
<span class="material-symbols-outlined" id="check">verified</span>
</p>
<h1>Thank you for signing up! </h1>
<p>Your registration is complete.</p>
<div class="btn">
<button onclick="Redirect()">Login (<span id="sec"></span>)</button>
</div>
</div>
</div>
<script>
	function Redirect(){
		window.location="login.php";
	}
	function countDown(){
		document.getElementById('sec').innerHTML=2;
	}
	function countDown1(){
		document.getElementById('sec').innerHTML=1;
	}
	function autoRedirect(){
		document.getElementById('sec').innerHTML=3;
		setTimeout(countDown, 1000);
		setTimeout(countDown1, 2000);
		setTimeout(Redirect, 3000);
	}
	autoRedirect();
</script>
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
</script>
</body>

</html>


