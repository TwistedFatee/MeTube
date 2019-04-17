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
	$rate = (int)$_POST['rate'];
	$mediaid = mysql_escape_string($_POST['mid']);
	if (gettype($rate) != 'integer' || $rate < 1 || $rate > 11){
		echo "rate:".$rate.gettype($rate);
		echo "<br>Rate must be an integer in range [1, 10] ! <br> Rate media failed.";
		echo "<a href='vedio.php?mid=".$mediaid."> Back to the media</a>";
		exit();
	}
		
	
	
	
	ratemedia($userid, $mediaid, $rate);
		
	$url="vedio.php?mid=".$mediaid;
	header('Location:'.$url);
}
else
	header('Location:require_login.php');
?>