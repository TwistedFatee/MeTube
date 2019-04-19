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
	$targetuserid=$_REQUEST['targetid'];
	$mediaid=$_REQUEST['mid'];
	
	$result = unfollowuser($userid, $targetuserid);
	
	//$mediaid = $_GET['mid'];
	if ($mediaid > 0){
		$url = "vedio.php?mid=".$mediaid;
		header('Location:'.$url);
	}
	else		
		header('Location:subscribelist.php');
	
}
else
	header('Location:require_login.php');
?>