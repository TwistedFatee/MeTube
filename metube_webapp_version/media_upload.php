<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$password=$_SESSION['password'];

	$checkuser=user_pass_check($username, $password);
	if($checkuser!=0){
		header('Location:require_login.php');
	}		
}
else
{
	header('Location:require_login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
</head>

<body>
<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
 
  <p style="margin:0; padding:0">
  <input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 100M)</em></label><br/>
   <input  name="file" type="file" size="50" />
	<br>
	Category&nbsp;
	<select name="category">
    <option value="sports">Sport</option>
    <option value="movie">Movie</option>
    <option value="tv">TV</option>
    <option value="talkshow">Talk Show</option>
	<option value="cartoon">Cartoon</option>
    <option value="game">Game</option>
    <option value="documentary">Documentary</option>
	</select>
	<br>
	Permission&nbsp;<input type="radio" name="public" value="public"/>Public<input type="radio" name="private" value="private"/>Private
	<br>
	<input value="Upload" name="submit" type="submit" />
  </p>
 
                
 </form>

</body>
</html>
