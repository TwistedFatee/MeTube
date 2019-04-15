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
	$targetid=$_REQUEST['targetid'];
	
	$q="update friend set approved='2' where user1='$targetid' and user2='$userid'";
	$r = mysql_query($q) or die("Cannot query friend. Approve request fails. ".mysql_error());
	header('Location: friendlist.php');	
	
}
else
	header('Location:require_login.php');
?>