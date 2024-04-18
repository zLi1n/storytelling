<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Select Contribute Chapter</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/voteChapterStyle.css">
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
date_default_timezone_set("Asia/Kuala_Lumpur");
//session_start();
if (isset($_REQUEST['vote'])){
	$storyID = $_REQUEST['storyID'];
	echo '<div class="backArr">
		<a href="storyDetail.php?read='.$storyID.'&bookID='.$storyID.'"><span class="material-symbols-outlined">arrow_back</span></a>
		</div>';

	echo "<div class='chapterContainer'>
	<h2 class='heading'>Vote Your Favorite Chapter</h2>";
	
	$email = $_SESSION['email'];
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

		$sql = "SELECT c.DateTime, s.ContributionLoop FROM Chapter c, Story s WHERE c.StoryID = $storyID AND c.Status = 'P' AND s.StoryID = c.StoryID AND s.Access = 'PUB' ORDER BY c.DateTime ASC LIMIT 1";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);
		$contributionLoop = $row["ContributionLoop"];
		$firstChapterPublishDateTime = $row["DateTime"];
		
		$nextContributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $contributionLoop);
		$nextContributionDeadline = calculatePeriodEnd($nextContributionStart, $daysToAddPerContribute);
		$nextVotingPeriodEnd = calculatePeriodEnd($nextContributionDeadline, $votingPeriodLength);
		$current = date("Y-m-d H:i:s");
	//echo "Contribution start for next loop: " .$nextContributionStart.'<br>Contribution end for next loop: '.$nextContributionDeadline.'<br>Vote end for next loop: '. $nextVotingPeriodEnd.'<br><br>';
	
		$curContributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $contributionLoop-1);
		$curContributionDeadline = calculatePeriodEnd($curContributionStart, $daysToAddPerContribute);
		$curVotingPeriodEnd = calculatePeriodEnd($curContributionDeadline, $votingPeriodLength);
		$current = date("Y-m-d H:i:s");
	//echo "Contribution start for current loop: " .$curContributionStart.'<br>Contribution end for current loop: '.$curContributionDeadline.'<br>Vote end for current loop: '. $curVotingPeriodEnd.'<br><br>';
		
		$sql = "SELECT * FROM Chapter WHERE Status = 'P' AND StoryID = $storyID AND DateTime >= '" . $curContributionStart . "' AND DateTime < '" . $curContributionDeadline . "' AND ChapBeforeID IS NOT NULL ORDER BY DateTime ASC";
			$result = mysqli_query($connection, $sql);
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$chapterIDGroup[] = $row['ChapterID'];
				}
			}
		$chapters = isset($chapterIDGroup)? "AND ChapterID IN(".implode(', ', $chapterIDGroup).")":"";
		
		$sql = "SELECT * FROM Vote WHERE Email = '$email' AND  DateTime >= '" . $curContributionDeadline . "' AND DateTime < '" . $curVotingPeriodEnd . "' ".$chapters;
		
		$result = mysqli_query($connection, $sql);
		if(mysqli_num_rows($result)==0){
		echo "<form action='voteChapterFetch.php' method='POST'>";
			$sql = "SELECT * FROM Chapter WHERE Status = 'P' AND StoryID = $storyID AND DateTime >= '" . $curContributionStart . "' AND DateTime < '" . $curContributionDeadline . "' AND ChapBeforeID IS NOT NULL ORDER BY DateTime ASC";
			$result = mysqli_query($connection, $sql);
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$chapterID = $row['ChapterID'];
					$chapterName = $row['ChapterName'];
					echo "<input class='radio-input' type='radio' name='voteChap' value='" .$chapterID. "' id='" .$chapterID. "' required><label class='radio-label' for='" .$chapterID. "'><span class='radio-inner-circle'></span>".$chapterName."</label><br>";
				}
			}
			echo '<input type="hidden" name="storyID" value="'.$storyID.'">
			<button class="edit" type="submit" name="confirmVote" value="Confirm"><i class="fa fa-check-circle"></i> Confirm</button>';
			echo "</form>";
		}else{
			?>
			<form method="post" action="voteChapterResult.php" id="addSForm">
				<input type="hidden" name="storyID" value="<?=$storyID?>">
			</form>
			<script>
				document.getElementById("addSForm").submit();
			</script>
		<?php 
		}
		
	?>
			
			<?php

	echo "</div>";?>

</div>
<?php
}

mysqli_close($connection);
unset($_SESSION['chapterVoteBefore'] );
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

