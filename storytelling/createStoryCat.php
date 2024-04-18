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
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/cRCatStyle.css">
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		<div class="createStory">
			<h1 class="createStoryHd">Begin Your Storytelling Journey!</h1>	
			<div class="cSHdDesignT">
				<div class="cSHdDesignT1"></div>
				<div class="cSHdDesignT2"></div>
				<div class="cSHdDesignT3"></div>
				<div class="cSHdDesignT4"></div>
				<div class="cSHdDesignT5"></div>
				<div class="cSHdDesignT6"></div>
				<div class="cSHdDesignT7"></div>
				<div class="cSHdDesignT8"></div>
				<div class="cSHdDesignT9"></div>
				<div class="cSHdDesignT10"></div>
				<div class="cSHdDesignT11"></div>
				<div class="cSHdDesignT12"></div>	
			</div>
			<div class="cSHdDesignM">
				<div class="cSHdDesignM1"></div>
				<div class="cSHdDesignM2"></div>
				<div class="cSHdDesignM3"></div>
				<div class="cSHdDesignM4"></div>
				<div class="cSHdDesignM5"></div>
				<div class="cSHdDesignM6"></div>
				<div class="cSHdDesignM7"></div>
				<div class="cSHdDesignM8"></div>
				<div class="cSHdDesignM9"></div>
				<div class="cSHdDesignM10"></div>
				<div class="cSHdDesignM11"></div>
				<div class="cSHdDesignM12"></div>	
			</div>
			
			<div class="cSHdDesignB">
				<div class="cSHdDesignB1"></div>
				<div class="cSHdDesignB2"></div>
				<div class="cSHdDesignB3"></div>
				<div class="cSHdDesignB4"></div>
				<div class="cSHdDesignB5"></div>
				<div class="cSHdDesignB6"></div>
				<div class="cSHdDesignB7"></div>
				<div class="cSHdDesignB8"></div>
				<div class="cSHdDesignB9"></div>
				<div class="cSHdDesignB10"></div>
				<div class="cSHdDesignB11"></div>
				<div class="cSHdDesignB12"></div>	
			</div>
			<div class="cSHdDesignBD">
				<div class="cSHdDesignBD1"></div>
				<div class="cSHdDesignBD2"></div>
				<div class="cSHdDesignBD3"></div>
				<div class="cSHdDesignBD4"></div>
				<div class="cSHdDesignBD5"></div>
				<div class="cSHdDesignBD6"></div>
				<div class="cSHdDesignBD7"></div>
				<div class="cSHdDesignBD8"></div>
				<div class="cSHdDesignBD9"></div>
				<div class="cSHdDesignBD10"></div>
				<div class="cSHdDesignBD11"></div>
				<div class="cSHdDesignBD12"></div>	
			</div>
		</div>
			<form class="storyCatForm" action="createStoryDetail.php" method="POST">
				<h2>Create a New Story</h2>
				<p class="instruction">Select any one</p>
				<div class="storyCat">
					<div class="storyCatPbl">
						<div class="storyCatPblRadio">
							<input type="radio" name="storyCategory" value="PUB" class="radioCustom" required checked> 
							<b class="catTtl">Public</b>
						</div>
						<p class="txt">Everyone Can Join in and Add to the Story</p>
					</div>
					<div class="storyCatPrv">
						<div class="storyCatPblRadio">
							<input type="radio" name="storyCategory" value="PVT" class="radioCustom" required> 
							<b class="catTtl">Private</b>
						</div>
						<p class="txt">Only Friends Invited Can Help Write the Story</p>
					</div>
				</div>
				<input type="submit" name="category" value="Next">
						
			</form>
		
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

