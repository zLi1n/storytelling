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
		<link rel="stylesheet" href="css/selectChapterStyle.css">
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
if (isset($_REQUEST['currentChap'])){
	//echo $_REQUEST['currentChap'];
	$currentChapterID = $_REQUEST['currentChap'];
	$storySql = "SELECT s.* FROM chapter c, story s WHERE c.StoryID=s.StoryID AND c.ChapterID='".$currentChapterID."' AND c.status='P'";
	$storyRun = mysqli_query($connection, $storySql);
	$storyData = mysqli_fetch_array($storyRun);
	$access = $storyData['Access'];
	$storyID = $storyData['StoryID'];
	echo "<div class='chapterContainer'>";
	if ($access == 'PUB'){		
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
		//echo $latestContributionStart.'<br>'.$latestContributionDeadline.'<br>'. $latestVotingPeriodEnd;
		$sql = "SELECT DateTime FROM Chapter WHERE ChapBeforeID = $currentChapterID AND Status = 'P'";
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result)>0){
			$row = mysqli_fetch_assoc($result);
			$dateTime = $row["DateTime"];
			if ($dateTime >= $latestContributionStart && $dateTime < $latestVotingPeriodEnd)
				$sql = "SELECT ChapterID FROM Chapter WHERE ChapBeforeID = $currentChapterID ";
			else
				$sql = "SELECT c.ChapterID, COUNT(*) AS votes FROM Vote v, Story s, Chapter c WHERE s.StoryID = c.StoryID AND c.ChapterID = v.ChapterID AND c.ChapBeforeID = $currentChapterID GROUP BY v.ChapterID ORDER BY votes DESC LIMIT 2";

			$result = mysqli_query($connection, $sql);
			if (mysqli_num_rows($result)>1){
				$j = 1;
				while ($row = mysqli_fetch_assoc($result)) {
					$j++;
					$latestChapter[] = $row["ChapterID"];
						
				}
			}else if (mysqli_num_rows($result)<1){
					$sql = "SELECT ChapterID FROM Chapter WHERE ChapBeforeID = $currentChapterID ORDER BY DateTime DESC LIMIT 2";
					$result = mysqli_query($connection, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						
						$latestChapter[] = $row["ChapterID"];
						
					}
				}
		
			foreach ($latestChapter as $chapterData) {
				$sql = "SELECT ChapterName FROM Chapter WHERE ChapterID = $chapterData";
				$result = mysqli_query($connection, $sql);
				$row = mysqli_fetch_assoc($result);
				$chapterName = $row["ChapterName"];
				echo "<form action='chapterContain.php' method='POST'>
						<input type='submit' name='chapter' value='" .$chapterName. "'>
						<input type='hidden' name='chapterRead' value='" .$chapterData. "'>
					  </form>";			
			}
		}else{
			echo "<div class='noChap'>
			<p>There is no next chapter available</p>
			</div>
			<form action='chapterContain.php' method='POST'> 
			<input type='submit' value='Back to Previous Chapter' name='chapterName'>
			<input type='hidden' value='".$currentChapterID."' name='chapterRead'>
			</form>
			<form action='storyDetail.php' method='POST'> 
			<input type='submit' value='Back to Chapter Detail' name='read'>
			<input type='hidden' value='".$storyID."' name='bookID'>
			</form>";
		}
	}else if ($access == 'PVT'){
		$chapterSql = "SELECT * FROM chapter WHERE ChapBeforeID='".$currentChapterID."' AND status='P'";
		$chapterRun = mysqli_query($connection, $chapterSql);
		
		if (mysqli_num_rows($chapterRun)>0){
			$chapterNext = [];
			
			while ($chapterData = mysqli_fetch_array($chapterRun)) {
				echo "<form action='chapterContain.php' method='POST' name='selectChapter'> 
				<input type='submit' value='".$chapterData['ChapterName']."' name='chapterName'>
				<input type='hidden' value='".$chapterData['ChapterID']."' name='chapterRead'>
				</form>";
			}
			
		}else{
			echo "<div class='noChap'>
			<p>There is no next chapter available</p>
			</div>
			<form action='chapterContain.php' method='POST'> 
			<input type='submit' value='Back to Previous Chapter' name='chapterName'>
			<input type='hidden' value='".$currentChapterID."' name='chapterRead'>
			</form>
			<form action='storyDetail.php' method='POST'> 
			<input type='submit' value='Back to Chapter Detail' name='read'>
			<input type='hidden' value='".$storyID."' name='bookID'>
			</form>";
		}
	}?>
			<script>
			document.forms["selectChapter"].submit();
			</script>
			<?php

	echo "</div>";?>
	<div class="dropdown" id="dropdown">
  <button class="plusBtn" onclick="openNavMenu()"> + </button>
  <div class='storyNav' id='storyNav'>
    <form action='storyDetail.php' method='POST'>
	<button type="submit" name="read" value="Story Detail"><i class="fa fa-file"></i> Story Detail</button> 
      <input type='hidden' name='bookID' value='<?=$storyData['StoryID']?>'>
    </form>
    <button onclick="setTimeout(() => openNav(), 0)"><i class="fa fa-bars"></i> Chapter</button>

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
<?php
}

mysqli_close($connection);
?>



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

