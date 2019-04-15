<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Your Channel</title>
</head>

<body>
    


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
	<div id = "db_global_nav" class = "db_global_nav" >
        <div class = "bd">
            <div class = "top_nav_left">
                <a href = "index.php" class = "nav_clemson">MeTube</a>
            </div>

            <div class = "top_nav_right">
				<a href = "userprofile.php?uid=<?php echo $userid;?>" class = "nav_login" id = "profile">Profile</a>
                <a href = "logout.php" class = "nav_login" id = "Logout">Log Out</a>
            </div>
        </div>
    </div>
		
	<form method="post" action="createchannelprocess.php" enctype="multipart/form-data" >
		<p>Create your channel</p>
		<p>Channel Name: </p><input type="text" maxlength='50' size='50' name='channelname' required><br>
		<p>Description: </p>
		
		<TEXTAREA name="description" rows="12" cols="80" required>
		</TEXTAREA>
		<br>
		<input type='hidden' name='uid' value=<?php echo $userid;?>>
		<input type='submit' value="Submit" name="submit"><input type='reset' name='reset'><br>
	</form>

</body>
</html>
		
<?php

}
else
	echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";



?>