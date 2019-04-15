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
	
	$playlistid=$_REQUEST['playlistid'];
	$mediaid=$_REQUEST['mid'];
	$deleteresult = removeFromPlaylist($playlistid, $mediaid);
	
	echo $deleteresult;
	
	if ($deleteresult == 0){
		$url='playlistmedia.php?playlistid='.$playlistid;
		header("Location: ".$url);
	}
}
else
	header("Location: require_login.php");
?>