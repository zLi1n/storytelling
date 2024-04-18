<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Read Story</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/addChapterStyle.css">
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		<div class="backArr">
		<a href="createStoryMain.php"><span class="material-symbols-outlined">arrow_back</span></a>
		</div>
		

    
    
<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
	
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
//session_start();
if (isset($_REQUEST['read'])){
	//echo $_REQUEST['bookID'];
	$storySql = "SELECT * FROM story WHERE StoryID='".$_REQUEST['bookID']."'";
	$storyRun = mysqli_query($connection, $storySql);
	$storyData = mysqli_fetch_assoc($storyRun);
/*image*/
	echo "<div class='container'>
	<div class='dtlContainer'>
		<div class='imgCtn'> 
		<img src='img/coverPage/".$storyData['CoverPage']."' alt='Cover Image' class='coverImg'>
		</div>
		<div class='dtlCtn'>
		<div calss='detail'>
		<div class='storyTtl'>".$storyData['Title']."</div>";
/*genre*/
		$genreID = $storyData['GenreID'];
		$genreQuery = "SELECT GenreDetail FROM Genre WHERE GenreID = $genreID";
		$genreResult = mysqli_query($connection, $genreQuery);
		$genreData = mysqli_fetch_assoc($genreResult);
		$genreDetail = $genreData['GenreDetail'];
		echo '<div class="themeDetail"> ' . $genreDetail . '</div>';
/*theme*/
		$themeID = $storyData['ThemeID'];
		$themeQuery = "SELECT ThemeDetail FROM Theme WHERE ThemeID = $themeID";
		$themeResult = mysqli_query($connection, $themeQuery);
		$themeData = mysqli_fetch_assoc($themeResult);
		$themeDetail = $themeData['ThemeDetail'];
		echo '<div class="themeDetail">' . $themeDetail . '</div>';
		
/*status*/		
		echo '<div class="statusDetail">';
		$storyStatus = $storyData['Status'];
		if ($storyStatus =='F'){
			echo 'Finished';
		}else if($storyStatus=='O'){
			echo 'Ongoing';
		}
		echo '</div><br>';
/*author*/		
		$email = $storyData['Email'];
		$access = $storyData['Access'];
		if ($access == 'PVT') {
			$authorQuery = "SELECT Username FROM User WHERE Email = '$email'";
			$authorResult = mysqli_query($connection, $authorQuery);
			$authorData = mysqli_fetch_assoc($authorResult);
			$author = $authorData['Username'];
			echo '<p class="authorTxt"><strong>Author:</strong> ' . $author . '<br>';
		}else
			echo '<p class="authorTxt"><strong>Author:</strong> Multiple</p><br>';
		echo '</div>';
/*add btn*/		
		$storyID = $storyData['StoryID'];
		$firstChapterQuery = "SELECT ChapterID FROM Chapter WHERE StoryID = ".$storyID." ORDER BY DateTime DESC LIMIT 1";
		$firstChapterResult = mysqli_query($connection, $firstChapterQuery);
		$latesChapterData = mysqli_fetch_assoc($firstChapterResult);
		$latesChapter = $latesChapterData['ChapterID'];
		
?>
<form class="storyCatForm" action="addChapterValidate.php" method="POST">
				<p class="instruction"><b>Select story status</b></p>
				<div class="storyCat">
						<div class="storyCatPblRadio">
							<input type="radio" name="storyStatus" value="O" class="radioCustom" required <?=$storyStatus == "O"?"checked":""?>> 
							Ongoing
						</div>
						<div class="storyCatPblRadio">
							<input type="radio" name="storyStatus" value="F" class="radioCustom" required <?=$storyStatus == "O"?"":"checked"?>> 
							Finished
						</div>
						<input type="hidden" name="bookID" value="<?=$storyID?>">
					<button class="btn" type="submit" name="confirmStatus" value="Confirm"><i class="fa fa-check-circle"></i> Confirm</button>
				</div>
						
			</form>
	<div>
	<div class="btnCtn">

    
<?php		
if($storyStatus == "O"){
echo '<form action="addChapterValidate.php" method="POST">
		<input type="submit" class="actionBtn" name="addChapter" value="Add New Chapter">
		<input type="hidden" name="chapBeforeID" value="' . $latesChapter . '">
		<input type="hidden" name="bookID" value="'.$storyID.'">
		</form>';
}
?>
</div>
<div id="timeLeft"></div>
<?php
	echo "</div></div>
	</div>

	<div class = 'chapContainer'>";
/*chapter*/
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$sql="SELECT * FROM Chapter WHERE StoryID = $storyID";
	$result = mysqli_query($connection, $sql);
	
	if ($access == 'PVT') {
		$chapterQuery = "SELECT * FROM Chapter WHERE StoryID = $storyID ORDER BY DateTime ASC";
		$chapterResult = mysqli_query($connection, $chapterQuery);
		
		while ($chapterData = mysqli_fetch_array($chapterResult)) {
			$chapters[] = $chapterData;
		}

		echo '<p class="chapTxt"><strong>Chapters (' . count($chapters) . ')</strong></p>
		<div class="chaptersCtn">';
		
		foreach ($chapters as $chapterData) {
			echo "<form action='createStoryContent.php' method='POST'>
					<input type='submit' name='editChapter' value='" . $chapterData['ChapterName'] . "'>
					<input type='hidden' name='chapterID' value='" . $chapterData['ChapterID'] . "'>
				  </form>";
		}
		echo "</div>
		</div>
		</div>";
		$chapterID = array_column($chapters, 'ChapterID');
	}
	
	$commaChapterID = implode(', ', $chapterID);
	$commentQuery = "SELECT * FROM Comment WHERE ChapterID IN($commaChapterID) ORDER BY DateTime DESC";
	$commentResult = mysqli_query($connection, $commentQuery);
	$comments = [];
	while ($commentData = mysqli_fetch_array($commentResult)) {
		$comments[] = $commentData;
	}

	echo "<div class='commentContainer'>
	<p class='chapTxt'><strong>Comments (" . count($comments) . ")</strong></p>
	";
	
	foreach ($comments as $commentData) {
		//echo $commentData['CommentID']."<br>".$commentData['CommentText']."<br>".$commentData['Email']."<br>".$commentData['DateTime']."<br>";
		echo "<div class='commentCtn'>
		<div class='commentAvatar'>";
		$avatarQuery = "SELECT u.* FROM Comment co, User u WHERE co.Email = u.Email AND co.Email ='".$commentData['Email']."'";
		$avatarResult = mysqli_query($connection, $avatarQuery);
		$avatarData = mysqli_fetch_assoc($avatarResult);
		$avatarImg = $avatarData['Avatar'];
		echo "<img src='img/avatar/".$avatarImg."' class='avatar'>";
		echo "</div>
		<div class='commentTxt'>";
		$commentChapQuery = "SELECT c.* FROM Comment co, Chapter c WHERE co.ChapterID = c.ChapterID AND co.ChapterID ='".$commentData['ChapterID']."'";
		$commentChapResult = mysqli_query($connection, $commentChapQuery);
		$commentChapData = mysqli_fetch_assoc($commentChapResult);
		$commentChapName = $commentChapData['ChapterName'];
		echo "<a href='' class='reportCtn'><span class='material-symbols-outlined'>report</span>Report</a>";
		echo "<p class='username'>".$avatarData['Username']."</p>";
		echo "<p class='commentDtl'>".$commentChapName." ".$commentData['DateTime']."</p>";
		echo "<p class='commentText'>".$commentData['CommentText']."</p>";
		
		/*echo "<form>
				<input type='submit' name='chapter' value='" . $commentData['ChapterName'] . "'>
				<input type='hidden' name='chapterRead' value='" . $commentData['ChapterID'] . "'>
			  </form>";*/
		echo "</div>
		</div>";
	}
	echo "</div>";
}
unset($_SESSION['chapterVoteBefore'] );
mysqli_close($connection);
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

