<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/
if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){


	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];

	$checkuser=user_randomstring_check($userid, $randomstring);
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
			echo upload_error($result).". Upload fails.";
		} //error from 1-7
		else if($_POST['medianame']==NULL){
			echo "File must have a name! Uploading failed.";
		}
		
		else
		{
			$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
			if(file_exists($upfile))
			{
				$result="5"; //The file has been uploaded.
				echo upload_error($result);
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
						
						$medianame=mysql_escape_string($_POST['medianame']);
						$description=mysql_escape_string($_POST['description']);
						$tag1=mysql_escape_string($_POST['tag1']);
						$tag2=mysql_escape_string($_POST['tag2']);
						$tag3=mysql_escape_string($_POST['tag3']);
						$category=$_POST['category'];
						$permission=$_POST['private'];
						$size=$_FILES["file"]["size"];
						
						$insert = "insert into media(filename,filepath,type,userid,medianame,description,tag1,tag2,tag3,permission,size,category) "
						."values('". urlencode($_FILES["file"]["name"])."','$dirfile','".$_FILES["file"]["type"]."','$userid','$medianame','$description','$tag1','$tag2','$tag3','$permission','$size','$category')";
						$queryresult = mysql_query($insert);
						if(!$queryresult){
							die("Insert into Media error in media_upload_process.php ".mysql_error());
						}
					
						$mediaid = mysql_insert_id();
						$q="update media set uploadtime=NOW() where mediaid='$mediaid'";
						$uploadresult=mysql_query($q);
						if(!$uploadresult){
							die("Uploadtime error in media_upload_process.php ".mysql_error());
						}
					}
				}
			header('Location:index.php');
			}
			
		}
		
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

?>


