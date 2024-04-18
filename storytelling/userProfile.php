<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>
<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/headerFooterstyle.css">
<link rel="stylesheet" href="css/userProfileStyle.css">
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
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

$email = $_SESSION["email"];
$sql="SELECT * FROM user WHERE email='$email';";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0) {
	while($row=mysqli_fetch_assoc($result)){
		$username = $row['Username'];
		$DOB = $row['DOB'];
		$signature = $row['Signature'];
		$avatar = $row['Avatar'];
	}
}
$pathAvatar = "img/avatar/".$avatar;
mysqli_close($connection);
$dateObj = new DateTime($DOB);
$dateMonth = $dateObj->format("d-m");

?>
<div class="userDetail">
	<img src="<?=$pathAvatar?>" class="avatar">
	<div class="detail">
		<p><b>Username: </b><?=$username?></p>
		<p><b>Birthday: </b><?=$dateMonth?></p>
		<p><b>Signature: </b></p>
		<p class="signature"><?=$signature?></p>
	</div>
</div>
<form action="editProfile.php" method="POST">
	<button class="edit" type="submit" name="edit" value="Edit Profile"><i class="fa fa-edit"></i></i> Edit Profile</button>
</form>
<form action="logout.php" method="POST">
	<button class="logout" type="submit" name="logout" value="Log Out"><i class="fa fa-sign-out"></i></i> Logout</button> 
</form>
</div>
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


