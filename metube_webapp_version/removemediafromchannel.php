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
	
	
	$result = removefromchannel($mediaid, $userid);
		
	if ($result == 1)
		echo "No channel exists! Please create your own channel!";
	
	else{
		
		header('Location:userpchannel.php');
	}
}
else
	header('Location:require_login.php');
?>