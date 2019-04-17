<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

$userloggedin = False;
$userid = 0;
if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){			
	$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
	
	if($checkrandomstring!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
	$userloggedin = True;
	//$mediaid=$_REQUEST['mid'];
	$userid=$_SESSION['userid'];
	//$targetid=$_REQUEST['targetid'];
}		
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Discussion Groups</title>
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
<?php
if ($userloggedin){
?>
            <div class = "top_nav_right">
				<a href = "userprofile.php?uid=<?php echo $userid;?>" class = "nav_login" id = "profile">Profile</a>
                <a href = "logout.php" class = "nav_login" id = "Logout">Log Out</a>
            </div>
<?php
}
?>
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
if ($userloggedin){
	$q = "select * from groupmember inner join discussiongroup on groupmember.groupid = discussiongroup.groupid 
		where groupmember.userid = '$userid' ";
	$r = mysql_query($q) or die("Cannot query groupmember or discussiongroup. ".mysql_error());
	if (mysql_num_rows($r) > 0){
?>
	<div >
		<h2>Your groups:</h2>
<?php
		while($result_row = mysql_fetch_assoc($r)){
			$groupid = $result_row['groupid'];
			$groupname = $result_row['groupname'];
			$groupdescription = $result_row['description'];
?>
		<p>
			<font size="4"><a href="groupmessage.php?groupid=<?php echo $groupid;?>">Name: <?php echo $groupname;?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $groupdescription;?></font>
		</p>

<?php
		}
?>
		<br><br>
	</div>
<?php
	}
}
$q = "select * from discussiongroup where groupid not in (select groupid from groupmember where userid = '$userid') order by createtime desc";
$r = mysql_query($q) or die("Cannot query groupmember or discussiongroup. ".mysql_error());
?>
	<div >
		<h2>All other groups:</h2>
<?php
while($result_row = mysql_fetch_assoc($r)){
	$groupid = $result_row['groupid'];
	$groupname = $result_row['groupname'];

	$groupdescription = $result_row['description'];
?>
		
		<p>
			<font size="4">Name: <?php echo $groupname;?></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $groupdescription;?><br>
			<a href="joingroup.php?groupid=<?php echo $groupid;?>"><pre>	Join this group</pre></a><font size="4">
		</p>
<?php
}
?>
	</div>

</body>
</html>