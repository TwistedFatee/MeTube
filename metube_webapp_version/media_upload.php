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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
</head>

<body>

<p>Welcome <?php echo $_SESSION['username'];?></p>
<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
 
  <p style="margin:0; padding:0">
  Media name (Limit 128 charactors): 
  <input type="text" name="medianame" maxlength="128" size="50" required><br>
  Media description (Limit 1000 charactors):<br>
  <TEXTAREA name="description" rows="12" cols="80">
  </TEXTAREA>
  <br>
  Tag 1 (Limit 50 charactors): 
  <input type="text" name="tag1" maxlength="50" size="50"><br>
  Tag 2 (Limit 50 charactors): 
  <input type="text" name="tag2" maxlength="50" size="50"><br>
  Tag 3 (Limit 50 charactors): 
  <input type="text" name="tag3" maxlength="50" size="50"><br>
  <input type="hidden" name="MAX_FILE_SIZE" value="104857600" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 100M)</em></label><br/>
   <input  name="file" type="file" size="50" required>
	<br>
	Category&nbsp;
	<select name="category" required>
    <option value="sports">Sport</option>
    <option value="movie">Movie</option>
    <option value="tv">TV</option>
    <option value="talkshow">Talk Show</option>
	<option value="cartoon">Cartoon</option>
    <option value="game">Game</option>
    <option value="documentary">Documentary</option>
	</select>
	<br>
	Permission&nbsp;
	<input type="radio" name="private" value="public" required>Public
	<input type="radio" name="private" value="grouponly" required>Group Only
	<input type="radio" name="private" value="private" required>Private
	<br>
	
	
	
	
	<input value="Upload" name="submit" type="submit" />
  </p>
 
                
 </form>

</body>
</html>
