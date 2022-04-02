
<?php  
session_start();//session starts here  
  # this project uses: 'username', and 'user_password'
?>  
  
<html>  

<head lang="en">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
    <meta charset="UTF-8">
    <title>Pet-Slide Puzzle - LOGIN</title>  
</head>  
<style>  
    .login-panel {  
        margin-top: 150px;  
	}
</style>  
  
<body>  
  
<div class="container">  
    <div class="row">  
        <div class="col-md-4 col-md-offset-4">  
            <div class="login-panel panel panel-success">  
                <div class="panel-heading">  
                    <h3 class="panel-title">Sign In</h3>  
                </div>  
                <div class="panel-body">  
                    <form role="form" method="post" action="login.php">  
                        <fieldset>  
                            <div class="form-group"  >  
                                <input class="form-control" placeholder="Username" name="userN" type="username" autofocus>  
                            </div>  
                            <div class="form-group">  
                                <input class="form-control" placeholder="Password" name="pass" type="password" value="">  
                            </div>  
  
  
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="login" name="login" >
								</fieldset> 
                    </form>
								<div class="row col-md-12">
									<div class="col-md-6">
										<a href="../create_profile.php">Create Account</a>
									</div>
									<div class="col-md-6">
										<a href="../index.php">Return to Landing Page</a>
									</div>
                            	 
                        		</div>
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
</body>  
  
</html>  
  
<?php  
  	# Need to include the database file..
	include("dbinfo.inc");
	include("db.php");

	$dB = new db($host, $database, $user, $password);
  
	if(isset($_POST['login']))  
	{  
    	$user_name=$_POST['userN'];  
    	$user_pass=$_POST['pass'];
  
		if($dB->loginUser($user_name, $user_pass)){
			$_SESSION['username']=$user_name;
			echo "<script>window.open('../index.php','_self')</script>";
		}  
    	else  
    	{  
      		echo "<script>alert('Email or password is incorrect!')</script>";  
    	}  
	}
?>  
