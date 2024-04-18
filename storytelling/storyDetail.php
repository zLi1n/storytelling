<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Story Detail</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/storyDetailStyle.css">
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		<div class="backArr">
		<a href="<?=isset($_REQUEST['createStory'])?"createStoryMain.php":"readStoryMain.php"?>"><span class="material-symbols-outlined">arrow_back</span></a>
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
		if ($storyData['Status']=='F'){
			echo 'Finished';
		}else if($storyData['Status']=='O'){
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
/*read now btn*/		
		$storyID = $storyData['StoryID'];
		$firstChapterQuery = "SELECT ChapterID FROM Chapter WHERE StoryID = ".$storyID." AND Status = 'P' ORDER BY DateTime ASC LIMIT 1";
		$firstChapterResult = mysqli_query($connection, $firstChapterQuery);
		$firstChapterData = mysqli_fetch_assoc($firstChapterResult);
		$firstChapter = $firstChapterData['ChapterID'];
		
?>

	<div>
	<div class="btnCtn">
	
		<div id="status"></div>
    
<?php		echo '<form action="chapterContain.php" method="POST">
		<input type="submit" class="actionBtn" name="readChap1" value="Read Now">
		<input type="hidden" name="chapterRead" value="' . $firstChapter . '">
		</form>';
?>
</div>
<div id="timeLeft"></div>
<?php
	echo "</div></div>
	</div>

	<div class = 'chapContainer'>";
/*chapter*/
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$sql="SELECT * FROM Chapter WHERE StoryID = $storyID AND Status = 'P'";
	$result = mysqli_query($connection, $sql);
	
	if ($access == 'PVT') {
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
		</div>
		</div>";
		$chapterID = array_column($chapters, 'ChapterID');
	}else if ($access == 'PUB'){
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
			$chapterID = [];
			
			for ($i = 0; $i < count($_SESSION['chapterVoteBefore']); $i++) {
				
				$currentChapBeforeID = $_SESSION['chapterVoteBefore'][$i];

				if ($current>$votingPeriodEnd){
					$sql = "SELECT c.ChapterID, COUNT(*) AS votes FROM Vote v, Story s, Chapter c
							WHERE s.StoryID = c.StoryID AND c.ChapterID = v.ChapterID AND c.ChapBeforeID = $currentChapBeforeID
							AND c.DateTime >= '" . $contributionStart . "'
							AND c.DateTime < '" . $votingPeriodEnd . "'
							GROUP BY v.ChapterID ORDER BY votes DESC LIMIT 2";
				

					$result = mysqli_query($connection, $sql);
					$latestChapter=[];
					if (mysqli_num_rows($result)<1){
						$sql = "SELECT ChapterID FROM Chapter WHERE ChapBeforeID = $currentChapBeforeID AND DateTime >= '" . $contributionStart . "' AND DateTime < '" . $votingPeriodEnd . "' ORDER BY DateTime DESC LIMIT 2";
						$result = mysqli_query($connection, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							array_push($_SESSION['chapterVoteBefore'], $row["ChapterID"]);
							$latestChapter[] = $row["ChapterID"];
							
						}
					}else{
						$j = 1;
						while ($row = mysqli_fetch_assoc($result)) {
							$j++;
							array_push($_SESSION['chapterVoteBefore'], $row["ChapterID"]);
							$latestChapter[] = $row["ChapterID"];
							
						}
					}
				}else{	
					$sql = "SELECT c.ChapterID FROM Story s, Chapter c
							WHERE s.StoryID = c.StoryID AND c.ChapBeforeID = $currentChapBeforeID
							AND c.DateTime >= '" . $contributionStart . "'
							AND c.DateTime < '" . $votingPeriodEnd . "'
							ORDER BY c.DateTime ASC";
							
					$result = mysqli_query($connection, $sql);
					$latestChapter=[];

						$j = 1;
						while ($row = mysqli_fetch_assoc($result)) {
							$j++;
							array_push($_SESSION['chapterVoteBefore'], $row["ChapterID"]);
							$latestChapter[] = $row["ChapterID"];
							
						}
					}
				}
		
			
			if ($currentLoop == 0) {
				array_shift($_SESSION['chapterVoteBefore']);	
			}
			

		}
	
//echo "Contribution start for loop currentLoop: " . $contributionStart . ",Contribution deadline for loop currentLoop: " . $contributionDeadline . ", Voting period end: " . $votingPeriodEnd . "<br>";
		$endingSql = "SELECT Ending FROM Chapter WHERE ".(!empty($latestChapter)?"ChapterID IN (".implode (", " , $latestChapter).") AND ": ""). "Ending = '0' AND DateTime >= '" . $contributionStart . "'AND DateTime < '" . $votingPeriodEnd . "'";
		$endingResult = mysqli_query($connection, $endingSql);
		if (mysqli_num_rows($endingResult)> 0){
			
			if ($current>$votingPeriodEnd){
				$contributionLoop+=1;
				$sql = "UPDATE Story SET ContributionLoop = $contributionLoop WHERE storyID = $storyID";
				$result = mysqli_query($connection, $sql);
				
			}
		}else{
			$sql = "UPDATE Story SET Status = 'F' WHERE storyID = $storyID";
			$result = mysqli_query($connection, $sql);
		}
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
					  $chapterID[]=$chapterData;
				
			}
			while ($row = mysqli_fetch_assoc($latestChapResult)) {
				echo "<form action='chapterContain.php' method='POST'>
						<input type='submit' name='chapter' value='" .$row['ChapterName']. "'>
						<input type='hidden' name='chapterRead' value='" .$row['ChapterID']. "'>
					  </form>";
					  $chapterID[]=$row['ChapterID'];
			}

			echo "</div>
			</div>
			</div>";
		array_push($chapterID, $firstChapterID);	
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
	echo "</div>";
}
unset($_SESSION['chapterVoteBefore'] );
mysqli_close($connection);
?>

		<script>
        function updateChapterStatus() {
            var currentTime = Math.floor(Date.now() / 1000); 
            var publishedTime = <?php echo strtotime($contributionStart); ?>;
			var contributionEndTime = <?php echo strtotime($contributionDeadline); ?>;
			var votingEndTime = <?php echo strtotime($votingPeriodEnd); ?>;

            if (currentTime >= publishedTime && currentTime < contributionEndTime) {
                document.getElementById("status").innerHTML = "<form action='selectContributeChapter.php' method='POST'><input type='submit' name='contribute' value='Contribute' class='actionBtn' ><input type='hidden' name='storyID' value='<?=$storyID?>'></form>";
                var timeLeft = contributionEndTime - currentTime;
                displayTimeLeft(timeLeft);
            } else if (currentTime >= contributionEndTime && currentTime < votingEndTime) {
                document.getElementById("status").innerHTML = "<form action='voteChapter.php' method='POST'><input type='submit' name='vote' value='Vote' class='actionBtn' ><input type='hidden' name='storyID' value='<?=$storyID?>'></form>";
                var timeLeft = votingEndTime - currentTime;
                displayTimeLeft(timeLeft);
            } else {
                document.getElementById("status").innerHTML = "";
                document.getElementById("timeLeft").innerHTML = "";
            }
        }

        function displayTimeLeft(seconds) {
            var days = Math.floor(seconds / (24 * 60 * 60));
            var hours = Math.floor((seconds % (24 * 60 * 60)) / (60 * 60));
            var minutes = Math.floor((seconds % (60 * 60)) / 60);
            var seconds = seconds % 60;

            var timeLeftString = "";
            if (days > 0) timeLeftString += days + " days ";
            if (hours > 0) timeLeftString += hours + " hours ";
            if (minutes > 0) timeLeftString += minutes + " minutes ";
            if (seconds > 0) timeLeftString += seconds + " seconds ";

            document.getElementById("timeLeft").innerHTML = "<span class='material-symbols-outlined'>error</span>Time left: " + timeLeftString;
        }

        // Update chapter status initially and every second
        window.onload = function() {
            updateChapterStatus();
            setInterval(updateChapterStatus, 1000);
        };
    </script>


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

