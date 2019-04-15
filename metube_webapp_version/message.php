<!DOCTYPE html>

<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && $_SESSION['userid'] > 0 && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];

	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);

	//$checkuser=user_randomstring_check($userid, $randomstring);
	if($loginrequired!=0){
		header('Location:require_login.php');
	}
	
	
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/PersonalPage.css">
    <link rel="stylesheet" type="text/css" href="css/DropDownStyle.css">
    <link rel="stylesheet" type="text/css" href="css/Register.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/iconfont.css">
	
</head>
<body>
    <div id = "db_global_nav" class = "db_global_nav" >
        <div class = "bd">
            <div class = "top_nav_left">
                <a href = "index.php" class = "nav_clemson">MeTube</a>
            </div>

            <div class = "top_nav_right">
				<a href = "userprofile.php?uid=<?php echo $userid;?>" class = "nav_login" id = "profile">Profile</a>
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
	
    <div id = "wrapper" class = "wrapper">
        <div id = "content" class = "content">
            <div id = "left-content" class = "left-content">
                <div id = "user-infor-box" class = "user-infor-box">
				
<?php
	
	$q = "select * from account where userid in (select touserid from message where fromuserid='$userid') 
		UNION select * from account where userid in (select fromuserid from message where touserid='$userid') 
		";
	$r = mysql_query($q) or die("Cannot query table account or message.  ".mysql_error());
	
	while($result_row=mysql_fetch_assoc($r)){
		
		$friendid=$result_row['userid'];
		$friendname=$result_row['username'];
		
		$q2 = "select count(message) as cnt from message where fromuserid='$friendid' and beenread='0'";
		$r2=mysql_query($q2) or die ("Could not query the database message: <br />". mysql_error());
		$result2 = mysql_fetch_assoc($r2);
		$unreadmessage=$result2['cnt'];
?>
					<div class = "item">
                        <p><a href="sendmessage.php?targetid=<?php echo $friendid;?>">Name: <?php echo $friendname;?></a> 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
		if($unreadmessage > 0){
?>
						<font color="red"><?php echo $unreadmessage;?></font>
<?php
		}
?>
						</p>
                    </div>
<?php
	
		
	}
	if (mysql_num_rows($r)==0){
		
		
?>
                    <div class = "item">                        
						<p>No Record</p>
                    </div>
<?php
		
	}
	

?>
                    
                </div>
            </div>

            <div class = "history-record">                
                <div class="choices">
					<a href="media_upload.php">Upload File</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
					<a href="uploadlist.php">Upload History</a>
                    <br>
					<a href="downloadlist.php">Download History</a>
                    <br>
                    <a href="favoritelist.php">Liked</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="subscribelist.php">Subscribe List</a>
					<br>
                    <a href="userplaylist.php">Play Lists</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="userpchannel.php">Channel</a>
					<br>
					
                    <a href="contact.php">Contact</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="friendlist.php">Friend</a>
                    <br>
                    <a href="blocklist.php">Blocking List</a>
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
else
{
	header('Location:require_login.php');
}
?>

</html>