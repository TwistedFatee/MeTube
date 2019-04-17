<?php
include_once "function.php";
ini_set('session.save_path','/home/cai7/temp');
session_start();


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

	if(isset($_POST['submit'])){
		$mediaid=$_POST['mid'];
		$newlist=mysql_escape_string($_POST['newlistname']);
		if(isset($_POST['playlist']) && strlen($newlist)>0){
			echo "Must choose only one list or create a new list. Failed.";
		}
		else if(!isset($_POST['playlist']) && strlen($newlist)==0){
			echo "Must choose a list or create a new list. Failed.";
		}
		else if(!isset($_POST['playlist']) && strlen($newlist)>0){
			$listname=$newlist;
			$createnewlist=createPlayList($userid, $listname);
			if($createnewlist == 0){
				echo "This listname has been used.";
			}else{
				$addtolist=addToPlaylist($createnewlist, $mediaid);
				if ($addtolist == 1){
				echo "Fail to add media to your play list!";}
				else{
					$content="0;url=vedio.php?mid=".$mediaid;
					echo "<meta http-equiv=\"refresh\" content=\"$content\">";
				}
			}
		}
		else{
			$listname=$_POST['playlist'];
			
			$q="select * from playlist where userid='$userid' and playlistname='$listname'";
			$r=mysql_query($q);
			if (!$r)
			{
				die ("Could not query the database playlist: <br />". mysql_error());
			}
			$result=mysql_fetch_row($r);			
			$listid=$result[0];
			$addtolist=addToPlaylist($listid, $mediaid);
			if ($addtolist == 0){
				echo "Successfully add to your play list!";		
				sleep(3);
				$content="0;url=vedio.php?mid=".$mediaid;
				echo "<meta http-equiv=\"refresh\" content=\"$content\">";}
			else{
				echo "This file already exists in playlist:  ".$listname;
				
			}
		}
	}

}
else
	header('Location:require_login.php');
?>