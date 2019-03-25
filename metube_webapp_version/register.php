 <!--<!DOCTYPE html> -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="Viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>MeTube Register</title>
	<link rel="icon" href="../../img/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/Register.css">
	<script type="text/javascript" src="../jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../jquery-3.2.1.js"></script>
</head>




<body>
	<div class = "header">
		<div class = "nav_logo">
			<div class = "logo">
					<a href ="../../index.html">
					<img src="../../img/logo.png" alt = "">
				</a>
				<p style="display: inline-block; font-size: 68px; font-weight: bold; vertical-align: top;">MeTube</p>
			</div>
		</div>
	</div>
	<div class = "wrapper">
		<h1>
			Welcome to MeTube
		</h1>
		<div class = "main">
<?php
ini_set('session.save_path','/home/cai7/temp');

session_start();

include_once "function.php";

if(isset($_POST['register_submit'])) {
	if($_POST['username'] == "" || $_POST['password'] == "" || $_POST['confirm'] == "") {
		$register_error = "One or more fields are missing.";
	}
	else if(strlen($_POST['password'])<4){
		$register_error = "Password need have at least 4 characters.";
	}		
	else if(strcmp($_POST['password'],$_POST['confirm'])){
		$register_error = "Password and comfirmation don't match.";
	}
	else {
		$username = mysql_escape_string($_POST['username']);
		$check = user_exist_check($username);
		if($check == -1){
			$register_error = "Username exists. Please use other username.";
		}else{
			$password = mysql_escape_string($_POST['password']);				
			$phone = mysql_escape_string($_POST['phone']);
			$email = mysql_escape_string($_POST['email']);
			$adduser = add_new_user($username, $password, $phone, $email);		
			if ($adduser == 2){
				$_SESSION['username']=$username;
				$_SESSION['password']=$password;
				header('Location: index.php?username='.$username);
			}else{
				$register_error = "Cannot insert usert to table. Cannot query database.";
			}
		}
	}
}
 
?>
			<form method = "post" name = "registerForm" action="<?php echo "register.php"; ?>">
				<div class = "item">
					<label>Username</label>
					<input id = "username" name = "username" type = "text" class = "basic_input" tabindex = "1" maxlength = "20" placeholder = "Username" required>
					<div id = "name_error" class = "val_error"></div>
				</div>
				<div class = "item">
					<label>Password</label>
					<input id = "password" name = "password" type = "password" class = "basic_input" tabindex = "2" maxlength = "20" placeholder = "At least 4 characters" required>
					<div id = "password_error" class = "val_error"></div>
				</div>
				<div class = "item">
					<label>Confirm</label>
					<input id = "confirm" name = "confirm" type = "password" class = "basic_input" tabindex = "3" maxlength = "20" placeholder = "Confirm password" required>
					<div id = "confirm_error" class = "val_error"></div>
				</div>
				<div class = "item">
					<label>Phone</label>
					<input id = "phone" name  = "phone" type = "tel" class = "basic_input" tabindex = "4" maxlength = "10" placeholder = "Phone number 1234567890">
					<div id = "phone_error" class = "val_error"></div>
				</div>
				<div class = "item">
					<label>Email</label>
					<input id = "email" name  = "email" type = "email" class = "basic_input" tabindex = "5" maxlength = "60" placeholder = "Name@g.clemson.edu">
					<div id = "email_error" class = "val_error"></div>
				</div>

				<div>
				
					<input type = "submit" name = "register_submit" id = "register_submit" value = "Register">

					<input name="reset" type="reset" value="Reset">
				</div>
			</form>
		</div>
		<div class = "left">
			<ul class = "left_nav">
				<li>
					>&nbsp;Have already an account?
					<a rel = "nofollow" href = "login.php">Login</a>
				</li>
			</ul>
		</div>
	</div>
	<div class = "footer">
		<div class = "footer_nav">
			<span class = "fright">
				<a href = "../StaticPage/AboutUs.html">About MeTube</a>
				<a href = "../StaticPage/Developer.html">Developers</a>
				<a href = "../StaticPage/MeTubeRule.html">MeTube Rule</a>
				<a href = "../StaticPage/Help.html">Help</a>
			</span>
		</div>
	</div>
	<script type="text/javascript" src="Register.js"></script>
	<script type="text/javascript" src="VerifyCode.js"></script>
</body>
</html>




<?php
  if(isset($register_error))
   {  echo "<div id='resigster_result'>".$register_error."</div>";}
?>











