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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<!-- jQuery-->
	<script src="js/jquery.js"></script>
	<script>
		var $j = jQuery.noConflict();
		var $session_id = "<?php echo $_SESSION['username']; ?>";
	</script>
	
	<!--Other Information-->
	<title>Pet-Slide Puzzle - GAME</title>
	<link rel="stylesheet" href="./css/base_style.css">
	<script src="./js/darklightswitch.js"></script>
	<script src="js/puzzle.js" defer></script>

	<link id="themestylesheet" rel="stylesheet" type="text/css" href="./css/light_style.css">
	

	
</head>

<body onload="init(); checkTheme()">
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

		<div id="puzzle-frame" class="container">
			<h1 class="h1 display-1">Puzzle</h1>
			<!--Puzzle canvas game-->
			<canvas id="canvas"></canvas>
			</br>
			<div id="puzzle-settings">
				<!--PUZZLE SETTINGS-->
				<h5>Puzzle Settings:</h5>
				</br>
				<label>Puzzle Difficulty:</label>
				<input type="range" min="2" max="10" step="1" value="4"
					oninput="this.nextElementSibling.value = this.value, setDifficulty(this.value)">
				<output>4</output>
				</br>
				<label>Puzzle Image:</label>
				<select name="puzzle_picture" oninput="setImage(this.value)" selected="dogs.jpg">
					<option value="dogs.jpg">Dogs</option>
					<option value="dolphins.jpg">Dolphins</option>
					<option value="forest.jpg">Forest</option>
					<option value="horses.jpg">Horses</option>
					<option value="kittens.jpg">Kittens</option>
				</select>
			</div>
		</div>
<center>
	<div class="col-lg-2">
		<h4 class="h4 display-5">Rewards for Experience</h4>
			<table class="table_pizza table table-striped">
             	<thead>
						<th>Level</th>
						<th>Points Earned</th>
				</thead>
				<tbody>
					<tr>
						<td>2</td>
						<td>75</td>
					</tr>
					<tr>
						<td>3</td>
						<td>225</td>
					</tr>
					<tr>
						<td>4</td>
						<td>675</td>
					</tr>
					<tr>
						<td>5</td>
						<td>1625</td>
					</tr>
					<tr>
						<td>6</td>
						<td>3500</td>
					</tr>
					<tr>
						<td>7</td>
						<td>5750</td>
					</tr>
					<tr>
						<td>8</td>
						<td>8500</td>
					</tr>
					<tr>
						<td>9</td>
						<td>12000</td>
					</tr>
					<tr>
						<td>10</td>
						<td>16000</td>
						</tr>
			</tbody>
		</table>
	</div>
</center>
	</div>
	
</body>

<footer id="legal-info">
	<!--LEGAL INFORMATION GOES HERE-->
</footer>

</html>
