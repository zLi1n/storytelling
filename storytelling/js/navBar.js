let header = document.getElementById("header");
let footer = document.getElementById("footer");
let topBtn = document.getElementById("topBtn");
let dropdown = document.getElementsByClassName("dropdownBtn");

function disHeader(){
	header.innerHTML = `
		<div class="headerLeft">
			<a href="homepage.php" class="logo"><img src="img/strtellingLogo.png" class="logo"></a>
			<div class="ctn">
				<a href="about.php">Aboout Us</a>
				<a href="readStoryMain.php">Read Stories</a>
				<a href="login.php" id="writeStoryMainLink">Write Story</a>
			</div>
		</div>
		<div class="headerRight">
			<div class="rightnav">
				<div class="menu">
					<span class="material-symbols-outlined" onclick="openMenu()">menu</span>
				</div>
				<div class="iconli" id="iconli">
					<a href="login.php" class="loginSignin">
						Sign In
					</a>
				</div>
				<div class="iconli" id="loginChange">
					<a href="signup.php" class="loginSignin">
						Sign Up
					</a>
				</div>				
			</div>
			<div id="sidenav" class="sidemenu">
				<a href="javascript:void(0)" class="closebtn" onclick="closeMenu()">&times;</a>
				<a href="homepage.php" class="menulogo"><img src="img/strtellingLogoRound.png" class="menulogo"></a>
				<div class="sidemenuContent">
					<a href="about.php">About Us</a>				
					<a href="readStoryMain.php">Read Stories</a>
					<a href="login.php" id="writeStoryMainLink">Write Story</a>
					<div id="iconli">
					<a href="login.php" class="loginSignin">
						Login
					</a>
				</div>
				<div id="loginChange">
					<a href="signup.php" class="loginSignin">
						Sign In
					</a>
				</div>
				
				</div>
			</div>		
		</div>	
		`;
}
disHeader();
function openMenu() {
	document.getElementById("sidenav").style.width = "100%";
}

function closeMenu() {
	document.getElementById("sidenav").style.width = "0%";
}

function disFooter(){
	footer.innerHTML = `
		<div class="footerCtn">
			<div class="cloudGrid">
				<div class="cloud">
					<div class="cloud1"></div>
					<div class="cloudR"></div>
				</div>
				<div class="cloud">
					<div class="cloud2"></div>
					<div class="cloudR"></div>
				</div>
				<div class="cloud">
					<div class="cloud3"></div>
					<div class="cloudR"></div>
				</div>
			</div>
			<div class="contain">
				<a href="homepage.php" class="logo"><img src="img/logoWithBg.png"></a>
				
				<div class="leftContain">
					<a href="#fb" class="fa fa-facebook"></a>
					<a href="#twi" class="fa fa-twitter"></a>
					<a href="#ig" class="fa fa-instagram"></a>				
				</div>
			</div>
		</div>
		
		<div class="footerCtn">
		<div class="containMdl">
			<h3 class="footerBtnTtl">Register for <br> Limitless Adventures!</h3>
			<a href="signup.php" class="footerBtn" id="footerSignup">Unlock Creativity Now</a>	
		</div></div>

		<div class="footerCtn">
			<div class="cloudGridRgt">
				<div class="cloudRgtCtn1">
					<div class="cloudRgt1"></div>
					<div class="cloudRgt2"></div>
				</div>
				<div class="cloudRgtCtn">
					<div class="cloudRgt3"></div>
					<div class="cloudRgt4"></div>
				</div>
				
			</div>
			<div class="containR">
				<h4 class="infoLinkTtl">Express Your Imagination<br>Quickly & Easily!</h4>
				<p><a href="about.php" class="infoLink">About Us</a></p>
				<p><a href="signup.php" class="infoLink" id="writeStoryMainLink">Create Story</a></p>
				<p><a href="readStoryMain.php" class="infoLink">Read Story</a></p>
			</div>
		</div>
		
		<div class="copyright">
			<p>&copy; 2024 CollabTales. All rights reserved.</p>
		</div>
	`;
}
disFooter();

function updateLoginLinkU() {
   
    var writeStoryMainLink = document.querySelectorAll("#writeStoryMainLink");
	var loginChange = document.querySelectorAll("#loginChange");
	var iconChange = document.querySelectorAll("#iconli");
	var footerCreateLink = document.getElementById("footerSignup");
	if (loginChange) {
		for (let i = 0; i < loginChange.length; i++){
			loginChange[i].innerHTML = `
						<a href="userProfile.php" class="icon" id="loginLink">
							<span class="material-symbols-outlined" >account_circle</span>
						</a>
					`;  
		}
    }
	if (iconChange) {
		for (let i = 0; i < iconChange.length; i++){
			iconChange[i].innerHTML = `
						<a href="createStoryCat.php" class="icon" id="writeStoryLink">
							<span class="material-symbols-outlined">add_circle</span>
						</a>
					`;  
		}
    }

    if (writeStoryMainLink) {
		for (let i = 0; i < writeStoryMainLink.length; i++){
			writeStoryMainLink[i].href = "createStoryMain.php";
		}
	}
	if (footerCreateLink) {
        footerCreateLink.href = "userProfile.php";
    }
}

function updateLoginLinkA() {
    var writeStoryMainLink = document.querySelectorAll("#writeStoryMainLink");
	var loginChange = document.querySelectorAll("#loginChange");
	var iconChange = document.querySelectorAll("#iconli");
	var footerCreateLink = document.getElementById("footerSignup");
	if (loginChange) {
		for (let i = 0; i < loginChange.length; i++){
			loginChange[i].innerHTML = `
						<a href="adminProfile.php" class="icon" id="loginLink">
							<span class="material-symbols-outlined" >account_circle</span>
						</a>
					`;  
		}
    }
	if (iconChange) {
		for (let i = 0; i < iconChange.length; i++){
			iconChange[i].innerHTML = `
						<a href="createStoryCat.php" class="icon" id="writeStoryLink">
							<span class="material-symbols-outlined">add_circle</span>
						</a>
					`;  
		}
    }

    if (writeStoryMainLink) {
		for (let i = 0; i < writeStoryMainLink.length; i++){
			writeStoryMainLink[i].href = "createStoryMain.php";
		}
	}
	if (footerCreateLink) {
        footerCreateLink.href = "adminProfile.php";
    }
}

function disTopBtn(){
	topBtn.innerHTML = `
		<button onclick="topFunction()" id="top" title="Go to top"><span class="material-symbols-outlined">
		arrow_upward
		</span></button>
	`;
}
disTopBtn();

let button = document.getElementById("top");
window.addEventListener("scroll", function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      button.style.display = "block";
    } else {
      button.style.display = "none";
    }
});

function topFunction() {
	document.body.scrollTop = 0;
	document.documentElement.scrollTop = 0;
}
let slideIndex = [1, 1];
let slideId = ["mySlides", "mySlides2"];

showSlides(1, 0);
showSlides(1, 1);

function plusSlides(n, no) {
    showSlides(slideIndex[no] += n, no);
}

function currentSlide(n, no) {
    showSlides(slideIndex[no] = n, no);
}

function showSlides(n, no) {
    let i;
    let x = document.getElementsByClassName(slideId[no]);
    if (n > x.length) { slideIndex[no] = 1 }
    if (n < 1) { slideIndex[no] = x.length }
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex[no] - 1].style.display = "block";
}

function autoShowSlides() {
    for (let i = 0; i < slideId.length; i++) {
        showSlides(slideIndex[i], i);
        slideIndex[i]++;
        if (slideIndex[i] > document.getElementsByClassName(slideId[i]).length) {
            slideIndex[i] = 1;
        }
    }
    setTimeout(autoShowSlides, 10000); 
}

autoShowSlides();