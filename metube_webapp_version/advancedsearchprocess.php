<!DOCTYPE html>
<html>
<body>

<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

$uid=$_SESSION['userid'];

if(isset($_POST['permission'])){
	if($_POST['permission'] == 'public')
		$q="select * from media where permission = 'public' ";
	elseif($_POST['permission'] == 'grouponly')
		$q="select * from media where (permission = 'grouponly' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))) ";
	else
		$q="select * from media where (permission = 'public' or (permission = 'grouponly' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid')))) ";
}
else
	$q="select * from media where permission = 'public' ";

if(strlen($_POST['keyword'])>0){
	$key = $_POST['keyword'];
	$q.="and (medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') ";
}

if($_POST['category'] != "all"){
	$q.="and (category='".$_POST['category']."') ";
}

$video=isset($_POST['video'])? $_POST['video']:0;
$audio=isset($_POST['audio'])? $_POST['audio']:0;
$image=isset($_POST['image'])? $_POST['image']:0;

$typevalue=$video+$audio+$image;

switch($typevalue){
	case 1: 
		$q.=" and type LIKE 'image%' ";
		break;
	case 2:
		$q.=" and type LIKE 'audio%' ";
		break;
	case 4:
		$q.=" and type LIKE 'video%' ";
		break;
	case 3:
		$q.=" and (type LIKE 'image%' or type LIKE 'audio%') ";		
		break;
	case 5:
		$q.=" and (type LIKE 'image%' or type  LIKE 'video%') ";
		break;
	case 6:
		$q.=" and (type LIKE 'audio%' or type LIKE 'video%') ";		
		break;
}

if($_POST['minsize'] > 0){
	$minsize = $_POST['minsize']*1000000;
	$q.=" and size >= $minsize ";
}

if($_POST['maxsize'] > 0){
	$maxsize = $_POST['maxsize']*1000000;
	$q.=" and size <= $maxsize ";
}



$r=mysql_query($q) or die("Cannot query media ".mysql_error());
//echo mysql_num_rows($r);

while($result_row=mysql_fetch_assoc($r)){
	echo $result_row['medianame']."<br>";
}





//if (isset($_POST['video']))
//echo $_POST['category'];
//if (isset($_POST['audio']))
//echo $_POST['audio'];
//if (isset($_POST['image']))
//echo $_POST['image'];
?>
</body>
</html>
