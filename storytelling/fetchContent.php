<?php
session_start();
function filterText($text) {
    $badPatterns = [
        "/<[^>]*>/", 
        "/\|\|/",    
        "/&&/",      
        "/\\\\/",   
    ];

    foreach ($badPatterns as $pattern) {
        $text = preg_replace($pattern, "*", $text);
    }

    $badWords = [
        "damn", "crap", "idiot", "fool", "jerk", "moron", "stupid", "loser", 
        "dumbass", "bitch", "fuck", "shit", "asshole", "bastard", "cock", 
        "dick", "piss", "cunt", "twat", "arsehole"
    ];

    $badWordsRegex = '/\b' . implode('\b|\b', array_map('preg_quote', $badWords)) . '\b/i';

    $text = preg_replace($badWordsRegex, "*", $text);
	
	  $text = str_replace([
		'"', 
		"'", 
	  ], [
		'\\"',
		"\\'",
	  ], $text);

	  $text = preg_replace('/(?<!\\\\)"([^"]*)\\\'([^"]*)(?<!\\\\)"/', '"\1\' \2"', $text);

    return $text;
}
	$connection = mysqli_connect("localhost", "root", "", "storytelling");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
	
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action'])) {
	  $chapterID = $_POST['chapterID']; 
	  $action = $_POST['action']; 
	  if($action == "save")
		  $status = "D";
	  else if($action == "publish")
		  $status = "P";
	  
	$ending = $_POST['ending'];
	
    $firepadContent = $_POST['firepadContent'];
	
	$content = filterText($firepadContent);
	
	$firepadContentUrl = $_POST['firepadContentUrl'];
	
	$chapTtl = $_POST['chapterTtl'];
	$allowedCharsRegex = "/^[^\s]([a-zA-Z0-9,#$\%\+\-\*\/\?\!\@\.\:\;\"\'\(\)\{\}\[\]\_\~\&\s]*)$/";
	  if (preg_match($allowedCharsRegex, $chapTtl)) {
		$chapterName = filterText($chapTtl);
	  } else {
		  ?>
		  <form method="post" action="createStoryContent.php#<?=$firepadContentUrl?>" id="detailForm">
				<input type="hidden" name="chapterID" value="<?=$chapterID?>">
				<input type="hidden" name="contentBack" value="<?=$firepadContent?>">
				<input type="hidden" name="error" value="Chapter title cannot start with a space">
			</form>
			<script>
				document.getElementById("detailForm").submit();
			</script>
		<?php
	  }

	date_default_timezone_set("Asia/Kuala_Lumpur");
	$dateTime = date("Y-m-d H:i:s");
	$sql = "UPDATE Chapter SET ChapterName = '$chapterName', Content = '$content', Status = '$status', Ending = $ending, DateTime =  '$dateTime' WHERE ChapterID = $chapterID";
	$result = mysqli_query($connection, $sql);
	if($result){
		if($action == "save"){
			$_SESSION['inviteMessage']['save'] = true;
		  ?>
		  <form method="post" action="createStoryContent.php#<?=$firepadContentUrl?>" id="naviForm">
				<input type="hidden" name="chapterID" value="<?=$chapterID?>">
			</form>
			<script>
				document.getElementById("naviForm").submit();
			</script>
		<?php
		}else if($action == "publish"){
			$_SESSION['inviteMessage']['publish'] = true;
		  header("location:createStoryMain.php");
		}
	}else
		die("Failed: " . mysqli_connect_error());
  }  
  
  if(isset($_POST['invite'])){
	$invite = $_POST['invite'];
	$reciverEmail = $_POST['reciverEmail'];
	$chapterID = $_POST['chapterID']; 
	$firepadContentUrl = $_POST['firepadContentUrl'];
	$email = $_SESSION['email'];
	echo $invite."<br>".$reciverEmail."<br>".$chapterID."<br>".$firepadContentUrl."<br>".$email."<br>";
	$sql = "SELECT Email FROM User WHERE Email = '$reciverEmail'";
    $result = mysqli_query($connection, $sql);
	if(mysqli_num_rows($result)>0){
		$inviteQuery = "SELECT MAX(InvitationID) as maxInviteID FROM invitation";
		$inviteResult = mysqli_query($connection, $inviteQuery);
		$inviteRow = mysqli_fetch_assoc($inviteResult);
		$latestInviteID = $inviteRow['maxInviteID'];

		$nextInviteID = $latestInviteID + 1;
		while (substr($nextInviteID, 0, 1) !== '7') {
			$nextInviteID++;
		}
		echo $nextInviteID."<br>";
		$sql = "INSERT INTO Invitation (InvitationID, SenderEmail, ReceiverEmail, ChapterID, Link)
		VALUES ($nextInviteID, '$email', '$reciverEmail', $chapterID, '$firepadContentUrl')";
		$result = mysqli_query($connection, $sql);
		if($result){
			$_SESSION['inviteMessage']['success'] = true;
			  ?>
			  <form method="post" action="createStoryContent.php#<?=$firepadContentUrl?>" id="inviteForm">
					<input type="hidden" name="chapterID" value="<?=$chapterID?>">
				</form>
				<script>
					document.getElementById("inviteForm").submit();
				</script>
			<?php
			
		}else
			die("Failed: " . mysqli_connect_error());
	}else{
		$_SESSION['inviteMessage']['error'] = true;
		$_SESSION['inviteMessage']['reciverEmail'] = $reciverEmail;
		 ?>
		  <form method="post" action="createStoryContent.php#<?=$firepadContentUrl?>" id="inviteBackForm">
				<input type="hidden" name="chapterID" value="<?=$chapterID?>">
			</form>
			<script>
				document.getElementById("inviteBackForm").submit();
			</script>
		<?php
	}
  }
}

mysqli_close($connection);
/*$connection = mysqli_connect("localhost", "root", "", "storytelling");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
	

			
    // Insert the Firepad content into your database
    // Example query to insert data (make sure to sanitize the data to prevent SQL injection)
    // $sql = "SELECT Email FROM User WHERE Email = $reciverEmail";
    // mysqli_query($connection, $sql);*/
?>
