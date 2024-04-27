<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Collabora Tales</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/homepageStyle.css">
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
		
		<div class="homeCarousel">
			<div class="carouselCtn">
				<div class="mySlides fade">				
					<img src="img/bookPuzzle.png" class="topImg">
					<div class="text">Cultivate Creativity <br>Craft Stories Together</div>
				</div>
<?php
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$connection = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM Story ORDER BY DateTime DESC LIMIT 3";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result)>0) {
	
	while($row=mysqli_fetch_assoc($result)){
		$storyID = $row["StoryID"];
		$storyTitle = $row["Title"];
		$coverPage = $row["CoverPage"];
		
		echo	'<div class="mySlides fade">
					<img src="img/coverPage/'.$coverPage.'" class="topImg">
					<div class="text">'.$storyTitle.'</div>
				</div>';
		
	}
}
?>

				<a class="prev" onclick="plusSlides(-1, 0)">&#8249;</a>
				<a class="next" onclick="plusSlides(1, 0)">&#8250;</a>
			</div><br><br><br>

			<div style="text-align:center">
				<span class="dot" onclick="currentSlide(1, 0)"></span> 
				<span class="dot" onclick="currentSlide(2, 0)"></span> 
				<span class="dot" onclick="currentSlide(3, 0)"></span> 
				<span class="dot" onclick="currentSlide(4, 0)"></span> 
			</div>
		</div>
		<h1 class="welcomeTxt">Welcome to Our <br>Collaborative Storytelling Haven!</h1>
		<div class="about">
			<div class="abtHeading1">
				<p>Empowering Creativity</p>
			</div>
			
			<div class="abtCtn">
				<div class="abtCtnPic">
					<div class="abtDesignL">
						<div class="abtDesignL1"></div>
						<div class="abtDesignL2"></div>
						<div class="abtDesignL3"></div>
						<div class="abtDesignL4"></div>
						<div class="abtDesignL5"></div>
						<div class="abtDesignL6"></div>
					</div>
					<img src="img/teamwork.png">
				</div>
				<div class="abtCtnR">
					<div class="abtDesignR">
						<div class="abtDesignR1"></div>
						<div class="abtDesignR2"></div>
						<div class="abtDesignR3"></div>
						<div class="abtDesignR4"></div>
						<div class="abtDesignR5"></div>
						<div class="abtDesignR6"></div>
					</div>
					<div class="abtCtnTxt">
						<p>At Collabora Tales, we're all about making storytelling super exciting! We help you become an awesome storyteller by letting your creativity soar and making writing stories with friends a blast! Imagine creating adventures, solving mysteries, and crafting magical tales together it's all here!</p>
					</div>	
				</div>
			</div>
			
			<div class="abtHeading2">
				<p>Fostering Connection</p>
			</div>
		</div>
		
		<div class="searchStory">
			<h3>Explore Existing Stories</h3>
			<div class="SSContainer">
				<div class="SSTtlContainer">
					<div class="SSDesign"> 
						<div class="SSTtl1R"></div>
						<div class="SSTtl11">Journey </div>
					</div>
					<div class="SSDesign">
						<div class="SSTtl12">Through </div>
						<div class="SSTtl2R"></div>
					</div>
					<div class="SSDesign">
						<div class="SSTtl3R"></div>
						<div class="SSTtl13">Tales</div>
					</div>
				</div>
				<div class="homeCarousel">
<?php
$query = "SELECT * FROM Story ORDER BY DateTime DESC LIMIT 6";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
  $slideCount = 0; // Counter for slide number
  $storyInSlide = 0; // Counter for stories within a slide

  echo '<div class="carouselCtn2">';

  while ($row = mysqli_fetch_assoc($result)) {
    $storyID = $row["StoryID"];
    $storyTitle = $row["Title"];
    $coverPage = $row["CoverPage"]; 
    if ($storyInSlide === 0 || $storyInSlide % 3 === 0) {
      echo '<div class="mySlides2 fade">';
      echo '<div class="storyCtn">';
      $slideCount++;
    }

    echo '<div class="storyCtn1">';
    echo "<img src='img/coverPage/$coverPage'>"; 
    echo "<div class='text2'>$storyTitle</div>"; 
    echo '</div>';

    $storyInSlide++;

    if ($storyInSlide % 3 === 0) {
      echo '</div>'; 
      echo '</div>'; 
    }
  }

  if ($storyInSlide % 3 !== 0) {
    echo '</div>'; 
    echo '</div>'; 
  }

}
?>
				<a class="prev" onclick="plusSlides(-1, 1)">&#8249;</a>
                <a class="next" onclick="plusSlides(1, 1)">&#8250;</a>
            </div><br>
            <div style="text-align:center">
                <span class="dot2" onclick="currentSlide(1, 1)"></span> 
                <span class="dot2" onclick="currentSlide(2, 1)"></span> 
  
            </div>
		</div>
			</div>
		</div>	
		

	<br>
		<div class="register">
			<div class="registerHd">
				<div class="registerHdDsg1"></div>
				<div class="registerHdDsg2"></div>
				<div class="registerHdDsg3"></div>
				<h3>Unlock Your <br>Storytelling Journey</h3>
			</div>
			<div class="registerCtn">
				<div class="registerCtnTxt">
					<p>Ready to dive into endless storytelling adventures? By registering with Collabora Tales, you unlock a world of creativity, where you can create your stories, cast votes, and embark on exciting journeys with fellow storytellers!<br><br>
					Signing up opens doors to more fun and allows you to be a part of the storytelling magic. Join our community of young writers, create your imaginative tales, and help shape amazing stories together.</p>
				</div>
				<div class="registerCtnImg">
					<img src="img/storiesClipart.png">
				</div>
			</div>
				<a href="<?=isset($_SESSION['login'])?"":"signup.php"?>" class="registerBtn">Register for Exclusive Adventures &gt;&gt;</a>
			
		</div>
	

	
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


