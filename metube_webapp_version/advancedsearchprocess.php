<!DOCTYPE html>
<html>
<body>

<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

if(isset($_SESSION['userid']))
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
	$key = mysql_escape_string($_POST['keyword']);
	searchwordcloud($key);
	$q.="and mediaid IN ( select mediaid from media where (medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') ";
	$key_array=explode(" ", $key);
	$numofkeywords=count($key_array);
	
	if ($numofkeywords > 1)
	{	
		for($i=0; $i<$numofkeywords; $i++)
		{
			$key=$key_array[$i];
			searchwordcloud($key);
			$q.=" UNION select mediaid from media where (medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') ";
		}
	}
	
	$q.=" ) " ;
}

if($_POST['category'] != "all"){
	$q.="and (category='".mysql_escape_string($_POST['category'])."') ";
}

$video=isset($_POST['video'])? 4:0;
$audio=isset($_POST['audio'])? 2:0;
$image=isset($_POST['image'])? 1:0;

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
	$minsize = mysql_escape_string($_POST['minsize'])*1000000;
	$q.=" and size >= $minsize ";
}

if($_POST['maxsize'] > 0){
	$maxsize = mysql_escape_string($_POST['maxsize'])*1000000;
	$q.=" and size <= $maxsize ";
}

if($_POST['beforetime'] != 0){
	$q.=" and uploadtime <= '".mysql_escape_string($_POST['beforetime'])."' " ;
}

if($_POST['aftertime'] != 0){
	$q.=" and uploadtime >= '".mysql_escape_string($_POST['aftertime'])."' " ;
}

if ($_POST['minviews'] != 0){
	$q.=" and views >='". mysql_escape_string($_POST['minviews'])."' ";
}

if ($_POST['maxviews'] != 0){
	$q.=" and views <='". mysql_escape_string($_POST['maxviews'])."' ";
}

$r=mysql_query($q) or die("Cannot query media ".mysql_error());
//echo mysql_num_rows($r);

while($result_row=mysql_fetch_assoc($r)){
	$uid=$result_row['userid'];
	$qu = "select * from account where userid='$uid'";
	$ru = mysql_query($qu) or die("Cannot query account ".mysql_error());
	$rr = mysql_fetch_assoc($ru);
	$username = $rr['username'];
	
	echo "<a href='vedio.php?mid=".$result_row['mediaid']."' >".$result_row['medianame']."</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Uploaded by: ".$username."&nbsp;&nbsp;&nbsp;&nbsp;".$result_row['uploadtime'];
	echo "&nbsp;&nbsp;&nbsp;&nbsp;Views: ".$result_row['views']."<br>";
	
}

if (mysql_num_rows($r) == 0){
?>

<h2>No result found!</h2>
<a href="index.php">MeTube</a>
<br><br>
<a href="advancedsearch.php">Advanced Search</a>
<?php
}
?>
</body>
</html>
