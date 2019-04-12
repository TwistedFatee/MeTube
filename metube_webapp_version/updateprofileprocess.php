<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	
	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);
	
	if($loginrequired!=0){
		header('Location:require_login.php');
	}
	
	$targetid=$_POST['uid'];
	
	if ($targetid != $userid){
		exit();
	}
	
	if(strlen($_POST['email']) == 0)
		$email=$_POST['oldemail'];
	else	
		$email=mysql_escape_string($_POST['email']);
	
	if(strlen($_POST['phone']) == 0)
		$phone=$_POST['oldephone'];
	else	
		$phone=mysql_escape_string($_POST['phone']);
	
	$q="update account set email='$email', phone='$phone' where userid='$userid'";
	$r = mysql_query($q) or die("Cannot query account.".mysql_error());
	$url='userprofile.php?uid='.$userid;
			
			header("Location: ".$url);
	
}
else
{
	header('Location:require_login.php');
}



?>