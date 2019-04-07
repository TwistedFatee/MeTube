<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

/******************************************************
*
* download by username
*
*******************************************************/
if (isset($_GET['mid'])){
	if(isset($_SESSION['start'])){
		$current=time();
		$start=$_SESSION['start'];
		if ($current - $start > 30*60){		//more than 30 mins
			header('Location:require_login.php');
		}
	}

	if (isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$userlogin=user_randomstring_check($_SESSION['userid'],$_SESSION['randomstring']);
		if($userlogin==0){
			$userid=$_SESSION['userid'];
			$mediaid=$_GET['mid'];
			$query="select * from media where mediaid='$mediaid'";
			$result=mysql_query($query);
			if (!$result){
				die("cannot find the media. Could not query the database:<br>".mysql_error());
			}
			else{
				$row=mysql_fetch_assoc($result);
	
				$file = $row['filepath'].$row['filename'];

				echo "Download file".$row['filename'];
				echo "<meta http-equiv='refresh' content='0;url=$file'>";				
	
				//insert into download table
				
				$query="select * from download where userid='$userid' and mediaid='$mediaid'";
				$result=mysql_query($query);
				if (!$result){
					die("cannot find the media. Could not query the database:<br>".mysql_error());
				}
				$numrows=mysql_num_rows($result);
				if($numrows == 0){
				
					$insertDownload="insert into download(userid, mediaid) values('$userid','$mediaid')";
					$queryresult = mysql_query($insertDownload);

					if(!$queryresult){
						die("media_download_process error. Could not query the database download: <br />". mysql_error());
					}
				}else{
					$query="update download set downloadtime=NOW() where userid='$userid' and mediaid='$mediaid'";
					$result=mysql_query($query);
					if (!$result){
						die("cannot find the media. Could not query the database:<br>".mysql_error());
					}
				}
				
				$updatedownloads="update media set downloads=downloads+1 where mediaid='$mediaid'";
				$updateresult=mysql_query($updatedownloads);
				if(!$updateresult){
					die("media_download_process error. Could not query the database media: <br />". mysql_error());
				}
			}
		}
		else{
			echo "Please login to download files!<br>";
			echo "<a href=\"login.php\">Sign In</a><br>";
			echo "Return to MeTube<br>";
			echo "<a href=\"index.php\">MeTube</a><br>";
		}
	}
	else{
		echo "Please login to download files!<br>";
		echo "<a href=\"login.php\">Sign In</a><br>";
		echo "Return to MeTube<br>";
		echo "<a href=\"index.php\">MeTube</a><br>";
	}

}

?>


