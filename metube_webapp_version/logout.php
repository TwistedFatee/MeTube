<?php
include_once "function.php";
ini_set('session.save_path','/home/cai7/temp');
session_start();
$uid = $_SESSION["userid"];
$updateaccesstime="update account set lastaccesstime=NOW() where userid='$uid'";
$updateresult=mysql_query($updateaccesstime);
if (!$updateresult)
{
	die ("Could not query the database account and update access time: <br />". mysql_error());
}
session_unset();
session_destroy();
echo "<meta http-equiv=\"refresh\" content=\"0;url=index.php\">";
?>