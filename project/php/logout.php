<?php  
  
	# Quick script to log the user out, and redirect to the landing page
	session_start();
	session_destroy();  

	# redirects the user back to the landing page after destroying their session
	header("Location: ../index.php");
?>  
