<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>


<?php

if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){			
	$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
	
	if($checkrandomstring!=0){
		header('Location:require_login.php');
	}

	$current=time();
	$start=$_SESSION['start'];
	if ($current - $start > 30*60){		//more than 30 mins
		header('Location:require_login.php');
	}
	
	
	//$mediaid=$_REQUEST['mid'];
	$userid=$_SESSION['userid'];
	$targetid=$_REQUEST['targetid'];
		
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Message</title>
</head>

<body>

<form method="post" action="sendmessageprocess.php" enctype="multipart/form-data" >
		
		
		<p>Message</p>
<?php
	$q = "select * from message where fromuserid='$userid' and touserid='$targetid' 
		UNION select * from message where touserid='$userid' and fromuserid='$targetid' order by sendtime";
	$r = mysql_query($q) or die("Cannot query table message.  ".mysql_error());
	while($result_row=mysql_fetch_assoc($r)){
		if($result_row['beenread'] == 0){
			$q1 = "update message set beenread='1' where fromuserid='$targetid' and touserid='$userid'";
			$r1 = mysql_query($q1) or die("Cannot query table message.  ".mysql_error());
		}
		if($result_row['touserid'] == $userid){
			$q1 = "select * from account where userid='$targetid'";
			$r1 = mysql_query($q1) or die("Cannot query table message.  ".mysql_error());
			$result1 = mysql_fetch_assoc($r1);
			$senduser=$result1['username'];
			$fontcolor="red";
		}else{
			$senduser="me";
			$fontcolor="green";
		}
		
?>
		<p><font size="3" color="gray"><?php echo $senduser;?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result_row['sendtime'];?></font></p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<font size="4" color="<?php echo $fontcolor;?>"><?php echo $result_row['message'];?></font></p>
		
<?php
	}
?>
		
		
		<p>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<TEXTAREA name="message" rows="3" cols="40"> </TEXTAREA>
		</p>
		<p>
		<input type="hidden" name="targetid" value="<?php echo $targetid;?>" />
		
		<input value="Send" name="submit" type="submit" /><input value="Reset" name="reset" type="reset" />
		</p>
</form>
<p>
	<a href="message.php">Come back to Message</a>
</p>
<p>
	<a href="userprofile.php?uid=<?php echo $userid;?>">Come back to profile</a>
</p>
 

<p>
	<a href="index.php">MeTube</a>
</p> 
<br><br>

</body>
</html>
		
<?php

		
	
	
	
}
else
	echo "<meta http-equiv=\"refresh\" content=\"0;url=require_login.php\">";



?>