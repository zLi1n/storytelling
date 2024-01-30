<?php 
	/*session_start();
	if(!empty($_SESSION["login"])){
		$test = $_SESSION["login"];
	}
	else $test = "0";*/
?>
<script> 
	/*var check = <?=$test?>;*/
</script>

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
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		
			<form class="storyForm" action="">
				<div class="storyDtl">
					<div class="groupBtn">
						<span class="submitBtn"><span class="material-symbols-outlined">person_add</span><button class="invite" id="invite">Invite</button></span>
						<span class="submitBtn"><span class="material-symbols-outlined">save</span><input type="submit" name="save" class="save" value="Save"></span>
						<span class="submitBtn"><span class="material-symbols-outlined">publish</span><input type="submit" name="publish" value="Publish"></span>
					</div>
					<div class="ttl">
						<input type="text" name="chapTtl" placeholder="Enter a title" required > 
					</div>
					<div class="nav">
						<a class="back" href="createStoryMain.php"><span class="material-symbols-outlined">arrow_back</span></a>
					</div>					
				</div>	
				<div class="storyCtn">
					<span class="input-wrap">
					<span class="width-machine" ariahidden="true"></span><input class="input" value="99" type="hidden">
					<textarea class="textarea resize-ta" name="chapCtn" ></textarea> 
				</div>						
			</form>
			
			<div class="inviteContainer">
			<div class="inviteContain">
			<span class="close">&times;</span>
				<form class="inviteForm">
					<input type="email" name="reciverEmail">
					<span class="submitBtn"><span class="material-symbols-outlined">person_add</span><input type="submit" name="invite" class="inviteSubmit"></span>
				</form>
			</div>
			</div>
		
		<footer class="footer" id="footer">
			
		</footer>
	
	<script src="js/navBar.js"></script>
	<script>
// Dealing with Input width
let el = document.querySelector(".input-wrap .input");
let widthMachine = document.querySelector(".input-wrap .width-machine");
el.addEventListener("keyup", () => {
  widthMachine.innerHTML = el.value;
});

// Dealing with Textarea Height
function calcHeight(value) {
  let numberOfLineBreaks = (value.match(/\n/g) || []).length;
  // min-height + lines x line-height + padding + border
  let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
  return newHeight;
}
function calcBgHeight(value) {
  let numberOfLineBreaks = (value.match(/\n/g) || []).length;
  if(numberOfLineBreaks>23){
  // min-height + lines x line-height + padding + border
  let newHeight = 550 + (numberOfLineBreaks-23) * 20 + 12;
  return newHeight;
  }
}
let textarea = document.querySelector(".resize-ta");
let storyCtn = document.querySelector(".storyCtn");
textarea.addEventListener("keyup", () => {
  textarea.style.height = calcHeight(textarea.value) + "px";
  storyCtn.style.height = calcBgHeight(textarea.value) + "px";
});

	</script>
</body>

</html>

