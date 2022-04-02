<?php   
	session_start();
  
?>

<!DOCTYPE html>
<html>
	
	<!--This ppage doesn't require outright that a user is logged in-->

<head>
	<!--Metadata for the webpage-->
	<meta charset="UTF-8">
	<meta name="description" content="CSCI311 Web-Development Project: Pet Sliding-Puzzle">
	<meta name="author" content="Team 1 (Pizza): Zeke Critchlow, Brandon Stanton, Carolyn, Iuliiana">

	<!-- Required meta tags for Bootstrap -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS (This needs to be the first stylesheet) -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<!--Other Information-->
	<title>Pet-Slide Puzzle - HOME</title>

	<link rel="stylesheet" href="./css/base_style.css">
	<script src="./js/darklightswitch.js"></script>
	<link id = "themestylesheet" rel="stylesheet" type="text/css" href="./css/light_style.css">
	
</head>

<body onload="checkTheme()">
	<div id="landingPage" class="DefaultPage">
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

		<!--WEBSITE DESCRIPTION AND DEMO VIDEO-->
		<div class="container">
			<h1 class="h1 display-1">Puzzle</h1>
			<h3 class="h3 font-weight-light">
				Solve puzzles by dragging and dropping scrambled tiles. 
				Solve more puzzles to increase your score and unlock new pictures and harder puzzles!
				Compare your high-score statistics against other players - Will you become the #1 TOP PUZZLE MASTER? 
			</h3>
			<div class="row">
				<div class="col-lg-8">	
					<!--DEMO VIDEO -->
					<div style="position: relative; padding-bottom: 56.25%; padding-top: 25px; height: 0;">
						<iframe id="kaltura_player" src="https://admin.video.ubc.ca/p/149/sp/14900/
						embedIframeJs/uiconf_id/23451542/partner_id/149?
						iframeembed=true&playerId=kaltura_player&entry_id=0_ldqlaylc&
						flashvars[streamerType]=auto&amp;
						flashvars[localizationCode]=en&amp;
						flashvars[leadWithHTML5]=true&amp;
						flashvars[sideBarContainer.plugin]=true&amp;
						flashvars[sideBarContainer.position]=left&amp;
						flashvars[sideBarContainer.clickToClose]=true&amp;
						flashvars[chapters.plugin]=true&amp;
						flashvars[chapters.layout]=vertical&amp;
						flashvars[chapters.thumbnailRotator]=false&amp;
						flashvars[streamSelector.plugin]=true&amp;
						flashvars[EmbedPlayer.SpinnerTarget]=videoHolder&amp;
						flashvars[dualScreen.plugin]=true&amp;
						flashvars[hotspots.plugin]=1&amp;
						flashvars[Kaltura.addCrossoriginToIframe]=true&amp;
						&flashvars[autoPlay]=true&amp;
						&wid=0_rn11ubtb" width="854" height="480" allowfullscreen webkitallowfullscreen 
						mozAllowFullScreen allow="autoplay *; fullscreen *; encrypted-media *" 
						sandbox="allow-forms allow-same-origin allow-scripts allow-top-navigation 
						allow-pointer-lock allow-popups allow-modals allow-orientation-lock 
						allow-popups-to-escape-sandbox allow-presentation allow-top-navigation-by-user-activation" 
						frameborder="0" title="Kaltura Player" 
						style="position:absolute;top:0;left:0;width:100%;height:100%"></iframe>
					</div>
				</div>
				<div class="col-lg-2">
					<!--LEADERBOARD "WIDGET" COMPONENT -->
					<!-- TODO: use PHP to "include" this leaderboard table from an outside file
							& get real user data -->
					<h4 class="h4 display-4">
						Leaderboard Statistics
					</h4>
					<table class="table_pizza table table-striped">
						<thead>
							<th>Global Top 5</th>
						</thead>
						<thead>
							<th>
								Rank
							</th>
							<th>
								User Name
							</th>
							<th>
								Experience
							</th>
							<th>
								Level
							</th>
						</thead>

						<tbody>
							<?php include("php/utilities.php"); fetch_leaderboard(5); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>

<footer id="legal-info">
    <!--LEGAL INFORMATION FILLED IN BY base_style.css-->
</footer>

</html>
