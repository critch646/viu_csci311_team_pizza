<?php
	require_once("php/dbinfo.inc");
	# starting a session no matter what, apparently...? 
	// YES WE NEED A SESSION NO MATTER WHAT!
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <!--Metadata for the webpage-->
    <meta charset="UTF-8">
    <meta name="description" content="CSCI311 Web-Development Project: Pet Sliding-Puzzle">
    <meta name="author" content="Team 1 (Pizza): Zeke Critchlow, Brandon Stanton, Carolyn, Iuliiana">

	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS (This needs to be the first stylesheet) -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<!--Other Information-->
    <title>Pet-Slide Puzzle - SETTINGS</title>
    <link rel="stylesheet" href="./css/base_style.css">
	<script src="./js/darklightswitch.js"></script>
	<link id = "themestylesheet" rel="stylesheet" type="text/css" href="./css/light_style.css">
</head>

<body  onload="checkTheme()">
	<div id="SettingsPage" class="DefaultPage">
		<div id="top-bar">
			<div class="navbar_pizza">
				<a href="index.php">Home</a>		
				<a href="puzzle.php">Puzzle</a>
				<a href="leaderboard.php">Global Leaderboard</a>
				<?php
					if(!$_SESSION['username']){
						echo "<a href=\"php/login.php\">Login/Create Account</a>";}
					else {
						echo "<a href=\"php/logout.php\">Logout</a>";
					}
				?>
				<a href="settings.php">Settings</a>

			</div>
		</div>
		<!--SETTINGS COMPONENT-->
		<div class="container">
		<h3 class="h3 display-3">Settings</h3>
			<div id="settings-frame">
				<h4 class="h4 font-weight-light">
				Theme Color Select:
				</h4>
				<button onclick="swapStyleSheet('./css/light_style.css')">Light Mode</button>
				<button onclick="swapStyleSheet('./css/dark_style.css')">Dark Mode</button>
			</div>
		</div>
	</div>

	<<!-- Bootstrap: THESE MUST BE HERE -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

<footer id="legal-info">
    <!--LEGAL INFORMATION GOES HERE-->
</footer>

</html>
