<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add to Playlist</title>
</head>

<body>

<form method="post" action="playlistprocess.php" enctype="multipart/form-data" >
<?php

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring']) && isset($_GET['mid'])){			
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
		$mediaid=$_REQUEST['mid'];
		
		$q="select * from playlist where userid='$userid'";
		$r=mysql_query($q);
		if (!$r)
		{
			die ("Could not query the database playlist: <br />". mysql_error());
		}
		
		$numrows=mysql_num_rows($r);
		if ($numrows > 0){
?>
			
			
<?php
		
			while ($result_row = mysql_fetch_assoc($r)){
				$listname=$result_row['playlistname'];
				
				
?>
			<input type='radio' value='<?php echo $listname;?>' name='playlist'><?php echo $listname;?>
<?php
			
			}
		}
?>
		
		</select><br>
		<p>Create a new list</p>
		<p>List Name: </p><input type="text" maxlength='50' size='50' name='newlistname'><br>
		<input type='hidden' name='mid' value=<?php echo $mediaid;?>>
		<input type='submit' value="Submit" name="submit"><input type='reset' name='reset'><br>
</form>

</body>
</html>
		
<?php

		
	
	
	
}
else
	echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";



?>