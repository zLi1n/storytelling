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
		<link rel="stylesheet" href="css/chapterContentStyle.css">
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>

    
<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
	
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
//session_start();
if (isset($_REQUEST['chapterRead'])){
	//echo $_REQUEST['chapterRead'];
	$chapterSql = "SELECT * FROM chapter WHERE ChapterID='".$_REQUEST['chapterRead']."'";
	$chapterRun = mysqli_query($connection, $chapterSql);
	$chapterData = mysqli_fetch_assoc($chapterRun);
	$storyID = $chapterData['StoryID'];
	$chapBeforeID = $chapterData['ChapBeforeID'];
	echo "<div class='chapterContainer'><form method='POST' action='reportContent.php'><button class='reportCtn' type='submit' name='reportChapter' value='".$_REQUEST['chapterRead']."'><i class='fa fa-exclamation-circle'> </i> Report</button></form>
	<div class='chapterCtn'>
	
	<h2 class='chapterTtl'>".$chapterData['ChapterName']."</h2>";
	
	$authorQuery = "SELECT u.* FROM chapter c, story s, user u WHERE c.StoryID = s.StoryID AND s.Email = u.Email AND c.ChapterID='".$_REQUEST['chapterRead']."'";
	$authorRun = mysqli_query($connection, $authorQuery);
	$authorData = mysqli_fetch_assoc($authorRun);
	echo "<h5 class='chapterTtl'>BY ".$authorData['Username']."</h5>";
	
	echo nl2br("<p>".$chapterData['Content']."</p>");
	
	//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
	echo "</div>";
	
	echo '<p class="endChapter">End of Chapter</p>';
	$commentQuery = "SELECT * FROM Comment WHERE ChapterID = ".$_REQUEST['chapterRead']." ORDER BY DateTime DESC";
	$commentResult = mysqli_query($connection, $commentQuery);
	$comments = [];
	
	while ($commentData = mysqli_fetch_array($commentResult)) {
		$comments[] = $commentData;
	}

	echo "<div class='commentContainer' id='comment'>
			<p class='chapTxt'><strong>Comments (" . count($comments) . ")</strong></p>";
	
	echo '<div class="leaveCmmCtn">
			<p class="leaveCommentTxt">Leave a Comment</p>
			<form action="commentValidate.php" method="POST">
			<div>';
	if (isset($_SESSION['errorMsg']['comment']))
		echo "<span class='commentError'>".$_SESSION['errorMsg']['comment']."</span>";
	echo'<textarea class="textarea" name="comment"></textarea>
			</div>
			<div class="submitBtn">
			<input type="submit" name="publishComment" value="Post">
			<input type="hidden" name="chapID" value="'.$_REQUEST['chapterRead'].'">
			</div>
			</form>		
			</div>';
	unset($_SESSION['errorMsg']);
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
		<div class='commentTxt' id='comment'>";
		$commentChapQuery = "SELECT c.* FROM Comment co, Chapter c WHERE co.ChapterID = c.ChapterID AND co.ChapterID ='".$commentData['ChapterID']."'";
		$commentChapResult = mysqli_query($connection, $commentChapQuery);
		$commentChapData = mysqli_fetch_assoc($commentChapResult);
		$commentChapName = $commentChapData['ChapterName'];
		echo "<form method='POST' action='reportContent.php'><button class='reportCtn' type='submit' name='reportComment' value='".$commentData['CommentID']."'><i class='fa fa-exclamation-circle'> </i> Report</button></form>";
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
	//echo "</div>";
	echo "</div>";
	echo "<form action='selectChapter.php' method='POST'>
		<input type='submit' name='chapter' value='Next Chapter' class='nextChapBtn'>
		<input type='hidden' name='currentChap' value='".$_REQUEST['chapterRead']."'>
	  </form>";
	echo "</div>";?>
	<div class="dropdown" id="dropdown">
		<button class="plusBtn" onclick="openNavMenu()"> + </button>
		<div class='storyNav' id='storyNav'>
			<form action='selectChapter.php' method='POST'>
				<button type="submit" name="chapter" value="Next Chapter">Next Chapter <i class="fa fa-caret-right"></i></button> 
				<input type='hidden' name='currentChap' value='<?=$_REQUEST['chapterRead']?>'>
			</form>
			<form action='storyDetail.php' method='POST'>
				<button type="submit" name="read" value="Story Detail"><i class="fa fa-file"></i> Story Detail</button> 
				<input type='hidden' name='bookID' value='<?=$chapterData['StoryID']?>'>
			</form>
			<button onclick="setTimeout(() => openNav(), 0)"><i class="fa fa-bars"></i> Chapter</button>
			<a href='#comment'><i class="fa fa-comments"></i> Comment</a>
			<form action='chapterContain.php' method='POST'>
				<button type="submit" name="chapter" value="Previous Chapter" <?=!empty($chapBeforeID)?"":"disabled"?>><i class="fa fa-caret-left"></i> Previous Chapter</button> 
				<input type='hidden' name='chapterRead' value='<?=$chapBeforeID?>'>
			</form>
		</div>
	</div>
	<?php
	$storySql = "SELECT * FROM story WHERE StoryID = $storyID";
	$storyRun = mysqli_query($connection, $storySql);
	$storyData = mysqli_fetch_assoc($storyRun);
	$access = $storyData['Access'];?>
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
	echo "<div class = 'chapContainer'>";
/*chapter*/
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$sql="SELECT * FROM Chapter WHERE StoryID = $storyID AND Status = 'P'";
	$result = mysqli_query($connection, $sql);
	
	if (mysqli_num_rows($result)<= 1||$access == 'PVT') {
		$chapterQuery = "SELECT * FROM Chapter WHERE StoryID = $storyID AND Status = 'P' ORDER BY DateTime ASC";
		$chapterResult = mysqli_query($connection, $chapterQuery);
		
		while ($chapterData = mysqli_fetch_array($chapterResult)) {
			$chapters[] = $chapterData;
		}

		echo '<p class="chapTxt"><strong>Chapters (' . count($chapters) . ')</strong></p>
		<div class="chaptersCtn">';
		
		foreach ($chapters as $chapterData) {
			echo "<form action='chapterContain.php' method='POST'>
					<input type='submit' name='chapter' value='" . $chapterData['ChapterName'] . "'>
					<input type='hidden' name='chapterRead' value='" . $chapterData['ChapterID'] . "'>
				  </form>";
		}
		echo "</div>
		</div>";
		$chapterID = array_column($chapters, 'ChapterID');
	}else if (mysqli_num_rows($result)> 1){
		function calculateContributionStart($dateTime, $daysToAdd, $contributionLoop) {
			$baseDateTime = new DateTime($dateTime);
			$contributionDeadline = $baseDateTime->add(new DateInterval("P" . ($daysToAdd * $contributionLoop) . "D"));
			return $contributionDeadline->format("Y-m-d H:i:s");
		}

		function calculatePeriodEnd($contributionDeadline, $daysToAdd) {
			$contributionDeadlineObj = new DateTime($contributionDeadline);
			$votingPeriodEnd = $contributionDeadlineObj->add(new DateInterval("P{$daysToAdd}D"));
			return $votingPeriodEnd->format("Y-m-d H:i:s");
		}

		$daysToAddPerLoop = 8; 
		$daysToAddPerContribute = 5;
		$votingPeriodLength = 3; 

		$storyID = $storyData['StoryID'];
		$sql = "SELECT c.DateTime, c.ChapterID, c.ChapterName, s.ContributionLoop FROM Chapter c, Story s WHERE c.StoryID = $storyID AND c.Status = 'P' AND s.StoryID = c.StoryID AND s.Access = 'PUB' ORDER BY c.DateTime ASC LIMIT 1";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);
		$firstChapterPublishDateTime = $row["DateTime"];
		$contributionLoop = $row["ContributionLoop"];
		$firstChapterID = $row["ChapterID"];
		$firstChapterName = $row["ChapterName"];
		
		$latestContributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $contributionLoop);
		$latestContributionDeadline = calculatePeriodEnd($latestContributionStart, $daysToAddPerContribute);
		$latestVotingPeriodEnd = calculatePeriodEnd($latestContributionDeadline, $votingPeriodLength);
		$current = date("Y-m-d H:i:s");
		//echo "Contribution start for loop : " . $latestContributionStart . ",Contribution deadline for loop : " . $latestContributionDeadline . ", Voting period end: " . $latestVotingPeriodEnd . "<br>";
		
		$_SESSION['chapterVoteBefore'] = [$firstChapterID];

		for ($currentLoop = 0; $currentLoop < $contributionLoop; $currentLoop++) {
			$contributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $currentLoop);
			$contributionDeadline = calculatePeriodEnd($contributionStart, $daysToAddPerContribute);
			$votingPeriodEnd = calculatePeriodEnd($contributionDeadline, $votingPeriodLength);
			//echo "Contribution start for loop <b>$currentLoop</b>: " . $contributionStart . ",Contribution deadline for loop $currentLoop: " . $contributionDeadline . ", Voting period end: " . $votingPeriodEnd . "<br>";
			
			for ($i = 0; $i < count($_SESSION['chapterVoteBefore']); $i++) {
				
				$currentChapBeforeID = $_SESSION['chapterVoteBefore'][$i];

				$sql = "SELECT c.ChapterID, COUNT(*) AS votes FROM Vote v, Story s, Chapter c
						WHERE s.StoryID = c.StoryID AND c.ChapterID = v.ChapterID AND c.ChapBeforeID = $currentChapBeforeID
						AND c.DateTime >= '" . $contributionStart . "'
						AND c.DateTime < '" . $votingPeriodEnd . "'
						GROUP BY v.ChapterID ORDER BY votes DESC LIMIT 2";

				$result = mysqli_query($connection, $sql);
				if (mysqli_num_rows($result)<1){
					$sql = "SELECT ChapterID FROM Chapter WHERE ChapBeforeID = $currentChapBeforeID AND DateTime >= '" . $contributionStart . "' AND DateTime < '" . $votingPeriodEnd . "' ORDER BY DateTime DESC LIMIT 2";
					$result = mysqli_query($connection, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						array_push($_SESSION['chapterVoteBefore'], $row["ChapterID"]);
						
					}
				}else{
					$j = 1;
					while ($row = mysqli_fetch_assoc($result)) {
						$j++;
						array_push($_SESSION['chapterVoteBefore'], $row["ChapterID"]);
						
					}
				}
				
			}
			if ($currentLoop == 0) {
				array_shift($_SESSION['chapterVoteBefore']);	
			}
			

		}
	
		//echo "Contribution start for loop currentLoop: " . $contributionStart . ",Contribution deadline for loop currentLoop: " . $contributionDeadline . ", Voting period end: " . $votingPeriodEnd . "<br>";

		$latestChapSql = "SELECT * FROM Chapter WHERE DateTime >= '" . $latestContributionStart . "'AND DateTime < '" . $latestVotingPeriodEnd . "' AND Status = 'P' AND StoryID = $storyID";
		$latestChapResult = mysqli_query($connection, $latestChapSql);
		$latestChapNum = mysqli_num_rows($latestChapResult);
		if (isset($latestChapNum))
			$chapterNum = count($_SESSION['chapterVoteBefore']) + 1 + $latestChapNum;
		else
			$chapterNum = count($_SESSION['chapterVoteBefore']) + 1;
		
		
		echo '<p class="chapTxt"><strong>Chapters (' . $chapterNum . ')</strong></p>
			<div class="chaptersCtn">';
			echo "<form action='chapterContain.php' method='POST'>
						<input type='submit' name='chapter' value='" .$firstChapterName. "'>
						<input type='hidden' name='chapterRead' value='" .$firstChapterID. "'>
					  </form>";
			foreach ($_SESSION['chapterVoteBefore'] as $chapterData) {
				$sql = "SELECT ChapterName FROM Chapter WHERE ChapterID = $chapterData";
				$result = mysqli_query($connection, $sql);
				$row = mysqli_fetch_assoc($result);
				$chapterName = $row["ChapterName"];
				echo "<form action='chapterContain.php' method='POST'>
						<input type='submit' name='chapter' value='" .$chapterName. "'>
						<input type='hidden' name='chapterRead' value='" .$chapterData. "'>
					  </form>";
					  
				
			}
			while ($row = mysqli_fetch_assoc($latestChapResult)) {
				echo "<form action='chapterContain.php' method='POST'>
						<input type='submit' name='chapter' value='" .$row['ChapterName']. "'>
						<input type='hidden' name='chapterRead' value='" .$row['ChapterID']. "'>
					  </form>";
					  
			}

			echo "</div>
			
			</div>";
			
	}
?>
</div>

<script>

function openNavMenu() {
	var storyNav = document.getElementById("storyNav");
	storyNav.classList.toggle("show");
}

window.onclick = function (event) {
	if (!event.target.matches('.plusBtn')) {
		var storyNav = document.getElementById("storyNav");
		if (storyNav.classList.contains('show')) {
			storyNav.classList.remove('show');
		}
	}
}
var prevScrollposDropdown = window.pageYOffset;
var prevScrollposHeader = window.pageYOffset;

window.addEventListener("scroll", function() {
	var currentScrollPos = window.pageYOffset;
	var dropdownElement = document.getElementById("dropdown");
	if (prevScrollposDropdown > currentScrollPos) {
		dropdownElement.style.display = "block";
	} else {
		dropdownElement.style.display = "none";
	}
	prevScrollposDropdown = currentScrollPos;
});

window.addEventListener("scroll", function() {
	var currentScrollPos = window.pageYOffset;
	if (prevScrollposHeader > currentScrollPos) {
		document.getElementById("header").style.top = "0";
	} else {
		document.getElementById("header").style.top = "-60px";
	}
	prevScrollposHeader = currentScrollPos;
});
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.body.addEventListener('click', closeNavOutside);
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.body.removeEventListener('click', closeNavOutside);
}

function closeNavOutside(event) {
  if (!document.getElementById('mySidenav').contains(event.target)) {
    closeNav();
  }
}
</script>

<?php
}
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

