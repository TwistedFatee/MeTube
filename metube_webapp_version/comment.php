<?php
include_once "function.php";

ini_set('session.save_path','/home/cai7/temp');
session_start();

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];

	$checkuser=user_randomstring_check($userid, $randomstring);
	if($checkuser!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
	if (strlen($_POST['comment']) == 0){
		echo "Comment cannot be empty!";
	}
	elseif (strlen($_POST['comment']) > 65500){
		echo "Comment cannot have more than 65k charactors!";
	}
	else{
		$comment=mysql_escape_string($_POST['comment']);
		$mediaid=$_POST['mid'];
		$q="insert into comment(userid, mediaid, comment, createtime) values ('$userid','$mediaid','$comment', NOW())";
		$r=mysql_query($q);
		if(!$r){
			die("Cannot query table comment.<br>".mysql_error());
		}
		sleep(2);
		$content="0;url=vedio.php?mid=".$mediaid;
		echo "<meta http-equiv=\"refresh\" content=\"$content\">";
	}
}
else
{
	header('Location:require_login.php');
}


?>