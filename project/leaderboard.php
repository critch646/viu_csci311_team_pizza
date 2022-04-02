<?php  
	# if the user hasn't logged in by this point, force a login! 
	session_start();

	# if the SESSION hasn't been initialized redirect the user to the Login.php page
	if(!$_SESSION['username']){  
    	header("Location: php/login.php");}  
  
	# $_SESSION['stuID']; Where the current logged-in username is being held in storage  
  

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
	<title>Pet-Slide Puzzle - LEADERBOARD</title>
	<link rel="stylesheet" href="./css/base_style.css">
	<script src="./js/darklightswitch.js"></script>
	<link id = "themestylesheet" rel="stylesheet" type="text/css" href="./css/light_style.css">
</head>

<body onload="checkTheme()">
	<div id="LeaderboardPage" class="DefaultPage">
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
		<!--LEADERBOARDS AND STATS ARE DEMO ONLY: To be implemented with PHP and mySQL later-->
		<div id="leaderboard-frame" class="container">
			<!--MAIN LEADERBOARD COMPONENTS GOES-->
			<!-- TODO: use PHP to "include" this leaderboard table from an outside file
			& get real user data -->
			<h3 class="h3 display-3">Global Leaderboard</h3>
			<div id="global-user-frame">
				<!--HOLDS THE TABLE THAT HOUSES ALL USER STATS-->
				<table class="table_pizza table table-striped">
				<thead>
					<th>
						Global Rank
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
				<?php include("php/utilities.php"); fetch_leaderboard(20); ?>
				</tbody>
			</table>
			</div>
			</br>
			<div id="local-user-frame">
				<!--TABLE THAT HOUSES THE LOGGED-IN USER STATS-->
<?php
	include("php/dbinfo.inc");			
	include("php/db.php");

	$db = new db($host, $database, $user, $password);
	
	# grab the information of the logged-in user
        $userItems = $db->getUserInfo($_SESSION['username']);

	echo "<h3 class=\"h3 display-3\">Personal Statistics for $userItems[0]</h3>";
	echo "<table class=\"table_pizza table table-striped\">";
	echo "<thead>";
	echo "<th>";
	echo "Global Rank";
	echo "</th>";
	echo "<th>";
	echo "Current Level";
	echo "</th>";
	echo "<th>";
	echo "Current Experience";
	echo "</th>";
	echo "</thead>";
        echo "<tbody>";
        echo "<td>";
        echo $db->getUserRank($_SESSION['username']); # populate with the actual number from the ranked list
        echo "</td>";
        echo "<td>";
        echo "$userItems[2]"; # populate with the user's current lvl
        echo "</td>";
        echo "<td>";
        echo "$userItems[1]"; # populate with the user's current xp
        echo "</td>";
        echo "</tbody>";
                                                        ?>

				</table>
			</div>
			</br>
			</div>
		</div>
	</div>

	<!-- Bootstrap: THESE MUST BE HERE -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

<footer id="legal-info">
    <!--LEGAL INFORMATION GOES HERE-->
</footer>

</html>
