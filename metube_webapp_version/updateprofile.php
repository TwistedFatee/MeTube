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
	
	$q="select * from account where userid='$userid'";
	$r = mysql_query($q) or die("Cannot query account.".mysql_error());
	$result = mysql_fetch_assoc($r);
	$oldphone=$result['phone'];
	$oldemail=$result['email'];
	
}
else
{
	header('Location:require_login.php');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
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
			<a href = "userprofile.php?uid=<?php echo $userid;?>" class = "nav_login" id = "profile">Profile</a>
            <a href = "logout.php" class = "nav_login" id = "Login">Log Out</a>
        </div>
    </div>
</div>




<div id = "wrapper" class = "wrapper">
    <div id = "content" class = "content">
        <div id = "left-content" class = "password-left-content">
            <div id = "main-content" class = "main-content">
				<form action="updateprofileprocess.php" method="post">
					<input type="hidden" name="uid" value="<?php echo $userid;?>">
					<input type="hidden" name="oldphone" value="<?php echo $oldphone;?>">
					<input type="hidden" name="oldemail" value="<?php echo $oldemail;?>">
					<div class = "item">
                        <label>User ID: <?php echo $userid;?></label>
                        <span class = "permanent" id = "userid"></span>
                    </div>
                    <div class = "item">
                        <label>User Name: <?php echo $username;?></label>
                        <span class = "permanent" id = "username"></span>
                    </div>
                    <div class = "item">
						<label>Phone</label>
						<input id = "phone" name  = "phone" type = "tel" class = "basic_input" tabindex = "4" maxlength = "10" placeholder = <?php echo $oldphone;?>>
						<div id = "phone_error" class = "val_error"></div>
					</div>
					<div class = "item">
						<label>Email</label>
						<input id = "email" name  = "email" type = "email" class = "basic_input" tabindex = "5" maxlength = "60" placeholder = <?php echo $oldemail;?>>
						<div id = "email_error" class = "val_error"></div>
					</div>
					
					<div class = "item">
                        <input type='submit' name='update_submit' value='Update'>
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
