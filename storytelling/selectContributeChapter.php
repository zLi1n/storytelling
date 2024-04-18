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
		<link rel="stylesheet" href="css/selectContributeChapterStyle.css">
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
if (isset($_REQUEST['contribute'])){
	//echo $_REQUEST['currentChap'];
	$storyID = $_REQUEST['storyID'];
	echo '<div class="backArr">
		<a href="storyDetail.php?read='.$storyID.'&bookID='.$storyID.'"><span class="material-symbols-outlined">arrow_back</span></a>
		</div>';
	$storySql = "SELECT * FROM story WHERE StoryID=".$storyID;
	$storyRun = mysqli_query($connection, $storySql);
	$storyData = mysqli_fetch_array($storyRun);
	$contributionLoop = $storyData['ContributionLoop'];
	$sql = "SELECT * FROM Chapter WHERE Status = 'P' AND StoryID = $storyID AND ChapBeforeID IS NULL";
		$result = mysqli_query($connection, $sql);
		$firstChapData = mysqli_fetch_assoc($result);
		$firstChapterID = $firstChapData['ChapterID'];
		$_SESSION['chapterVoteBefore'] = [$firstChapterID];
	echo "<div class='chapterContainer'>
	<h2 class='heding'>Select Where You Want to Contribute From</h2>";
	
		
		if($storyData['ContributionLoop'] == 1){
			$sql = "SELECT * FROM Chapter WHERE StoryID = $storyID AND status = 'P'";
				$result = mysqli_query($connection, $sql);
				$row = mysqli_fetch_assoc($result);
				$chapterName = $row["ChapterName"];
				$chapterID = $row["ChapterID"];
				echo "<form action='addChapterValidate.php' method='POST'>
						<input type='submit' name='chapter' value='" .$chapterName. "'>
						<input type='hidden' name='addChapter' value='" .$chapterID. "'>
						<input type='hidden' name='chapBeforeID' value='" .$chapterID. "'>
						<input type='hidden' name='bookID' value='" .$storyID. "'>
					  </form>";
		}else{
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
		
		$latestContributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $contributionLoop);
		$latestContributionDeadline = calculatePeriodEnd($latestContributionStart, $daysToAddPerContribute);
		$latestVotingPeriodEnd = calculatePeriodEnd($latestContributionDeadline, $votingPeriodLength);
		$current = date("Y-m-d H:i:s");
	echo $latestContributionStart.'<br>'.$latestContributionDeadline.'<br>'. $latestVotingPeriodEnd.'<br>';
		
		$contributionStart = calculateContributionStart($firstChapterPublishDateTime, $daysToAddPerLoop, $contributionLoop-2);
		$contributionDeadline = calculatePeriodEnd($contributionStart, $daysToAddPerContribute);
		$votingPeriodEnd = calculatePeriodEnd($contributionDeadline, $votingPeriodLength);
echo "Contribution start for before: " . $contributionStart . ",Contribution deadline for before: " . $contributionDeadline . ", Voting period end: " . $votingPeriodEnd . "<br>";

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
			foreach($_SESSION['chapterVoteBefore'] as $i){
				$sql = "SELECT * FROM Chapter WHERE ChapterID = $i AND status = 'P'AND DateTime >= '" . $contributionStart . "'
							AND DateTime < '" . $votingPeriodEnd . "' AND Ending = 0";
				$result = mysqli_query($connection, $sql);
				if(mysqli_num_rows($result)>0){
				$row = mysqli_fetch_assoc($result);
				$chapterName = $row["ChapterName"];
				$chapterID = $row["ChapterID"];
				echo "<form action='addChapterValidate.php' method='POST'>
						<input type='submit' name='chapter' value='" .$chapterName. "'>
						<input type='hidden' name='addChapter' value='" .$chapterID. "'>
						<input type='hidden' name='chapBeforeID' value='" .$chapterID. "'>
						<input type='hidden' name='bookID' value='" .$storyID. "'>
					  </form>";
				}
			}
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

