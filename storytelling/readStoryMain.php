<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Read Story</title>
		<link rel="icon" type="x-icon" href="img/favicon_io/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/headerFooterstyle.css">
		<link rel="stylesheet" href="css/rSMainStyle.css">
		<script src= "https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
		
		
	</head>
	<body class="homepage">
		<div class="header" id="header"></div>
		
		<div class="topBtn" id="topBtn"></div>
			<h2 class="rSHeading"><strong>Dive into the World of Stories</strong></h2>
<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
	
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}

$genreSql = "SELECT * FROM genre";
$genreRun = mysqli_query($connection, $genreSql);
$themeSql = "SELECT * FROM theme";
$themeRun = mysqli_query($connection, $themeSql);

function checkSelectedGenre($v){
	if(isset($_SESSION['selectedGenres'])){
        return in_array($v, $_SESSION['selectedGenres']) ? 'checked' : '';
    }
    return '';
}
function checkSelectedTheme($v){
	if(isset($_SESSION['selectedTheme'])){
        return in_array($v, $_SESSION['selectedTheme']) ? 'checked' : '';
    }
    return '';
}
?>



<div class="container">
<div class="genreContainer">
	<div class="genreCtn">Genre:</div>
	<form action="readStoryMainFilter.php" method="POST">
		<div class="form">
			<div id="myMultiselect" class="multiselect">
				<div id="mySelectLabel" class="selectBox" onclick="toggleCheckboxArea()">
					<select id="formSelectGenre">
						<option>
							<?php
								if (isset($_SESSION['selectedGenres'])){
								if (count($_SESSION['selectedGenres'])>0)
									echo implode(', ', $_SESSION['selectedGenres']);
								}
							?>
						</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="selectOptions">
					<div id="mySelectOptions">
						<label for="all"><input type="checkbox" class="genre" id="all" onchange="checkboxStatusChange()" onclick="toggle(this);" name="genre[]" value="All" <?=checkSelectedGenre('all');?>/> all checked</label>
					<?php
						while ($genre = mysqli_fetch_array($genreRun)) {
						echo '<label for="'.$genre['GenreID'].'"><input type="checkbox" class="genre" id="'.$genre['GenreID'].'" onchange="checkboxStatusChange()" name="genre[]" value="'.$genre['GenreDetail'].'" '.checkSelectedGenre($genre['GenreDetail']).'> '.$genre['GenreDetail'].'</label>';
					}
					?>
					</div>
					<input type="submit" name="submitGenre" value="Confirm" class="dropdownSubmit">
				</div>
			</div>
		</div>
	</form>
</div>

<div class="themeContainer">
	<div class="themeCtn">Theme:</div>
	<form action="readStoryMainFilter.php" method="POST">
		<div class="form">
			<div id="myMultiselectTheme" class="multiselect">
				<div id="mySelectLabelTheme" class="selectBox" onclick="toggleCheckboxAreaTheme()">
					<select id="formSelectTheme">
						<option>
							<?php
								if (isset($_SESSION['selectedTheme'])){
									if (count($_SESSION['selectedTheme'])>0)
										echo implode(', ', $_SESSION['selectedTheme']);
								}
							?>
						</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="selectOptionsTheme">
					<div id="mySelectOptionsTheme">
						<label for="allTheme"><input type="checkbox" class="theme" id="allTheme" onchange="checkboxStatusChangeTheme()" onclick="toggleTheme(this);" name="theme[]" value="All" <?=checkSelectedTheme('allTheme');?>/> all checked</label>
					<?php
						while ($theme = mysqli_fetch_array($themeRun)) {
						echo '<label for="'.$theme['ThemeID'].'"><input type="checkbox" class="theme" id="'.$theme['ThemeID'].'" onchange="checkboxStatusChangeTheme()" name="theme[]" value="'.$theme['ThemeDetail'].'" '.checkSelectedTheme($theme['ThemeDetail']).'> '.$theme['ThemeDetail'].'</label>';
					}
					?>
					</div>
					<input type="submit" name="submitTheme" value="Confirm" class="dropdownSubmit">
				</div>
			</div>
		</div>
	</form>
</div>	

<div class="searchContainer">
    <form action="readStoryMainFilter.php" method="POST">
	<div class="autocomplete" style="width:300px;">
		<input id="myInput" type="text" placeholder="<?=isset($_SESSION['errorMsg']['search']) ? $_SESSION['errorMsg']['search'] : 'Search..'?>" name="search">
		</div>
		<input type="submit" name="submitSearch" value="Submit">
    </form>
</div>
</div>

<script>
window.onload = (event) => {
	initMultiselect();
	initMultiselectTheme();
	
	<?php if (!isset($_SESSION['selectedGenres'])){?>

	const checkboxes = document.querySelectorAll('input[type="checkbox"].genre');
	checkboxes.forEach(checkbox => checkbox.checked = true);
	checkboxStatusChange(); 
	<?php }?>
	
	<?php if (!isset($_SESSION['selectedTheme'])){?>
	
	const checkboxesT = document.querySelectorAll('input[type="checkbox"].theme');
	checkboxesT.forEach(checkbox => checkbox.checked = true);
	checkboxStatusChangeTheme();
	
	<?php }?>
	
};

function checkboxStatusChange() {
    var multiselect = document.getElementById("mySelectLabel");
    var multiselectOption = multiselect.getElementsByTagName('option')[0];

    var values = [];
    var checkboxes = document.getElementById("mySelectOptions");
    var checkedCheckboxes = checkboxes.querySelectorAll('input[type=checkbox].genre:checked');

    for (const item of checkedCheckboxes) {
        var checkboxValue = item.getAttribute('value');
        values.push(checkboxValue);
    }

    var dropdownValue = "Nothing is selected";
    if (values.length === checkboxes.querySelectorAll('input[type=checkbox].genre').length) {
        dropdownValue = "All selected";
    } else if (values.length > 0) {
        dropdownValue = values.join(', ');
    }
	<?php if(isset ($_SESSION['errorMsg']['genre'])){?>
		dropdownValue = "Must select one";
		var formSelect = document.getElementById("formSelectGenre");
		formSelect.style.color="red";
	<?php }?>
    multiselectOption.innerText = dropdownValue;
multiselectOption.style.color="red";
    var allCheckbox = document.getElementById("all");
    if (allCheckbox) {
        allCheckbox.checked = checkedCheckboxes.length === checkboxes.querySelectorAll('input[type=checkbox].genre').length;
    }
}

function initMultiselect() {
	checkboxStatusChange();

	document.addEventListener("click", function (evt) {
		var flyoutElement = document.getElementById('myMultiselect'),
			targetElement = evt.target; 

		do {
			if (targetElement == flyoutElement) {

				return;
			}

			targetElement = targetElement.parentNode;
		} while (targetElement);

		toggleCheckboxArea(true);
	});
}
function toggleCheckboxArea(onlyHide = false) {
	var checkboxes = document.getElementById("selectOptions");
	var displayValue = checkboxes.style.display;

	if (displayValue != "block") {
		if (onlyHide == false) {
			checkboxes.style.display = "block";
		}
	} else {
		checkboxes.style.display = "none";
	}
}

function toggle(source) {
	var checkboxes = document.querySelectorAll('input[type="checkbox"].genre');
	for (var i = 0; i < checkboxes.length; i++) {
		if (checkboxes[i] != source)
			checkboxes[i].checked = source.checked;
	}
}
function checkboxStatusChangeTheme() {
    var multiselectTheme = document.getElementById("mySelectLabelTheme");
    var multiselectOptionTheme = multiselectTheme.getElementsByTagName('option')[0];

    var valuesTheme = [];
    var checkboxesTheme = document.getElementById("mySelectOptionsTheme");
    var checkedCheckboxesTheme = checkboxesTheme.querySelectorAll('input[type=checkbox].theme:checked');

    for (const itemTheme of checkedCheckboxesTheme) {
        var checkboxValueTheme = itemTheme.getAttribute('value');
        valuesTheme.push(checkboxValueTheme);
    }

    var dropdownValueTheme = "Nothing is selected";
    if (valuesTheme.length === checkboxesTheme.querySelectorAll('input[type=checkbox].theme').length) {
        dropdownValueTheme = "All selected";
    } else if (valuesTheme.length > 0) {
        dropdownValueTheme = valuesTheme.join(', ');
    }
	<?php if(isset ($_SESSION['errorMsg']['theme'])){?>
		dropdownValueTheme = "Must select one";
		var formSelect = document.getElementById("formSelectTheme");
		formSelect.style.color="red";
	<?php }?>
    multiselectOptionTheme.innerText = dropdownValueTheme;

    var allCheckboxTheme = document.getElementById("allTheme");
    if (allCheckboxTheme) {
        allCheckboxTheme.checked = checkedCheckboxesTheme.length === checkboxesTheme.querySelectorAll('input[type=checkbox].theme').length;
    }
}


function initMultiselectTheme() {
	checkboxStatusChangeTheme();

	document.addEventListener("click", function (evt) {
		var flyoutElement = document.getElementById('myMultiselectTheme'),
			targetElement = evt.target; 

		do {
			if (targetElement == flyoutElement) {
				return;
			}

			targetElement = targetElement.parentNode;
		} while (targetElement);

		toggleCheckboxAreaTheme(true);
	});
}
function toggleCheckboxAreaTheme(onlyHide = false) {
	var checkboxes = document.getElementById("selectOptionsTheme");
	var displayValue = checkboxes.style.display;

	if (displayValue != "block") {
		if (onlyHide == false) {
			checkboxes.style.display = "block";
		}
	} else {
		checkboxes.style.display = "none";
	}
}

function toggleTheme(source) {
	var checkboxes = document.querySelectorAll('input[type="checkbox"].theme');
	for (var i = 0; i < checkboxes.length; i++) {
		if (checkboxes[i] != source)
			checkboxes[i].checked = source.checked;
	}
}
function autocomplete(inp, arr) {
  var currentFocus;
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      this.parentNode.appendChild(a);
      for (i = 0; i < arr.length; i++) {
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement("DIV");
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { 
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var bookAuthor = [];
<?php
$bookSql = "SELECT DISTINCT s.* FROM story s, chapter c WHERE s.StoryID = c.StoryID AND c.Status = 'P'";
$bookRun = mysqli_query($connection, $bookSql);
$authorSql = "SELECT DISTINCT u.* FROM story s, chapter c, user u WHERE s.StoryID = c.StoryID AND c.Status = 'P' AND s.Email = u.Email";
$authorRun = mysqli_query($connection, $authorSql);

$bAArr = array();

while ($book = mysqli_fetch_array($bookRun)) {
    $bAArr[] = $book['Title'];
}
while ($author = mysqli_fetch_array($authorRun)) {
    $bAArr[] = $author['Username'];
}
$quotedbookAuthor = array_map(function($bookAuthor) {
    return "'$bookAuthor'";
}, $bAArr);

$bAquote = json_encode($bAArr);
?>

var bookAuthor = <?php echo $bAquote; ?>;
autocomplete(document.getElementById("myInput"), bookAuthor);


</script>

    <div id="results">
        <script>
 
            $(document).ready(function () {
                LoadData(0);
            });
 
            function LoadData(pagenum) {
                $.post('readStoryMainIndex.php?p=' + pagenum, function (response) {
                    $('#results').html(response);
                });
            }
        </script>
    </div>
	
<?php 
unset($_SESSION['errorMsg']);

mysqli_close($connection);?>
	

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

