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

	if (isset($_SESSION['username']) && isset($_SESSION['password'])){
		$userlogin=user_pass_check($_SESSION['username'],$_SESSION['password']);
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
				
				$insertDownload="insert into download(userid, mediaid) values('$userid','$mediaid')";
				$queryresult = mysql_query($insertDownload);

				if(!$queryresult){
					die("media_download_process error. Could not query the database download: <br />". mysql_error());
				}
				
				$updatedownloads="update media set downloads=downloads+1 where mediaid='$mediaid'";
				$updateresult=mysql_query($updatedownloads);
				if(!$queryresult){
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


