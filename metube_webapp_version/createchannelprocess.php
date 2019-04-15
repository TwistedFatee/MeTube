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
	$channelname = mysql_escape_string($_POST['channelname']);
	$description = mysql_escape_string($_POST['description']);
		
	if (strlen($channelname) <= 0 || strlen($description) <= 0)
		echo "One or more field is required!";
	else{
		createchannel($userid, $channelname, $description);
		header('Location:userpchannel.php');
	}
}
else
	header('Location:require_login.php');
?>