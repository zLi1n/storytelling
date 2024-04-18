<?php 
	session_start();
?>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$connection = mysqli_connect("localhost", "root", "", "storytelling");
	
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}/*
$storyID = 322;
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
		
			$totalQuery = "SELECT COUNT(VoteID) AS VoteCount FROM vote WHERE ChapterID IN(".implode(', ', $chapterIDGroup).")";
			$totalResult = mysqli_query($connection, $totalQuery);
			$totalVote = mysqli_fetch_assoc($totalResult);
			$totalVoteCount = $totalVote['VoteCount'];
			$sql = "SELECT * FROM Chapter WHERE Status = 'P' AND StoryID = $storyID AND DateTime >= '" . $curContributionStart . "' AND DateTime < '" . $curContributionDeadline . "' AND ChapBeforeID IS NOT NULL ORDER BY DateTime ASC";
			$result = mysqli_query($connection, $sql);
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$chapterID = $row['ChapterID'];
					$chapterName = $row['ChapterName'];
					$voteQuery = "SELECT COUNT(VoteID) AS VoteCount FROM vote WHERE ChapterID = $chapterID";
					$voteResult = mysqli_query($connection, $voteQuery);
					$count = mysqli_fetch_assoc($voteResult);
					$voteCount = $count['VoteCount'];

					if ($totalVoteCount != 0)
						$percentage = round(($voteCount/$totalVoteCount),2);
					else
						$percentage = 0;
					
					echo "$chapterID - $chapterName - $voteCount - $percentage % <br>";
				}
			}
		*/
		$voteCount = 10;
		$totalVoteCount = 20;
$percentage = round(($voteCount / $totalVoteCount) * 100, 2);
echo $percentage ;

?>

