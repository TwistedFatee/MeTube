<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	
	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);
	if($loginrequired!=0){
		header('Location:require_login.php');
	}
	$mediaid=$_REQUEST['mid'];
}
else
{
	header('Location:require_login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rate media</title>
</head>

<body>

<p>Welcome <?php echo $_SESSION['username'];?></p>
<form method="post" action="ratemediaprocess.php" enctype="multipart/form-data" >
 
  <p style="margin:10; padding:10">
  Your rate (1 - 10, an integer): 
  <input type="int" name="rate" maxlength="10" size="5" required><br>
  
	
	<input type='hidden' name='mid' value="<?php echo $mediaid;?>" />
	
	<input value="Rate" name="submit" type="submit" />
	<input type='reset' name='reset' />
  </p>
 
 
 </form>
 <p>
 <a href="userprofile.php?uid=<?php echo $userid;?>">Come back to profile</a>
 </p>
 

<p>
 <a href="index.php">MeTube</a>
 </p> 

</body>
</html>
