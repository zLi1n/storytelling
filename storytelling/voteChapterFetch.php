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
if(isset($_POST["confirmVote"])){
	$email = $_SESSION["email"];
	$storyID = $_POST["storyID"];
	$dateTime = date("Y-m-d H:i:s");
	$voteChapterID = isset($_POST["voteChap"])?$_POST["voteChap"]:"";
	
		$voteQuery = "SELECT MAX(VoteID) as maxVoteID FROM Vote";
		$voteResult = mysqli_query($connection, $voteQuery);
		$voteRow = mysqli_fetch_assoc($voteResult);
		$latestVoteID = $voteRow['maxVoteID'];

		$nextVoteID = $latestVoteID + 1;
		while (substr($nextVoteID, 0, 1) !== '6') {
			$nextVoteID++;
		}
		$sql = "INSERT INTO Vote (VoteID, Email, ChapterID, DateTime)
				VALUES ($nextVoteID, '$email', '$voteChapterID', '$dateTime')";
				
		$result = mysqli_query($connection, $sql);
		if($result){
		 ?>
			<form method="post" action="voteChapterResult.php" id="addSForm">
				<input type="hidden" name="storyID" value="<?=$storyID?>">
			</form>
			<script>
				document.getElementById("addSForm").submit();
			</script>
		<?php 
		}else
			die("Report Failed: " . mysqli_connect_error());
		
	}else{
		$_SESSION['errorMsg']['emt'] = "$errorSym Must select at least 1 issue."; 
			
		?>		
			<form method='POST' action='reportContent.php' id='chapterBack'>
			<input type='hidden' name='reportChapter' value='<?=$chapterID?>'>
			</form>
			<script>
				document.getElementById("chapterBack").submit();
			</script>
		<?php
		
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
