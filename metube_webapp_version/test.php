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
	
	$q="select * from account where userid='$userid'";
	$r = mysql_query($q) or die("Cannot query account.".mysql_error());
	$result = mysql_fetch_assoc($r);
	$oldphone=$result['phone'];
	$oldemail=$result['email'];
	echo $oldphone;
	echo $oldemail;
}
else
{
	header('Location:require_login.php');
}
?>