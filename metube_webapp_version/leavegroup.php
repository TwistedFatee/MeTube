<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring']) ){	

	
	$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
	
	if($checkrandomstring!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
	
	$userid=$_SESSION['userid'];	
	$groupid = $_REQUEST['groupid'];
	
	$result = leaveGroup($userid, $groupid);
	if ($result == 1){
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Message</title>
</head>

<body>
<h1> You are the owner of this group and there are some members in this group.</h1>
<br>
<h1> You cannot leave this group.</h1>
<br>
<p><a href="group.php">Come back to Group List</a></p>
<p>
	<a href="userprofile.php?uid=<?php echo $userid;?>">Come back to profile</a>
</p>
 

<p>
	<a href="index.php">MeTube</a>
</p> 
<br><br>

<?php		
	}
		
	else
		header('Location:group.php');
}
else
	header('Location:require_login.php');
?>