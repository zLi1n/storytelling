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
date_default_timezone_set("Asia/Kuala_Lumpur");
if(isset($_REQUEST['publishComment'])){
	if(isset($_SESSION['email'])){
		$chapterID = $_REQUEST['chapID'];
		$email = $_SESSION['email'];
		if(!empty($_REQUEST['comment'])){
			$comment = filterText($_REQUEST['comment']);
			$dateTime = date("Y-m-d H:i:s");
			//echo $chapterID."<br>".$email."<br>".$_REQUEST['comment']."<br>".$comment."<br>".$dateTime;
			$connection = mysqli_connect("localhost", "root", "", "storytelling");
			if (!$connection) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$query = "SELECT MAX(CommentID) as maxID FROM Comment";
			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			$latestID = $row['maxID'];

			$nextStoryID = $latestID + 1;
			while (substr($nextStoryID, 0, 1) !== '5') {
				$nextStoryID++;
			}
			
			$commentQuery = "INSERT INTO Comment (CommentID, Email, ChapterID, CommentText, DateTime)
					VALUES ($nextStoryID, '$email', $chapterID, '$comment', '$dateTime')";
					echo $commentQuery;
			$commentResult = mysqli_query($connection, $commentQuery);
			if($commentResult){?>
			<form action="chapterContain.php" method="POST" id="form">
				<input type="hidden" name="chapterRead" value="<?=$chapterID?>">
			</form>
			<script>
			var form = document.getElementById('form')
			form.submit();
			</script>
			<?php
				
			}else
				die("Post Comment Failed: " . mysqli_connect_error());
			mysqli_close($connection);
		}else{
			$_SESSION['errorMsg']['comment'] = "<span class='material-symbols-outlined'>info</span> Cannot be empty";?>
			<form action="chapterContain.php" method="POST" id="form">
				<input type="hidden" name="chapterRead" value="<?=$chapterID?>">
			</form>
			<script>
			var form = document.getElementById('form')
			form.submit();
			</script>
			<?php
		}
	}else
		header("location:login.php");
}

?>


