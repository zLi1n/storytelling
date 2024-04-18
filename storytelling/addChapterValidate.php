<?php 
	session_start();
?>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST["confirmStatus"])){
	$storyID = $_POST["bookID"];
	if(isset($_POST["storyStatus"])){
		$storyStatus = $_POST["storyStatus"];
		$query = "UPDATE Story SET Status = '$storyStatus' WHERE StoryID = $storyID";
		$result = mysqli_query($connection, $query);
		if($result){
		 ?>
			<form method="post" action="addChapter.php" id="addSForm">
				<input type="hidden" name="bookID" value="<?=$storyID?>">
				<input type="hidden" name="read" value="<?=$storyID?>">
			</form>
			<script>
				document.getElementById("addSForm").submit();
			</script>
		<?php 
		}else
			die("Add Chapter Failed: " . mysqli_connect_error());
	}else{  ?>
			<form method="post" action="addChapter.php" id="backForm">
				<input type="hidden" name="bookID" value="<?=$storyID?>">
				<input type="hidden" name="read" value="<?=$storyID?>">
			</form>
			<script>
				document.getElementById("backForm").submit();
			</script>
	<?php
		
	}
}
if(isset($_POST["addChapter"])){
	$email = $_SESSION['email'];
	$dateTime = date("Y-m-d H:i:s");
	$chapBeforeID = $_POST["chapBeforeID"];
	$storyID = $_POST["bookID"];

$chapQuery = "SELECT MAX(ChapterID) as maxChapID FROM Chapter";
$chapResult = mysqli_query($connection, $chapQuery);
$chapRow = mysqli_fetch_assoc($chapResult);
$latestChapID = $chapRow['maxChapID'];

$nextChapID = $latestChapID + 1;
while (substr($nextChapID, 0, 1) !== '4') {
	$nextChapID++;
}

	$chapterQuery = "INSERT INTO Chapter (ChapterID, Email, StoryID, ChapBeforeID, ChapterName, Content, Status, DateTime, Ending)
					VALUES ($nextChapID, '$email', $storyID, $chapBeforeID, NULL, NULL, 'D', '$dateTime', 0)";
		$chapterResult = mysqli_query($connection, $chapterQuery);
		if($chapterResult){ ?>
			<form method="post" action="createStoryContent.php" id="detailForm">
				<input type="hidden" name="chapterID" value="<?=$nextChapID?>">
			</form>
			<script>
				document.getElementById("detailForm").submit();
			</script>
	<?php }else
			die("Create Chapter Failed: " . mysqli_connect_error());
	
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
