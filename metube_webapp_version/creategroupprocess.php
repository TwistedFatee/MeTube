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
	$groupname = mysql_escape_string($_POST['groupname']);
	$groupdescription = mysql_escape_string($_POST['description']);
		
	if (strlen($groupname) <= 0 )
		echo "Group Name is required!";
	else{
		creategroup($userid, $groupname, $groupdescription);
		header('Location:group.php');
	}
}
else
	header('Location:require_login.php');
?>