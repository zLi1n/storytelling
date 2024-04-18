<?php 
	session_start();
?>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}

$errorSym='<span class="material-symbols-outlined">error</span>';

if(isset($_POST["confirmIssues"])){
	$email = $_SESSION["email"];
	$storyID = $_POST["storyID"];
	if (isset($_POST["chapterID"]))
		$chapterID = $_POST["chapterID"];
	else if (isset($_POST["commentID"]))
		$commentID = $_POST["commentID"];
		
	if(isset($_POST["issues"])){
		foreach ($_POST["issues"] as $i)
			$issues[] = $i;
		if (in_array("Other:", $issues)){
			if (!empty($_POST["otherInput"])){
				if(preg_match('/^[a-zA-Z1-9\s]+$/', $_POST["otherInput"])){
					$otherIssue = $_POST["otherInput"];
				}else{
					$_SESSION['errorMsg']['other'] = "$errorSym Must contain only characters and numbers.";
					if (isset($chapterID)){ 
					?>		
						<form method='POST' action='reportContent.php' id='chapterBack'>
						<input type='hidden' name='reportChapter' value='<?=$chapterID?>'>
						</form>
						<script>
							document.getElementById("chapterBack").submit();
						</script>
					<?php
					}else if (isset($commentID)){ ?>
					<form method='POST' action='reportContent.php' id='commentBack'>
					<input type='hidden' name='reportComment' value='<?=$commentID?>'>
					</form>
					<script>
							document.getElementById("commentBack").submit();
						</script>
					<?php
					}
				}
			}else{
				$_SESSION['errorMsg']['other'] = "$errorSym Cannot be empty.";
				if (isset($chapterID)){ 	
				?>		
					<form method='POST' action='reportContent.php' id='chapterBack'>
					<input type='hidden' name='reportChapter' value='<?=$chapterID?>'>
					</form>
					<script>
						document.getElementById("chapterBack").submit();
					</script>
				<?php
				}else if (isset($commentID)){ ?>
				<form method='POST' action='reportContent.php' id='commentBack'>
				<input type='hidden' name='reportComment' value='<?=$commentID?>'>
				</form>
				<script>
						document.getElementById("commentBack").submit();
					</script>
				<?php
				}
			}
		}
		
		echo implode (', ', $issues);
		if (isset($otherIssue))
			$issueTxt = implode (', ', $issues)." ". $otherIssue;
		else
			$issueTxt = implode (', ', $issues);
		
		if (isset($chapterID)){ 
			$content = "$chapterID, NULL, ";	
		}else if (isset($commentID)){
			$content = "NULL, $commentID, ";	
		}
		$reportQuery = "SELECT MAX(ReportID) as maxReportID FROM ReportedContent";
		$reportResult = mysqli_query($connection, $reportQuery);
		$reportRow = mysqli_fetch_assoc($reportResult);
		$latestReportID = $reportRow['maxReportID'];

		$nextReportID = $latestReportID + 1;
		while (substr($nextReportID, 0, 1) !== '8') {
			$nextReportID++;
		}
		$sql = "INSERT INTO ReportedContent (ReportID, Email, ChapterID, CommentID, ReportDetails, Action)
				VALUES ($nextReportID, '$email', ".$content."'$issueTxt', NULL)";
				
		$result = mysqli_query($connection, $sql);
		if($result){
		 ?>
			<form method="post" action="storyDetail.php" id="addSForm">
				<input type="hidden" name="bookID" value="<?=$storyID?>">
				<input type="hidden" name="read" value="<?=$storyID?>">
			</form>
			<script>
				alert("We will review your report and take action if needed.\nThanks for letting us know!");
				document.getElementById("addSForm").submit();
			</script>
		<?php 
		}else
			die("Report Failed: " . mysqli_connect_error());
		
	}else{
		$_SESSION['errorMsg']['emt'] = "$errorSym Must select at least 1 issue.";
		if (isset($chapterID)){ 
			
		?>		
			<form method='POST' action='reportContent.php' id='chapterBack'>
			<input type='hidden' name='reportChapter' value='<?=$chapterID?>'>
			</form>
			<script>
				document.getElementById("chapterBack").submit();
			</script>
		<?php
		}else if (isset($commentID)){ ?>
		<form method='POST' action='reportContent.php' id='commentBack'>
		<input type='hidden' name='reportComment' value='<?=$commentID?>'>
		</form>
		<script>
				document.getElementById("commentBack").submit();
			</script>
		<?php
		}
	}
		
}

	
?>
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
