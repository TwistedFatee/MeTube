<!DOCTYPE html>
<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	
	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);
	if($loginrequired!=0){
		header('Location:require_login.php');
	}
	
}
else
{
	header('Location:require_login.php');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="icon" href="img/Logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/ModifyPassword.css">
    <link rel="stylesheet" type="text/css" href="css/PersonalPage.css">
    <link rel="stylesheet" type="text/css" href="css/Register.css">

</head>
<body>
<div id = "db_global_nav" class = "db_global_nav" >
    <div class = "bd">
        <div class = "top_nav_left">
            <a href = "index.php" class = "nav_clemson">MeTube</a>
        </div>

        <div class = "top_nav_right">
			<a href = "userprofile.php" class = "nav_login" id = "profile">Profile</a>
            <a href = "logout.php" class = "nav_login" id = "Login">Log Out</a>
        </div>
    </div>
</div>




<div id = "wrapper" class = "wrapper">
    <div id = "content" class = "content">
        <div id = "left-content" class = "password-left-content">
            <div id = "db-usr-modifypassword" class = "db-usr-modifypassword">
                <h1>Change</h1>
                <h1>Passoword</h1>
            </div>

            <div id = "main-content" class = "main-content">
                <form name = "change-password" class = "modify-page-form" method="post" action='changepasswordprocess.php'>
                    <div class = "modify-page-item">
                        <span class = "m">Current Password:</span>
                        <br>
                        <input type = "password" size = "20" maxlength = "20" name = "old-password" id = "old-password" class = "input-item">
                    </div>
                    <div class = "modify-page-item">
                        <span class = "m">New Password:</span>
                        <br>
                        <input type = "password" size = "20" maxlength = "20" name = "new-password" id = "new-password" class = "input-item">
                    </div>
                    <div class = "modify-page-item">
                        <span class = "m">Confirm Password:</span>
                        <br>
                        <input type = "password" size = "20" maxlength = "20" name = "confirm-password" id = "confirm-password" class = "input-item">
                    </div>
                    <!--<br>-->
                    <div class = "modify-page-item">
                        <input type = "submit" name = "submit"  value = "Submit" class = "my-button">
                    </div>
                </form>
            </div>
        </div>

        <div id = "right-content" class = "right-content">
            <br>
            <br>
            <br>
            <h3>How to make passwords more secure?</h3>
            <ol>
                <li>Use a combination of punctuation, numbers, and uppercase and lowercase letters as the password.</li>
                <li>Do not include personal information (such as name, birthday, etc.) in the password.</li>
                <li>Do not use the same password as other websites.</li>
                <li>Change your password regularly.</li>
            </ol>
        </div>

        <br>
        <br>
        <br>
        <br>

        <div class = "footer">
            <div class = "footer_nav">
			<span class = "fright">
				<a href = "../StaticPage/AboutUs.html">About Us</a>
				<a href = "../StaticPage/Developer.html">Developer</a>
				<a href = "../StaticPage/LibraryRule.html">Library Rule</a>
				<a href = "../StaticPage/Help.html">Help</a>
			</span>
            </div>
        </div>
    </div>

</div>

</body>
</html>