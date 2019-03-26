<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MeTube Login</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/Register.css">
    <link rel="stylesheet" type="text/css" href="css/Login.css">
</head>

<body>
<div class = "header">
    <div class = "nav_logo">
        <div class = "logo">
            <a href ="index.php">
                <img src="img/logo.png" alt = "">
            </a>
            <p style="display: inline-block; font-size: 68px; font-weight: bold; vertical-align: top;">MeTube</p>
        </div>
    </div>
</div>

<div class = "wrapper">
    <h1>
        Welcome Back
    </h1>

    <div class = "main">
	
<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_POST['login_submit'])) {
	if($_POST['username'] == "" || $_POST['password'] == "") {
		$login_error = "One or more fields are missing.";
	}
	else {
		$username = mysql_escape_string($_POST['username']);
		$check = user_exist_check($username);
		if($check == 0){
			$login_error = "Username does not exist.";
		}else{
			$password = mysql_escape_string($_POST['password']);				
			$check = user_pass_check($username, $password); // Call functions from function.php
			if($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				
				$query="select * from account where username='$username'";
				$result=mysql_query($query);
				if (!$result)
				{
					die ("cannot find userid. Could not query the database: <br />". mysql_error());
				}
				else{
					$row = mysql_fetch_row($result);
					//Set the $_SESSION variables
					$_SESSION['password']=$password;	
					$_SESSION['username']=$username;
					$_SESSION['userid']=$row[0];
				}
				$url = "index.php?user=".$username;
				echo "<meta http-equiv=\"refresh\" content=\"0;url=$url\">";
			}				
		}
	}
}
 
?>
	
        <form name = "loginForm" method = "post" action="<?php echo "login.php"; ?>">
            <div class = "item">
                <label>Username</label>
                <input id = "username" name  = "username" type = "text" class = "basic_input" tabindex = "1" maxlength = "20" >
                <div id = "name_error" class = "val_error"></div>
            </div>
            <div class = "item">
                <label>Password</label>
                <input id = "password" name = "password" type = "password" class = "basic_input" tabindex = "2" maxlength = "20" placeholder = "Password">
                <div id = "password_error" class = "val_error"></div>
            </div>
            <div>
                <label>&nbsp;</label>
                <input type = "submit" name = "login_submit" id = "Login_submit" value = "Login" class = "login_submit">
            </div>
        </form>
    </div>
<?php
  if(isset($login_error)){  
    echo "<br><br>";
	echo "<div id='login_result'>".$login_error."</div>";
  }
?>
    <div class = "left">
        <ul class = "left_nav">
            <li>
                >&nbsp;Have no an account
                <a rel = "nofollow" href = "register.php">Register</a>
            </li>
        </ul>
    </div>
</div>

<div class = "footer_login">
    <div class = "footer_nav">
			<span class = "fright">
				<a href = "../StaticPage/AboutUs.html">About MeTube</a>
				<a href = "../StaticPage/Developer.html">Developer</a>
                <a href = " ">MeTube Rule</a>
				<a href = "../StaticPage/Help.html">Help</a>
			</span>
    </div>
</div>
</body>
</html>


