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
	
	$targetid=$_REQUEST['targetid'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Channel</title>
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

<?php
	$q="select * from channel where userid = '$targetid'";
	$r=mysql_query($q) or die ("Could not query the database channel: <br />". mysql_error());
	$result=mysql_fetch_assoc($r);
	$channelid=$result['channelid'];
	
	$q="select * from media inner join channelmedia on media.mediaid=channelmedia.mediaid where channelid='$channelid' order by addtime desc";
	$r=mysql_query($q) or die ("Could not query the database media: <br />". mysql_error());
	
	
		
	

?>
	
    <div id = "wrapper" class = "wrapper">
        <div id = "content" class = "content">
            <div id = "left-content" class = "left-content">
                <div id = "user-infor-box" class = "user-infor-box">
				
<?php
	while($result_row=mysql_fetch_assoc($r)){
		
?>
					<div class = "item">
                        <p><a target="_blank" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>">Media Name: <?php echo $result_row['medianame'];?></a> 
						</p>
						<p><?php echo $result_row['uploadtime'];?>&nbsp;&nbsp;Views: <?php echo $result_row['views'];?>&nbsp;&nbsp;
						
						</p>
                    </div>
<?php
	}
	if (mysql_num_rows($r)==0){
		
		
?>
                    <div class = "item">                        
						<p>This channel does not contain any media</p>
                    </div>
<?php
		
	}
	

?>
                    
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