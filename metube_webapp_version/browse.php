<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	ini_set('session.save_path','/home/cai7/temp');
	session_start();
	include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />


</head>

<body>
<?php
if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$checkstring=user_randomstring_check($_SESSION['userid'],$_SESSION['randomstring']);
	if($checkstring == 0){
?>


<p>Welcome <?php echo $_SESSION['username'];?></p>

<?php
	}
	else{
		echo "Welcome<br>";
	}
}
else{
		echo "Welcome<br>";
	}
?>
<a href='media_upload.php'  style="color:#FF9900;">Upload File</a>
<div id='upload_result'>
<?php 

	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{
		
		echo upload_error($_REQUEST['result']);

	}

?>
</div>
<br/><br/>
<?php


	$query = "SELECT * from media "; 
	$result = mysql_query( $query );
	if (!$result)
	{
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    
    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			while ($result_row = mysql_fetch_assoc($result))
			{ 
		?>
        <tr valign="top">			
			<td>
					<?php 
						echo $result_row['mediaid'];
					?>
			</td>
            <td>
            	<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $result_row['medianame'];?></a> 
            </td>
            <td>
            	<a href="media_download_process.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">Download</a>
            </td>
		</tr>
        <?php
			}
		?>
	</table>

</body>
</html>
