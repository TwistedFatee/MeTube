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
	$mediaid=$_REQUEST['mid'];
	$targetuserid=$_REQUEST['targetid'];
	
	$result = addcontact($userid, $targetuserid);
		
	if ($mediaid > 0){
		$url = "vedio.php?mid=".$mediaid;
		header('Location:'.$url);
	}
	else{
		$url = "userprofile.php?uid=".$targetuserid;
		header('Location:'.$url);
	}
		
	
}
else
	header('Location:require_login.php');
?>