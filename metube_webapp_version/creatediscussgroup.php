<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create discuss group</title>
</head>

<body>
<h2>
	<a href="index.php">MeTube</a>
</h2>

<form method="post" action="creategroupprocess.php" enctype="multipart/form-data" >
<?php

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
?>
		<p>Create a new group</p>
		<p>Group Name: </p>
		<input type="text" maxlength='50' size='50' name='groupname' />
		<br>
		<br>
		<input type='submit' value="Submit" name="submit" /><input type='reset' name='reset' /><br>
</form>
<p>
	<a href="userprofile.php?uid=<?php echo $userid;?>">Come back to profile</a>
</p>

<p>
	<a href="group.php">Come back to Group List</a>
</p>
<br>
<br>
</body>
</html>
		
<?php

		
	
	
	
}
else
	echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";



?>