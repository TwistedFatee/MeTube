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
	$deleteresult = unblockuser($userid, $targetid);
	$mediaid=$_REQUEST['mid'];
	
	if ($mediaid > 0){
		$url = "vedio.php?mid=".$mediaid;
		header('Location:'.$url);
	}
	else{
		header("Location: blocklist.php");
	}
}
else
	header("Location: require_login.php");
?>