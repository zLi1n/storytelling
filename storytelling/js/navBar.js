let header = document.getElementById("header");
let footer = document.getElementById("footer");
let topBtn = document.getElementById("topBtn");
let dropdown = document.getElementsByClassName("dropdownBtn");
//menu on top
var account = "login.php";
 
/*if (check == "1"){
	account = "userAccount.php";
}
if (check == "2"){
	account = "adminAccount.php";
	<a href="`+account+`" class="icon">
}*/
function disHeader(){
	header.innerHTML = `
		<div class="headerLeft">
			<a href="homepage.php" class="logo"><img src="img/strtellingLogo.png" class="logo"></a>
			<div class="ctn">
				<a href="about.php">Aboout Us</a>
				<a href="">Read Stories</a>
				<a href="createStoryMain.php">Write Story</a>
			</div>
		</div>
		<div class="headerRight">
			<div class="rightnav">
				<div class="menu">
					<span class="material-symbols-outlined" onclick="openMenu()">menu</span>
				</div>
				<div class="iconli">
					<a href="createStoryCat.php" class="icon">
						<span class="material-symbols-outlined">add_circle</span>
					</a>
				</div>	
				<div class="iconli">
					<a href="`+account+`" class="icon">
						<span class="material-symbols-outlined" >account_circle</span>
					</a>
				</div>					
			</div>
			<div id="sidenav" class="sidemenu">
				<a href="javascript:void(0)" class="closebtn" onclick="closeMenu()">&times;</a>
				<a href="homepage.php" class="menulogo"><img src="img/strtellingLogoRound.png" class="menulogo"></a>
				<div class="sidemenuContent">
					<a href="about.php">About Us</a>				
					<a href="">Read Stories</a>
					<a href="">Write Story</a>
					<a href="`+account+`" class="icon">
						<span class="material-symbols-outlined">add_circle</span>
					</a>					
					<a href="`+account+`" >
						<span class="material-symbols-outlined" >account_circle</span>
					</a>
				
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


//footer
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
			<a href="" class="footerBtn">Unlock Creativity Now</a>	
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
				<p><a href="" class="infoLink">Create Story</a></p>
				<p><a href="" class="infoLink">Vote for Stories</a></p>
				<p><a href="" class="infoLink">Contribute to Stories</a></p>
			</div>
		</div>
		
		<div class="copyright">
			<p>&copy; 2024 CollabTales. All rights reserved.</p>
		</div>
	`;
}
disFooter();



function disTopBtn(){
	topBtn.innerHTML = `
		<button onclick="topFunction()" id="top" title="Go to top"><span class="material-symbols-outlined">
		arrow_upward
		</span></button>
	`;
}
disTopBtn();
//show back to top button when scroll down
let button = document.getElementById("top");
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		button.style.display = "block";
	} else {
		button.style.display = "none";
	}
}

//scroll to the top when click on the button
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
    setTimeout(autoShowSlides, 10000); // Change image every 10 seconds
}

//autoShowSlides();






