<?php
        require_once("php/dbinfo.inc");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		
			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
    		<meta charset="UTF-8">  
		
        <title>Pet-Slide Puzzle - REGISTRATION</title>
		<!--SCRIPT FOR CHECKING USER INPUT-->
        <script>

            function checkUsername(username_id, username_msg_id){

                let user = document.getElementById(username_id);
                let msg = document.getElementById(username_msg_id);
                let username_re = /^[a-zA-Z]+[a-zA-Z0-9]{1,40}$/;
                let username = user.value;

                if (username_re.test(username)){
                    msg.innerHTML = "Username valid";
                } else {
                    msg.innerHTML = "Username invalid";
                }


            }

            function checkPassword(pwd1_id, pwd2_id, pwd_msg_id){
                let pwd1 = document.getElementById(pwd1_id);
                let pwd2 = document.getElementById(pwd2_id);
                let msg = document.getElementById(pwd_msg_id);
                let pwd_re = /^[a-zA-Z0-9!@#$%^&*]{4,20}$/;

                if (pwd1.value !== "" && pwd2.value !== ""){
                    if (pwd1.value === pwd2.value){
                        if (!pwd_re.test(pwd1.value)){
                            msg.innerHTML = "Invalid password."
                            return;
                        }
                        msg.innerHTML = "Passwords match."
                    } else {
                        msg.innerHTML = "Passwords do not match."
                    }
                }
            }

        </script>
		
		<style>  
    		.login-panel {  
        	margin-top: 150px;
            }
 		</style>
		
    </head>
    <body>
		<div class="container">  
    <div class="row">  
        <div class="col-md-4 col-md-offset-4">  
            <div class="login-panel panel panel-success">  
                <div class="panel-heading">
					<h3 class="panel-title">Create an Account</h3> 
					</div>  
                <div class="panel-body">
					<form id="createProfileForm" name="createProfileForm" method="post" action="php/create_profile.php">
        		<div>
            		<label for="usernameCreation">Username:</label>
            			<input name="usernameCreation" id="usernameCreation" type="text" onchange="checkUsername('usernameCreation', 'usernameMessage')">
            				<p>Usernames must be 1-16 alphanumeric characters and must start with a letter.</p>
            			<p id="usernameMessage"></p>
        		</div>
        
				<div>
            		<label for="passwordCreation">Password:</label>
            		<input name="passwordCreation" id="passwordCreation" type="password" onchange="checkPassword('passwordCreation', 'passwordRetypeCreation', 'passwordMessage')">
        		</div>
        
				<div>
            		<label for="passwordRetypeCreation">Retype Password:</label>
            		<input name="passwordRetypeCreation" id="passwordRetypeCreation" type="password" onchange="checkPassword('passwordCreation', 'passwordRetypeCreation', 'passwordMessage')">
            	<p id="passwordMessage"></p>
            	<p>Passwords must be 4 to 12 characters, are case-sensitive, use letters, numbers and the characters: !, @, #, $, %, ^, &, *</p>
        		</div>
        		<div>
            		<label for="submit"></label>
            		<input type="submit" value="Create Profile" name="submit" id="submit">
					<a href="index.php">Return to Landing Page</a>
        		</div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
    </body>
</html>
