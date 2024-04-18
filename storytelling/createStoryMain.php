<?php 
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Create Story</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/cRMainStyle.css">
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		
		<h1 class="createStoryHd">Begin Your Storytelling Journey!</h1>	
		<div class="cSHdDesignT">
			<div class="cSHdDesignT1"></div>
			<div class="cSHdDesignT2"></div>
			<div class="cSHdDesignT3"></div>
			<div class="cSHdDesignT4"></div>
			<div class="cSHdDesignT5"></div>
			<div class="cSHdDesignT6"></div>
			<div class="cSHdDesignT7"></div>
			<div class="cSHdDesignT8"></div>
			<div class="cSHdDesignT9"></div>
			<div class="cSHdDesignT10"></div>
			<div class="cSHdDesignT11"></div>
			<div class="cSHdDesignT12"></div>	
		</div>
		<div class="cSHdDesignM">
			<div class="cSHdDesignM1"></div>
			<div class="cSHdDesignM2"></div>
			<div class="cSHdDesignM3"></div>
			<div class="cSHdDesignM4"></div>
			<div class="cSHdDesignM5"></div>
			<div class="cSHdDesignM6"></div>
			<div class="cSHdDesignM7"></div>
			<div class="cSHdDesignM8"></div>
			<div class="cSHdDesignM9"></div>
			<div class="cSHdDesignM10"></div>
			<div class="cSHdDesignM11"></div>
			<div class="cSHdDesignM12"></div>	
		</div>
		<a href="createStoryCat.php" class="cSBtn">Craft Your Own Tale</a>
		<div class="cSHdDesignB">
			<div class="cSHdDesignB1"></div>
			<div class="cSHdDesignB2"></div>
			<div class="cSHdDesignB3"></div>
			<div class="cSHdDesignB4"></div>
			<div class="cSHdDesignB5"></div>
			<div class="cSHdDesignB6"></div>
			<div class="cSHdDesignB7"></div>
			<div class="cSHdDesignB8"></div>
			<div class="cSHdDesignB9"></div>
			<div class="cSHdDesignB10"></div>
			<div class="cSHdDesignB11"></div>
			<div class="cSHdDesignB12"></div>	
		</div>
		<div class="cSHdDesignBD">
			<div class="cSHdDesignBD1"></div>
			<div class="cSHdDesignBD2"></div>
			<div class="cSHdDesignBD3"></div>
			<div class="cSHdDesignBD4"></div>
			<div class="cSHdDesignBD5"></div>
			<div class="cSHdDesignBD6"></div>
			<div class="cSHdDesignBD7"></div>
			<div class="cSHdDesignBD8"></div>
			<div class="cSHdDesignBD9"></div>
			<div class="cSHdDesignBD10"></div>
			<div class="cSHdDesignBD11"></div>
			<div class="cSHdDesignBD12"></div>	
		</div>
		

<?php
if (isset($_SESSION['inviteMessage']['publish'])) {
    echo '<script>alert("Your chapter is published!");</script>';
    unset($_SESSION['inviteMessage']);
}
$connection = mysqli_connect("localhost", "root", "", "storytelling");

if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
$email = $_SESSION["email"];
$query = "SELECT * FROM Story WHERE Email = '$email' ORDER BY DateTime DESC";
$result = mysqli_query($connection, $query);
$count = mysqli_num_rows($result);
?>
		<div class="myBookShelf">
			<h3>My Book Shelf (<?=$count?>)</h3>
				<div class="bookShelf">
<?php
if (mysqli_num_rows($result)>0) {
	
	while($row=mysqli_fetch_assoc($result)){
		$storyID = $row["StoryID"];
		$storyTitle = $row["Title"];
		$coverPage = $row["CoverPage"];
		if ($row["Access"] == 'PUB')
			$access = "Public";
		else if ($row["Access"] == 'PVT')
			$access = "Private";		
		$chapQuery = "SELECT * FROM chapter WHERE StoryID = $storyID ORDER BY DateTime DESC LIMIT 1;";
		$chapResult = mysqli_query($connection, $chapQuery);
		$chapData = mysqli_fetch_assoc($chapResult);
		$chapID = $chapData["ChapterID"];		
		$chapName = $chapData["ChapterName"];
		if ($chapData["Status"] == 'D')
			$status = "Draf";
		else if ($chapData["Status"] == 'P')
			$status = "Published";
		echo	'<div class="book">
					<img src="img/coverPage/'.$coverPage.'">';
		if($access === "Public"){
			if($status === "Published"){
				echo '<form method="post" action="storyDetail.php">
						<input class="ttl" type="submit" name="read" value="'.$storyTitle.'">
						<input type="hidden" name="bookID" value="'.$storyID.'">
						<input type="hidden" name="createStory" value="'.$storyID.'">
					</form>';
			}else if($status === "Draf"){
				echo '<form method="post" action="createStoryContent.php">
						<input class="ttl" type="submit" name="read" value="'.$storyTitle.'">
						<input type="hidden" name="chapterID" value="'.$chapID.'">
					</form>';
			}
		}else if($access === "Private"){
			echo			'<form method="post" action="addChapter.php">
						<input class="ttl" type="submit" name="read" value="'.$storyTitle.'">
						<input type="hidden" name="bookID" value="'.$storyID.'">
						<input type="hidden" name="createStory" value="'.$storyID.'">
					</form>';
		}
		echo			'<p class="detail">'.$chapName.'</p>
					<p class="'.$status.'">'.$status.'</p>
					<p class="'.$access.'">'.$access.'</p>
				</div>';
		
	}
}
?>

				</div>
			</div>
<?php
$query = "SELECT * FROM Invitation WHERE ReceiverEmail = '$email' ORDER BY InvitationID DESC";
$result = mysqli_query($connection, $query);
$count = mysqli_num_rows($result);
?>
			<div class="myBookShelf">
			<h3>Collaborate Book Shelf (<?=$count?>)</h3>
				<div class="bookShelf">
<?php
if (mysqli_num_rows($result)>0) {
	
	while($row=mysqli_fetch_assoc($result)){
		$chapterID = $row["ChapterID"];
		$link = $row["Link"];
		$chapQuery = "SELECT c.*, s.Title, s.CoverPage, s.Access FROM chapter c, story s WHERE s.StoryID = c.StoryID AND c.ChapterID = $chapterID;";
		$chapResult = mysqli_query($connection, $chapQuery);
		$chapData = mysqli_fetch_assoc($chapResult);
		$chapName = $chapData["ChapterName"];
		$coverPage = $chapData["CoverPage"];
		$storyTitle = $chapData["Title"];
		if ($chapData["Access"] == 'PUB')
			$access = "Public";
		else if ($chapData["Access"] == 'PVT')
			$access = "Private";
		if ($chapData["Status"] == 'D')
			$status = "Draf";
		else if ($chapData["Status"] == 'P')
			$status = "Published";
		echo	'<div class="book">
					<img src="img/coverPage/'.$coverPage.'">
					<form method="post" action="createStoryContent.php#'.$link.'" id="naviForm">
						<input class="ttl" type="submit" name="submit" value="'.$chapName.'">
						<input type="hidden" name="chapterID" value="'.$chapterID.'">
					</form>
					<p class="detail">'.$storyTitle.'</p>
					<p class="'.$status.'">'.$status.'</p>
					<p class="'.$access.'">'.$access.'</p>
				</div>';
		
	}
}
?>
		
				
				</div>
			</div>
<?php
$query = "SELECT c.*, s.Title, s.CoverPage, s.Access FROM chapter c, story s WHERE c.StoryID = s.StoryID AND s.Access = 'PUB' AND c.Email = '$email' ORDER BY c.DateTime DESC";
$result = mysqli_query($connection, $query);
$count = mysqli_num_rows($result);
?>
			<div class="myBookShelf">
			<h3>My Contribution Book Shelf (<?=$count?>)</h3>
				<div class="bookShelf">
<?php
if (mysqli_num_rows($result)>0) {
	
	while($row=mysqli_fetch_assoc($result)){
		$chapterID = $row["ChapterID"];

		$chapName = $row["ChapterName"];
		$coverPage = $row["CoverPage"];
		$storyTitle = $row["Title"];
		if ($chapData["Access"] == 'PUB')
			$access = "Public";
		else if ($chapData["Access"] == 'PVT')
			$access = "Private";
		if ($chapData["Status"] == 'D')
			$status = "Draf";
		else if ($chapData["Status"] == 'P')
			$status = "Published";
		echo	'<div class="book">
					<img src="img/coverPage/'.$coverPage.'">
					<form method="post" action="createStoryContent.php" id="naviForm">
						<input class="ttl" type="submit" name="submit" value="'.$chapName.'">
						<input type="hidden" name="chapterID" value="'.$chapterID.'">
					</form>
					<p class="detail">'.$storyTitle.'</p>
					<p class="'.$status.'">'.$status.'</p>
					<p class="'.$access.'">'.$access.'</p>
				</div>';
		
	}
}
?>
		
				
				</div>
			</div>		
		<footer class="footer" id="footer">
			
		</footer>
	
	<script src="js/navBar.js"></script>
	<script>
	<?php
	mysqli_close($connection);	
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

