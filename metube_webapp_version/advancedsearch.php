<!DOCTYPE html>
<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>

<html>
<body>
<form method='post' action='advancedsearchprocess.php'>
<p>Keyword&nbsp;<input type="text" name="keyword" size="50"></p>
<p>
Category&nbsp;<br>
	<input type='radio' name='category' value='all' checked='checked' required>All category
	<input type='radio' name='category' value='sport'>Sport
	<input type='radio' name='category' value='music'>Music
	<input type='radio' name='category' value='movie'>Movie
    <input type='radio' name='category' value='tv'>TV
    <input type='radio' name='category' value='talkshow'>Talk Show
	<input type='radio' name='category' value='cartoon'>Cartoon
    <input type='radio' name='category' value='game'>Game
    <input type='radio' name='category' value='othertype'>Other Type
</p>

<p>
Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Default: All Types)<br>

	<input type='checkbox' name='video' value='4' >Video
	<input type='checkbox' name='audio' value='2' >Audio
	<input type='checkbox' name='image' value='1' >Image
	
</p>

<p>
File Size (Unit: MByte)<br>
Min&nbsp;<input type='int' name='minsize' size='10'>&nbsp;&nbsp;Max&nbsp;<input type='int' name='maxsize' size='10'><br>
</p>

<p>
Uploaded time<br>
Before&nbsp;<input type='date' name='beforetime'>&nbsp;&nbsp;After&nbsp;<input type='date' name='aftertime'><br>
</p>

<p>
Number of views<br>
Min&nbsp;<input type='int' name='minviews' size='10'>&nbsp;&nbsp;Max&nbsp;<input type='int' name='maxviews' size='10'><br>
</p>

<?php
if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	
	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);
	
?>
<?php
	if($loginrequired==0){
		
?>


<p>
Permission<br>
<input type="radio" name="private" value="all" checked='checked' required>All
<input type="radio" name="private" value="public">Public
<input type="radio" name="private" value="grouponly" required>Group Only
</p>

<?php
	}
}
?>
<input type='submit' name='advancedsearchsubmit'>
</form>
</body>
</html>