<?php 
	session_start();
?>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
if(isset($_POST["createStory"])){
	$access = $_SESSION['access'];
	$email = $_SESSION['email'];
	$dateTime = date("Y-m-d H:i:s");
	$status = "O";
	$wordLimit = "NULL";
	$contributionLoop = "NULL";
	
	$_SESSION['fromVal']["count"] = 0;
	$errorSym='<span class="material-symbols-outlined">error</span>';
	function validateContent ($var,&$varName,$err){
		$errorSym='<span class="material-symbols-outlined">error</span>';
		if(isset($_POST["$var"])){
			$varName=$_POST["$var"];
			$_SESSION['fromVal']["$var"] = $_POST["$var"];
			$_SESSION['fromVal']["count"] +=1;	
		}else{		
			$_SESSION['errorMsg']["$var"] = "$errorSym $err";
			header("location:createStoryDetail.php");
		}
	}
	function validateVar($var,$max,&$varName,$con,$err1,$err2,$err3){	
		$errorSym='<span class="material-symbols-outlined">error</span>';
		if(!empty($_POST["$var"])){
			if(strlen($_POST["$var"])<=$max){
				$_SESSION['fromVal']["$var"] = $_POST["$var"];
				if(preg_match($con, $_POST["$var"])){
					$varName=$_POST["$var"];
					$_SESSION['fromVal']["count"] +=1;
				}else{					
				$_SESSION['errorMsg']["$var"] = "$errorSym $err3";
				header("location:createStoryDetail.php");
				}
			}else{		
			$_SESSION['errorMsg']["$var"] = "$errorSym $err2";
			header("location:createStoryDetail.php");
			}
		}else{		
			$_SESSION['errorMsg']["$var"] = "$errorSym $err1";
			header("location:createStoryDetail.php");
		}
	}
	
	validateVar('title',100 ,$title,'/^[a-zA-Z0-9 ]{1,500}$/','Name cannot be empty','Maximum 500 characters','Name must contain only characters and numbers');
	
	validateContent ('genre',$genre,'Genre cannot be empty');
	validateContent ('theme',$theme,'Theme cannot be empty');
	
	if($access === "PUB"){		
		$contributionLoop = 1;
	}
	validateContent ('coverPage',$coverPage,'Cover page cannot be empty');	

$connection = mysqli_connect("localhost", "root", "", "storytelling");

if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT MAX(StoryID) as maxID FROM Story";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$latestID = $row['maxID'];

$nextStoryID = $latestID + 1;
while (substr($nextStoryID, 0, 1) !== '3') {
	$nextStoryID++;
}
$chapQuery = "SELECT MAX(ChapterID) as maxChapID FROM Chapter";
$chapResult = mysqli_query($connection, $chapQuery);
$chapRow = mysqli_fetch_assoc($chapResult);
$latestChapID = $chapRow['maxChapID'];

$nextChapID = $latestChapID + 1;
while (substr($nextChapID, 0, 1) !== '4') {
	$nextChapID++;
}

if($_SESSION['fromVal']["count"] == 4){
	$storyQuery = "INSERT INTO Story (StoryID, Email, GenreID, ThemeID, Title, Access, CoverPage, Status, DateTime, ContributionLoop)
					VALUES ($nextStoryID, '$email', $genre, $theme, '$title', '$access', '$coverPage', '$status', '$dateTime', $contributionLoop)";
	$result = mysqli_query($connection, $storyQuery);
	
	if($result){
		$chapterQuery = "INSERT INTO Chapter (ChapterID, Email, StoryID, ChapBeforeID, ChapterName, Content, Status, DateTime, Ending)
							VALUES ($nextChapID, '$email', $nextStoryID, NULL, NULL, NULL, 'D', '$dateTime', 0)";
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
	}else
		die("Create Story Failed: " . mysqli_connect_error());
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
