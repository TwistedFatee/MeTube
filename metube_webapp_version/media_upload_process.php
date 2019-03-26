<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/
if(isset($_SESSION['username']) && isset($_SESSION['password'])){


	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$password=$_SESSION['password'];

	$checkuser=user_pass_check($username, $password);
	if($checkuser==0){

	//Create Directory if doesn't exist
		if(!file_exists('uploads/'))
			mkdir('uploads/', 0755);
		$dirfile = 'uploads/'.$username.$userid.'/';
		if(!file_exists($dirfile)){
			mkdir($dirfile, 0755);
			chmod($dirfile, 0755);
		}
		
		if($_FILES["file"]["error"] > 0 )
		{ 
			$result=$_FILES["file"]["error"];
		} //error from 1-7
		else
		{
			$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
			if(file_exists($upfile))
			{
				$result="5"; //The file has been uploaded.
			}
			else
			{
				if(is_uploaded_file($_FILES["file"]["tmp_name"]))
				{
					if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
					{
						$result="6"; //Failed to move file from temporary directory
					}
					else /*Successfully upload file*/
					{
						chmod($upfile, 0644);
						//insert into media table
						$insert = "insert into media(filename,filepath,type) "."values('". urlencode($_FILES["file"]["name"])."','$dirfile','".$_FILES["file"]["type"]."')";
						$queryresult = mysql_query($insert)
							or die("Insert into Media error in media_upload_process.php " .mysql_error());
					
					
						$mediaid = mysql_insert_id();
					//$query="select * from account where username='$username'";
					//$result=mysql_query($query);
					//if (!$result)
					//{
						//die ("cannot find userid. Could not query the database: <br />". mysql_error());
					//}
					//else{
						//$row = mysql_fetch_row($result);
						//$userid=$row[0];
						//insert into upload table
						$insertUpload="insert into upload(userid,mediaid) values('$userid','$mediaid')";
						$queryresult = mysql_query($insertUpload)
							or die("Insert into view error in media_upload_process.php " .mysql_error());
						$result="0";
					//}
					}
				}
			
			}
		}
		header('Location:browse.php?result=$result');
	}
	else
	{
		header('Location:require_login.php');
	}
}
else
{
	header('Location:require_login.php');
}
	//You can process the error code of the $result here.
?>


