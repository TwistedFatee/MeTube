<!DOCTYPE html>

<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	$mediaid=$_REQUEST['mid'];

	$checkuser=user_randomstring_check($userid, $randomstring);
	if($checkuser!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
?>
<html>
<body>
<p>Please share the link: <br><?php 
	echo "http://webapp.cs.clemson.edu/~cai7/metube/vedio.php?mid=".$mediaid;?></p>
</body>
</html>
<?php
	
}
else
{
	header('Location:require_login.php');
}
?>