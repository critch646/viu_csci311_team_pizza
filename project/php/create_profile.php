<?php

    require_once("dbinfo.inc");
    require("db.php");


    $dB = new db($host, $database, $user, $password);

    $newUsername;
    $newPassword;

    if(isset($_POST)){
        $newUsername = $_POST['usernameCreation'];
        $newPassword = $_POST['passwordCreation'];

        if($dB->createUser($newUsername, $newPassword)){
			echo "<script>window.open('../index.php','_self')</script>";
			$_SESSION['username']=$newUsername;
		}
		else {
			echo "<script>window.open('../create_profile.php','_self')</script>";
		}
		
    }

?>