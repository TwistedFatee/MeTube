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
	if($loginrequired != 0){
		header('Location:require_login.php');
	}
	
	if (isset($_POST['submit'])){
		$currentpassword = mysql_escape_string($_POST['old-password']);
		$checkpass=user_pass_check($username, $currentpassword);
		if ($checkpass != 0){
			echo "Current password is wrong!";
			exit();
		}
		
		if(strlen($_POST['new-password'])<4){
			$register_error = "Password need have at least 4 characters.";
		}		
		else if(strcmp($_POST['new-password'],$_POST['confirm-password'])){
			$register_error = "Password and comfirmation don't match.";
		}
		else {
			$password = mysql_escape_string($_POST['new-password']);
			
			$q="update account set password='$password' where userid='$userid'";
			$r = mysql_query($q) or die("Cannot change password. Cannot query account.".mysql_error());
			
			
			$url='userprofile.php?uid='.$userid;
			
			header("Location: ".$url);
			
		}
	}
}
	
else
{
	header('Location:require_login.php');
}

if(isset($register_error))
	echo $register_error;
?>