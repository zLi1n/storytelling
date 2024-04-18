<?php
$connection = mysqli_connect("localhost", "root", "", "storytelling");
	
if (!$connection) {
	die("Connection failed: " . mysqli_connect_error());
}
session_start();

if (isset($_SESSION['selectedGenres']) || isset($_SESSION['selectedTheme'])) {
    $conditions = [];

    if (isset($_SESSION['selectedGenres'])) {
        $quotedGenres = array_map(function($genre) {
            return "'$genre'";
        }, $_SESSION['selectedGenres']);
        $selectGenreSql = implode(', ', $quotedGenres);
        $conditions[] = "g.GenreDetail IN ($selectGenreSql)";
    }

    if (isset($_SESSION['selectedTheme'])) {
        $quotedThemes = array_map(function($theme) {
            return "'$theme'";
        }, $_SESSION['selectedTheme']);
        $selectThemeSql = implode(', ', $quotedThemes);
        $conditions[] = "t.ThemeDetail IN ($selectThemeSql)";
    }

    $conditions[] = "s.StoryID = c.StoryID";
    $conditions[] = "c.Status = 'P'";

    $joinConditions = [];
    if (isset($_SESSION['selectedGenres'])) {
        $joinConditions[] = "s.GenreID = g.GenreID";
    }
    if (isset($_SESSION['selectedTheme'])) {
        $joinConditions[] = "s.ThemeID = t.ThemeID";
    }

    $joinClause = implode(' AND ', $joinConditions);

    $selectBookSql = "SELECT DISTINCT s.* FROM story s, chapter c";
    if (!empty($joinClause)) {
        $selectBookSql .= ", genre g, theme t WHERE $joinClause AND " . implode(' AND ', $conditions)." ORDER BY c.DateTime DESC";
    } else {
        $selectBookSql .= " WHERE " . implode(' AND ', $conditions)." ORDER BY c.DateTime DESC";
    }
}else {
    $selectBookSql = "SELECT DISTINCT s.* FROM story s, chapter c WHERE s.StoryID = c.StoryID AND c.Status = 'P' ORDER BY c.DateTime DESC";
}
if (isset($_SESSION['search'])){
	$searchTerm = mysqli_real_escape_string($connection, $_SESSION['search']);
	echo "<p style='margin:0 20px'>Results for \"<strong>$searchTerm</strong>\"</p>";
	
	$selectBookSql = "SELECT DISTINCT s.* FROM story s, chapter c, user u WHERE s.StoryID = c.StoryID AND c.Status = 'P' AND s.Email = u.Email AND (s.Title LIKE '%$searchTerm%' OR u.Name LIKE '%$searchTerm%') ORDER BY c.DateTime DESC";
}
$q1 = mysqli_query($connection, $selectBookSql);
$count = mysqli_num_rows($q1);
$rowperpage = 8;
 
$page = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
 
if ($page == 0 or $page == '') {
    $page = 1;
}
	
$page = $page - 1;
 
$p = $page * $rowperpage;
 
$sql = $selectBookSql." limit ".$p. ", ".$rowperpage;
$run = mysqli_query($connection, $sql);
	
if (!$run) {
	die("Query failed: " . mysqli_error($connection));
}



echo '<div class="bookGroup">';
while ($rs = mysqli_fetch_array($run)) {
	echo '<form action="storyDetail.php" method="POST"><div class="book">
				<div class="img">';
				echo "<img src='img/coverPage/".$rs['CoverPage']."' alt='Cover Image' style='width:100px;height:150px'><br>";
	echo '		</div>
				<div class="dtl">';
				
				echo '<input type="submit" class="ttlBtn" name="read" value="' . $rs['Title'] . '"><br>';
				echo '<input type="hidden" name="bookID" value="' . $rs['StoryID'] . '"><br>';
				$genreID = $rs['GenreID'];
				$genreQuery = "SELECT GenreDetail FROM Genre WHERE GenreID = $genreID";
				$genreResult = mysqli_query($connection, $genreQuery);
				$genreData = mysqli_fetch_assoc($genreResult);
				$genreDetail = $genreData['GenreDetail'];
				echo '<div class="themeDetail"> ' . $genreDetail . '</div>';

				$themeID = $rs['ThemeID'];
				$themeQuery = "SELECT ThemeDetail FROM Theme WHERE ThemeID = $themeID";
				$themeResult = mysqli_query($connection, $themeQuery);
				$themeData = mysqli_fetch_assoc($themeResult);
				$themeDetail = $themeData['ThemeDetail'];
				echo '<div class="themeDetail">' . $themeDetail . '</div>';
				
				echo '<div class="statusDetail">';
				if ($rs['Status']=='F'){
					echo 'Finished';
				}else if($rs['Status']=='O'){
					echo 'Ongoing';
				}
				echo '</div><br>';

				$storyID = $rs['StoryID'];
				$latestChapterQuery = "SELECT ChapterName FROM Chapter WHERE StoryID = $storyID AND Status = 'P' ORDER BY DateTime DESC LIMIT 1";
				$latestChapterResult = mysqli_query($connection, $latestChapterQuery);
				$latestChapterData = mysqli_fetch_assoc($latestChapterResult);
				$latestChapter = $latestChapterData['ChapterName'];
				echo '<p><strong>Latest Chapter:</strong> ' . $latestChapter . '</p>';

				$email = $rs['Email'];
				$access = $rs['Access'];
				if ($access == 'PVT') {
					$authorQuery = "SELECT Username FROM User WHERE Email = '$email'";
					$authorResult = mysqli_query($connection, $authorQuery);
					$authorData = mysqli_fetch_assoc($authorResult);
					$author = $authorData['Username'];
					echo '<strong>Author:</strong> ' . $author . '<br>';
				}else
					echo '<strong>Author:</strong> Multiple<br>';
				echo '<input type="submit" class="readBtn" name="read" value="Read Now">
				</div></form>';

	
	echo '		
		</div>';
}
echo '</div>';


$prev_page = $page;
$next_page = $page + 2;

echo '<div class="pagination">	<div class="box">';
// Previous Button
if ($page > 0) {
    echo '<button onclick="LoadData('.$prev_page.')"><a href="#" class="prev">Previous</a></button>';
}
echo '<ul class="ul">';
// Page Numbers
	for ($i = max(1, $page - 2); $i <= min($page + 2, $count / $rowperpage); $i++) {
		$active_page = ($page + 1 == $i) ? "active_page" : "";
		echo '<li onclick="LoadData('.$i.')"><a href="#" class="page_number '.$active_page.'">'.$i.'</a></li>';
	}
echo '</ul>';
// Next Button
if ($page < ceil($count / $rowperpage) - 1) {
    echo '<button onclick="LoadData('.$next_page.')"><a href="#" class="next">Next</a></button>';
}
echo '</div> </div>';
unset($_SESSION['search']);unset($_SESSION['selectedGenres'] );unset($_SESSION['selectedTheme'] );
mysqli_close($connection);

?>
