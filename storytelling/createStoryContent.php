<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Create Story</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/cRContentStyle.css">
		<link rel="stylesheet" href="css/firepad_userlist.css">
		  <!-- Firebase -->
		  <script src="https://www.gstatic.com/firebasejs/5.5.4/firebase.js"></script>
		  <!-- CodeMirror -->
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/codemirror.js"></script>
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/codemirror.css" />
		  <!-- Firepad -->
		  <link rel="stylesheet" href="https://firepad.io/releases/v1.5.9/firepad.css" />
		  <script src="https://firepad.io/releases/v1.5.9/firepad.min.js"></script>
	</head>
	<body class="homepage" onload="init()">
		 <div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		
<?php if(isset($_POST['chapterID'])){
	function disMsg($sN,$n){
	echo isset($_SESSION["$sN"]["$n"]) ? $_SESSION["$sN"]["$n"] : '';
	}
	
	$connection = mysqli_connect("localhost", "root", "", "storytelling");
	$chapterID = $_POST['chapterID'];
	$chapQuery = "SELECT * FROM Chapter WHERE ChapterID = $chapterID";
	$chapResult = mysqli_query($connection, $chapQuery);
	if (mysqli_num_rows($chapResult)>0) {
			$row = mysqli_fetch_assoc($chapResult);
			$chapterName = $row['ChapterName'];
			$storyID = $row['StoryID'];
			$chapterContent = $row['Content'];
			$chapterEnding = $row['Ending'];
			$status = $row['Status'];
		}
	?>		
		<form class="firepadContentForm" id="firepadContentForm" method="post" action="fetchContent.php">
		<div class="btnGrp">
		<div class="backArr">
		<a href="<?=isset($_POST['editChapter'])?"addChapter.php?read=$chapterID&bookID=$storyID":"createStoryMain.php"?>"><span class="material-symbols-outlined">arrow_back</span></a>
		</div>
		<div>
			<button id="saveButton" type="submit" name="action" value="save" class="btn"><i class="fa fa-save"></i> Save</button>
			<?php
			if ($status == "D")
				echo '<button id="publishButton" type="submit" name="action" value="publish" class="btn"><i class="fa fa-upload"></i> Publish</button>';
			?>
		</div>
		</div>
		<div class="chapterInput">
			<input type="text" name="chapterTtl" placeholder="<?=isset($_POST['error'])?$_POST['error']:"Enter a Chapter Title"?>" class="chapterTtl"value="<?=!empty($chapterName)?$chapterName:""?>" required>
			
			<input type="hidden" id="text" name="firepadContent">
			<input type="hidden" id="firepadContentUrl" name="firepadContentUrl">
			<input type="hidden" name="chapterID" value="<?=$chapterID?>">
			</div>
			<span class="errMsg2"><span class="material-symbols-outlined">error</span>Chapter title only allows letters, numbers, and these symbols: #$%&*+-\/?!\@.:;"(){}[]~&</span>
			<div class="ending">
			<span class="endingGrp">Does this chapter finish the story? </span>
			<span class="endingGrp"><input type="radio" name="ending" value="1" class="radioCustom" <?=$chapterEnding == 0? "": "checked";?>>Yes </span>
			<span class="endingGrp"><input type="radio" name="ending" value="0" class="radioCustom" <?=$chapterEnding == 0? "checked": "";?>>No </span>
			</div>
		</form>

		<div class="textContainer">
			<button id="inviteButton" class="inviteBtn"><i class="fa fa-user-plus"></i> Invite</button>
			<div id="userlist"></div>
			<div id="firepad"></div>
		</div>
		
		<div id="inviteContain" class="inviteContain">
			<div class="inviteContent">
				<span class="close">&times;</span>
					<form class="inviteForm" method="post" action="fetchContent.php" id="inviteForm">
					<h1>Let's Collab!</h1>
					<span>Invite Your Friends to Write a Story Together</span>
						<div><b>Your Friend's Email: </b>
						<input type="email" name="reciverEmail" class="emailInput" placeholder="john@example.com" value="<?=isset($_SESSION['inviteMessage']['reciverEmail'])?$_SESSION['inviteMessage']['reciverEmail']:""?>"required></div>
						<span class="errMsg2" id="errMsg"><span class="material-symbols-outlined">error</span>This email is not associated with a registered user.</span>
						<span class="successMsg" id="successMsg"><span class="material-symbols-outlined">check_circle</span>The invitation is successfully sended.</span>
						<input type="hidden" id="inviteContentUrl" name="firepadContentUrl">
						<input type="hidden" name="chapterID" value="<?=$chapterID?>">
						<button id="invite" type="submit" name="invite" value="invite" class="inviteBtn"><i class="fa fa-user-plus"></i> Invite</button>
					</form>
				</div>
			</div>

<?php } ?>	
		<footer class="footer" id="footer"></footer>
	
	<script src="js/navBar.js"></script>			
	<script>
	<?php

	if (isset($_SESSION['login'])){
		$email = $_SESSION["email"];
		$sql="SELECT Username FROM user WHERE email='$email';";
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_assoc($result);
			$username = $row['Username'];
		}
		echo "sessionStorage.login = '" . $username . "';";
		
		if ($_SESSION['login'] == '1') {
            echo 'updateLoginLinkU();';
        } else if ($_SESSION['login'] == '2') {
            echo 'updateLoginLinkA();';
        }
	}
    ?>
var modal = document.getElementById("inviteContain");
var btn = document.getElementById("inviteButton");
var span = document.getElementsByClassName("close")[0];
var inviteError = document.getElementById("errMsg");
var inviteSuccess = document.getElementById("successMsg");
btn.onclick = function() {
  modal.style.display = "block";
  inviteError.style.display = "none";
  inviteSuccess.style.display = "none";
}
span.onclick = function() {
  modal.style.display = "none";
  inviteError.style.display = "none";
  inviteSuccess.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
	inviteError.style.display = "none";
	inviteSuccess.style.display = "none";
  }
}
<?php
if (isset ($_SESSION['inviteMessage']['error'])){ ?>
	modal.style.display = "block";
	inviteError.style.display = "block";
<?php 
}else if(isset($_SESSION['inviteMessage']['success'])){	 ?>
	modal.style.display = "block";
	inviteSuccess.style.display = "block";
<?php 
}
unset($_SESSION['inviteMessage']);

if (isset($_SESSION['inviteMessage']['save'])) { ?>
	alert("Your changes are saved and ready to go!"); 
<?php
    unset($_SESSION['inviteMessage']['save']);
}
?>
var chapterTtlInput = document.querySelector('.chapterTtl');

var allowedChars = /^[a-zA-Z0-9,#$\%\+\-\*\/\?\!\@\.\:\;\"\'\(\)\{\}\[\]\_\~\&\s]+$/;

chapterTtlInput.addEventListener('input', function() {
  if (!allowedChars.test(this.value)) {
    document.querySelector('.errMsg2').style.display = 'block';
     this.value = this.value.replace(/[^a-zA-Z0-9,#$\%\+\-\*\/\?\!\@\.\:\;\"\'\(\)\{\}\[\]\_\~\&\s]/g, '');
  } else {
    document.querySelector('.errMsg2').style.display = 'none';
  }
});

</script>
<script src="js/firepad_userlist.js"></script>
<script>
    function init() {
      //// Initialize Firebase.
      //// TODO: replace with your Firebase project configuration.
	  	  if (typeof window.sessionStorage['login'] !== 'undefined') {
		  var config = {
			 apiKey: "AIzaSyC4vlR9SpL0v3sYmxTA9M2O1BJRxwaBTPI",
		authDomain: "storytelling-384d1.firebaseapp.com",
			databaseURL: "https://storytelling-384d1-default-rtdb.firebaseio.com/"
		  };
		   firebase.initializeApp(config);

		  //// Get Firebase Database reference.
		  var firepadRef = getExampleRef();


		// Create CodeMirror (with lineWrapping on).
		var codeMirror = CodeMirror(document.getElementById('firepad'), { lineWrapping: true });

		  // Create a random ID to use as our user ID (we must give this to firepad and FirepadUserList).
		  var userId = Math.floor(Math.random() * 9999999999).toString();

		  //// Create Firepad (with rich text features and our desired userId).
		  var firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
			  { richTextToolbar: false, richTextShortcuts: false, userId: userId});

		  //// Create FirepadUserList (with our desired userId).
		  var firepadUserList = FirepadUserList.fromDiv(firepadRef.child('users'),
			  document.getElementById('userlist'), userId);
<?php
	if(isset($_POST["contentBack"])){
		$content = $_POST['contentBack'];
	}else{
		if(!empty($chapterContent))
			$content = $chapterContent;
		else
			$content = "Type your content here!";
	}
	mysqli_close($connection);
?>
		  //// Initialize contents.
		  firepad.on('ready', function() {
			firepad.setText(`<?=$content?>`);
			
			var firepadContentUrlInput = document.getElementById('firepadContentUrl');
			var firepadContentForm = document.getElementById('firepadContentForm');
			var formSubmitted = false;
			firepadContentForm.addEventListener('submit', function(event) {
				event.preventDefault();
				var firepadContent = firepad.getText();
				document.getElementById('text').value = firepadContent; 
				var firepadContentUrl = window.location.hash.substring(1);
				//console.log("Fragment Identifier:", firepadContentUrl);
				firepadContentUrlInput.value = firepadContentUrl; 
				var clickedButton = event.submitter; 
				var action = clickedButton.value;
				var actionInput = document.createElement('input');
				actionInput.type = 'hidden';
				actionInput.name = 'action';
				actionInput.value = action;
				firepadContentForm.appendChild(actionInput);
				formSubmitted = true;
				firepadContentForm.submit(); 
			});
			
			var inviteForm = document.getElementById('inviteForm');
			var firepadContentUrlInvite = document.getElementById('inviteContentUrl');

			inviteForm.addEventListener('submit', function(event) {
			  event.preventDefault(); 

			  var inviteContentUrl = window.location.hash.substring(1);
			  firepadContentUrlInvite.value = inviteContentUrl;
				var clickedButton = event.submitter; 
				var action = clickedButton.value;
				var actionInput = document.createElement('input');
				actionInput.type = 'hidden';
				actionInput.name = 'invite';
				actionInput.value = 'invite';
				inviteForm.appendChild(actionInput);
			   inviteForm.submit();
			});

				window.onbeforeunload = function(e) {
					if (!formSubmitted) {
						e.preventDefault();
						e.returnValue = ''; 
						return 'You have unsaved changes. Are you sure you want to leave?';
					}
					return;
			};
			
		  });
		  		
		  	
	  }else {
    window.location.href = "login.php";
  }
    }
	

</script>	
			
</body>

</html>

