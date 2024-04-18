<?php
session_start();
if(isset($_REQUEST['submitGenre'])){
	if(isset($_REQUEST['genre']))
		$_SESSION['selectedGenres'] = isset($_REQUEST['genre']) ? $_REQUEST['genre'] : '';
	else
		$_SESSION['errorMsg']['genre'] = "Cannot be empty";

	header("location:readStoryMain.php");
}
if(isset($_REQUEST['submitTheme'])){
	if(isset($_REQUEST['theme']))
		$_SESSION['selectedTheme'] = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : '';
	else
		$_SESSION['errorMsg']['theme'] = "Cannot be empty";
	
	header("location:readStoryMain.php");
}
if(isset($_REQUEST['submitSearch'])){
	if(!empty($_REQUEST['search']))
		$_SESSION['search'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
	else
		$_SESSION['errorMsg']['search'] = "Cannot be empty";

	header("location:readStoryMain.php");
}
//unset($_SESSION['selectedGenres'] );unset($_SESSION['selectedTheme'] );
?>
