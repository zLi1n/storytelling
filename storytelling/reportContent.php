<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>
<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/headerFooterstyle.css">
<link rel="stylesheet" href="css/reportContentStyle.css">
</head>
<body class="homepage">

<div class="header" id="header">
</div>
<div class="topBtn" id="topBtn"> </div>
<div class="login">
<div class="bgStyleContainer">
  <div class="gridItem1">
  	<div class="bgCloud1"></div>
    <div class="bgCloud2"></div>
    <div class="bgCloud3"></div>
    <div class="bgCloud4"></div>
    <div class="bgCloud5"></div>
    <div class="bgCloud6"></div>
  </div>
  <div class="gridItem"></div>
  <div class="gridItem"></div>  
  <div class="gridItem4">
  	<div class="bgCloudCtn">
    	<div class="bgCloud7"></div>
    	<div class="bgCloud8"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud9"></div>
    	<div class="bgCloud10"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud11"></div>
        <div class="bgCloud12"></div>
     </div>
     <div class="bgCloudCtn">
    	<div class="bgCloud13"></div>
    	<div class="bgCloud14"></div>
     </div>
  </div>
</div>
</div>
<div class="loginForm">
<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
if (!$connection) {
	die ("Connection failed: ".mysqli_connect_error());
}

$email = $_SESSION["email"];

function truncateComment($comment, $limit = 28) {
  $words = explode(" ", $comment);
  if (count($words) <= $limit) {
    return $comment;
  }
  $truncatedWords = array_slice($words, 0, $limit);
  $truncatedComment = implode(" ", $truncatedWords) . " ...";

  return $truncatedComment;
}

?>
<form action="reportContentValidate.php" method="POST">
<div class="userDetail">
	<?php

if(isset($_POST["reportChapter"])){
	$chapterID = $_POST["reportChapter"];
	$query = "SELECT * FROM Chapter WHERE ChapterID = $chapterID";
	$result = mysqli_query($connection, $query);
	$chapRow = mysqli_fetch_assoc($result);
	$content = $chapRow['Content'];
	$storyID = $chapRow['StoryID'];
	$truncatedContent = truncateComment($content);
	?>
	<input type="hidden" name="chapterID" value="<?=$chapterID?>">
	<input type="hidden" name="storyID" value="<?=$storyID?>">
	<h1>Report Chapter Issues</h1>
	<div class="ctnDtl"><?=$truncatedContent?></div>
	<span class="errMsg"><?=isset($_SESSION["errorMsg"]['emt']) ? $_SESSION["errorMsg"]['emt'] : ''?> </span>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="inappropriate" value="Inappropriate Content" class="checkCustom"> 
		<label class="issue" for="inappropriate">Inappropriate Content</label>
	</div>
	<p class="descIssues">The chapter contains violence, hate speech, or sexually suggestive content that violates community guidelines.</p>
	
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="copyright" value="Copyright Infringement" class="checkCustom"> 
		<label class="issue" for="copyright">Copyright Infringement</label>
	</div>
	<p class="descIssues">The chapter appears to be copied from another source without permission.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="spam" value="Spam or Advertising" class="checkCustom"> 
		<label class="issue" for="spam">Spam or Advertising</label>
	</div>
	<p class="descIssues">The chapter is primarily for promotional purposes and not an actual story.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="missing" value="Missing Conten" class="checkCustom"> 
		<label class="issue" for="missing">Missing Content</label>
	</div>
	<p class="descIssues">The chapter appears to be incomplete or missing content.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="inconsistent" value="Inconsistent with Story" class="checkCustom"> 
		<label class="issue" for="inconsistent">Inconsistent with Story</label>
	</div>
	<p class="descIssues">The chapter content doesn't align with the overall story plot or timeline.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="language" value="Inappropriate Language" class="checkCustom"> 
		<label class="issue" for="language">Inappropriate Language</label>
	</div>
	<p class="descIssues">The chapter contains excessive profanity or offensive language.</p>
	<br>
	<?php
	
}
if(isset($_POST["reportComment"])){
	$commentID = $_POST["reportComment"];
	
	$query = "SELECT * FROM Comment WHERE CommentID = $commentID";
	$result = mysqli_query($connection, $query);
	$commRow = mysqli_fetch_assoc($result);
	$comment = $commRow['CommentText'];
	$chapterID = $commRow['ChapterID'];
	$query = "SELECT * FROM Chapter WHERE ChapterID = $chapterID";
	$result = mysqli_query($connection, $query);
	$chapRow = mysqli_fetch_assoc($result);
	$storyID = $chapRow['StoryID'];
	$truncatedComment = truncateComment($comment);
?>
	<input type="hidden" name="commentID" value="<?=$commentID?>">
	<input type="hidden" name="storyID" value="<?=$storyID?>">
	
	<h1>Report Comment Issues</h1>
	<div class="ctnDtl"><?=$truncatedComment?></div>
	<span class="errMsg"><?=isset($_SESSION["errorMsg"]['emt']) ? $_SESSION["errorMsg"]['emt'] : ''?> </span>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="harassment" value="Harassment or Bullying" class="checkCustom"> 
		<label class="issue" for="harassment">Harassment or Bullying</label>
	</div>
	<p class="descIssues">The comment targets a specific user with hateful or abusive language.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="commentSpam" value="Spam or Advertising" class="checkCustom"> 
		<label class="issue" for="commentSpam">Spam or Advertising</label>
	</div>
	<p class="descIssues">The comment is primarily for promotional purposes and not a relevant contribution to the discussion.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="spoiler" value="Spoiler" class="checkCustom"> 
		<label class="issue" for="spoiler">Spoiler</label>
	</div>
	<p class="descIssues">The comment reveals major plot points of the story for those who haven't read it yet.</p>
	<br>
	<div class="checkContainer">
		<input type="checkbox" name="issues[]" id="offTopic" value="Off-Topic" class="checkCustom"> 
		<label class="issue" for="offTopic">Off-Topic</label>
	</div>
	<p class="descIssues">The comment doesn't relate to the story or chapter and disrupts the conversation.</p>
	<br>
	
	<?php
}
?>

<div class="checkContainer">
		<input type="checkbox" onclick="checkOthers(this);" id="otherCheck" class="checkCustom" name="issues[]" value="Other:"> 
		<label class="issue" for="otherCheck">Other... (Please Specify)</label>
	</div>
	<span class="errMsg"><?=isset($_SESSION["errorMsg"]['other']) ? $_SESSION["errorMsg"]['other'] : ''?> </span>
	<input id="other" name="otherInput" disabled="disabled" required>
	<br>
	
</div>
	<button class="edit" type="submit" name="confirmIssues" value="Confirm"><i class="fa fa-check-circle"></i> Confirm</button>
</form>
</div>
	<?php
unset($_SESSION['errorMsg']);
?>
<footer class="footer" id="footer">
	
</footer>
<script src="js/navBar.js"></script>
<script>
function checkOthers(checkbox) {
	var input = document.getElementById('other');
	if (checkbox.checked) {
		input.disabled = false;
		input.focus();
	} else {
		input.disabled = true;
	}
}
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
