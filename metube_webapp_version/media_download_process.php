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

	$mediaid=$_GET['mid'];
	$userid=$_SESSION['userid'];

	$query="select * from media where mediaid='$mediaid'";
	$result=mysql_query($query);
	if (!$result){
		die("cannot find the media. Could not query the database:<br>".mysql_error());
	}
	else{
		$row=mysql_fetch_row($result);
	
		$file = $row[2].$row[1];


		echo "<meta http-equiv='refresh' content='0;url=$file'>";

	
		//insert into download table
		$insertDownload="insert into download(userid,mediaid) values('$userid','$mediaid')";
		$queryresult = mysql_query($insertDownload);

		if(!queryresult){
			die("media_download_process error. Could not query the database: <br />". mysql_error());
		}
	}
}

?>


