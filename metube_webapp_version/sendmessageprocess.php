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
	
	if (isset($_POST['submit'])){
		$userid=$_SESSION['userid'];	
		//$mediaid=$_REQUEST['mid'];
		$targetuserid=$_POST['targetid'];
		$message=$_POST['message'];
		
		$result = sendmessage($userid, $targetuserid,$message);

		$url="sendmessage.php?targetid=".$targetuserid;
		header('Location:'.$url);
	
	}	
	
}
else
	header('Location:require_login.php');
?>