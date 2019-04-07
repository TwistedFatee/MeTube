<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";


if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){			
	$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
	if($checkrandomstring == 0){
		$userid=$_SESSION['userid'];
		$randomstring=$_SESSION['randomstring'];
		$mediaid=$_GET['mid'];
		$addfavorite=addFavorite($userid, $mediaid);
		echo "Successfully add to your favorite list!";
		
		sleep(2);
		$content="0;url=vedio.php?mid=".$mediaid;
		echo "<meta http-equiv=\"refresh\" content=\"$content\">";
		
	}else{
		echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";
	}
	
	
}
else
	echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";



?>