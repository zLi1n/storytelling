<?php 
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add New Admin</title>
<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/headerFooterstyle.css">
<link rel="stylesheet" href="css/addAdmin.css">
</head>
<body class="homepage">
<div class="header" id="header"></div>
<div class="topBtn" id="topBtn"> </div>

 
   <div class="slidebar"> 
     <h1>Admin Panel</h1>
     <a href="adminProfile.php">Profile</a>
     <a href="addAdmin.php" class="active">Add New Admin</a>
     <a href="">Add Genre</a>
     <a href="">Add Theme</a>
     <a href="">Statistical Analysis</a>
     <a href="">Reported Content</a>
   </div>

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

<div class="loginForm">
<div class="btnContainer">
<form action="editProfile.php" method="POST">
	<button class="edit" type="submit" name="edit" value="Edit Profile"><i class="fa fa-plus"></i></i> Add New Admin</button>
</form>
</div>
<div class="userDetail">
<table class="detail">
<tr>
	<th>Email</th>
	<th>Username</th>
	<th>Name</th>
	<th>Birthday</th>
	<th>Register Date</th>
	<th>Remove</th>
</tr>
<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

$email = $_SESSION["email"];
$sql="SELECT Email, Username, Name, DOB, RegistrationDate FROM user WHERE Type = 'A' ORDER BY RegistrationDate ASC;";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result)>0) {
	while($row=mysqli_fetch_assoc($result)){
		$username = $row['Username'];
		$DOB = $row['DOB'];
		$email = $row['Email'];
		$name = $row['Name'];
		$register = $row['RegistrationDate'];
		?>
		
	
	<tr>
		<td><?=$email?></td>
		<td><?=$username?></td>
		<td><?=$name?></td>
		<td><?=$DOB?></td>
		<td><?=$register?></td>
		<td class="remove">
		<form id="<?=$email?>" action="#" onsubmit="event.preventDefault();"><button class="removeBtn" onclick="confirmRemove(<?=$email?>)"><i class="fa fa-minus-circle"></i></button>
		<input type="hidden" name="remove" value="<?=$email?>">
		</form></td>
	</tr>
	<script>
	function confirmRemove(email) {
  if (confirm("Are you sure to remove this account (" + email + ")?")) {
    document.getElementById(email).submit();
  } else {
    
  }
}
	</script>
	
		<?php
		
	}
}
mysqli_close($connection);

?>
	
</table>
</div>
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

