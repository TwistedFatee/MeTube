<!DOCTYPE html>

<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && $_SESSION['userid'] > 0 && isset($_SESSION['randomstring']) && isset($_REQUEST['uid'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	$targetid=$_REQUEST['uid'];

	$checkuser=user_randomstring_check($userid, $randomstring);
	if($checkuser!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
	

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/PersonalPage.css">
    <link rel="stylesheet" type="text/css" href="css/DropDownStyle.css">
    <link rel="stylesheet" type="text/css" href="css/Register.css">

	
</head>
<body>
    <div id = "db_global_nav" class = "db_global_nav" >
        <div class = "bd">
            <div class = "top_nav_left">
                <a href = "index.php" class = "nav_clemson">MeTube</a>
            </div>

            <div class = "top_nav_right">
                <a href = "logout.php" class = "nav_login" id = "Logout">Log Out</a>
            </div>
        </div>
    </div>

    <div id = "nav-sns" class = "nav-sns">
        <div class = "logo">
                <a href ="index.php">
                    <img src="img/logo.png" alt = "">
                </a>
                <p style="display: inline-block; font-size: 68px; font-weight: bold; vertical-align: top;">MeTube</p>
            </div>
    </div>

<?php
	if ($userid == $targetid){
		$q="select * from account where userid='$userid'";
		$r=mysql_query($q);
		if(!$r || (mysql_num_rows($r) == 0)){
			die ("Could not query the database account: <br />". mysql_error());
		}
		$result=mysql_fetch_assoc($r);
		$email=$result['email'];
		$phone=$result['phone'];
	

?>
	
    <div id = "wrapper" class = "wrapper">
        <div id = "content" class = "content">
            <div id = "left-content" class = "left-content">
                <div id = "user-infor-box" class = "user-infor-box">
					<div class = "item">
                        <label>User ID: <?php echo $userid;?></label>
                        <span class = "permanent" id = "userid"></span>
                    </div>
                    <div class = "item">
                        <label>User Name: <?php echo $username;?></label>
                        <span class = "permanent" id = "username"></span>
                    </div>
                    <div class = "item">
                        <label>Email: <?php echo $email;?></label>
                        <span class = "permanent" id = "useremail"></span>
                    </div>
        
                    <div class = "item">
                        <label>Phone: <?php echo $phone;?></label>
                        <span class = "permanent" id = "userphone"></span>
                    </div>
					
					<div class = "item">
                        <a href='updateprofile.php' >Edit User Profile</a></span>
                    </div>
					<div class = "item">
                        <a href='changepassword.php' >Change Password</a></span>
                    </div>
                </div>
            </div>

            <div class = "history-record">
                <h1>
                    <p>Navigator</p>
                </h1>
                
                <div class="choices">
                    <a href="contact.php">Contact</a>
                    <br>
                    <a href="block.php">Blocking List</a>
                    <br>
                    <a href="media_upload.php">Upload</a>
                    <br>
                    <a href="favorite.php">Liked</a>
                    <br>
                    <a href="group.php">Discussion Group</a>
                    <br>
                    <a href="message.php">Message</a>
                </div>
            </div>
        </div>
        <div class = "footer">
            <div class = "footer_nav">
			<span class = "fright">
				<a href = "StaticPage/AboutUs.html">About Us</a>
				<a href = "StaticPage/Developer.html">Developer</a>
				<a href = "StaticPage/MeTubeRule.html">MeTube Rule</a>
				<a href = "StaticPage/Help.html">Help</a>
			</span>
            </div>
        </div>
    </div>
	
<?php
	}
	else{
		$q="select * from account where userid='$targetid'";
		$r=mysql_query($q);
		if(!$r || mysql_num_rows($r)==0){
			die ("Could not query the database view: <br />". mysql_error());
		}
		$result=mysql_fetch_assoc($r);
		$username=$result['username'];
		$email=$result['email'];
		$phone=$result['phone'];
?>
	<div id = "wrapper" class = "wrapper">
        <div id = "content" class = "content">
            <div id = "left-content" class = "left-content">
                <div id = "user-infor-box" class = "user-infor-box">
					<div class = "item">
                        <label>User ID: <?php echo $targetid;?></label>
                        <span class = "permanent" id = "userid"></span>
                    </div>
                    <div class = "item">
                        <label>User Name: <?php echo $username;?></label>
                        <span class = "permanent" id = "username"></span>
                    </div>
                    <div class = "item">
                        <label>Email: <?php echo $email;?></label>
                        <span class = "permanent" id = "useremail"></span>
                    </div>
        
                    <div class = "item">
                        <label>Phone: <?php echo $phone;?></label>
                        <span class = "permanent" id = "userphone"></span>
                    </div>
					
					<div class = "item">
                        <a href='addfriend.php' >Add to firend list</a></span>
                    </div>
					<div class = "item">
                        <a href='block.php' >Block this user</a></span>
                    </div>
                </div>
            </div>

            <div class = "history-record">
                <h1>
                    <p>Navigator</p>
                </h1>
                
                <div class="choices">
                    <a href="chanal.php">Chanal</a>
                    <br>
                    <a href="userplaylist.php">Play Lists</a>
                    <br>                    
                    <a href="favorite.php">Liked</a>
                    <br>
                    <a href="group.php">Discussion Group</a>
                    <br>
                    <a href="message.php">Send a Message</a>
                </div>
            </div>
        </div>
        <div class = "footer">
            <div class = "footer_nav">
			<span class = "fright">
				<a href = "StaticPage/AboutUs.html">About Us</a>
				<a href = "StaticPage/Developer.html">Developer</a>
				<a href = "StaticPage/MeTubeRule.html">MeTube Rule</a>
				<a href = "StaticPage/Help.html">Help</a>
			</span>
            </div>
        </div>
    </div>
	
</body>
<?php
	}
}
else
{
	header('Location:require_login.php');
}
?>

</html>