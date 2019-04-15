<!DOCTYPE html>
<html>
<body>
<h1>
	<a href="index.php">MeTube</a>
</h1> 
<br><br>
<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

$userlogin = FALSE;
if(isset($_SESSION['userid']) && $_SESSION['userid'] > 0 && isset($_SESSION['randomstring'])){
	$username=$_SESSION['username'];
	$userid=$_SESSION['userid'];
	$randomstring=$_SESSION['randomstring'];
	
	$start=$_SESSION['start'];
	
	$loginrequired=requirelogin($userid, $randomstring, $start);
	if($loginrequired==0)
		$userlogin = TRUE;
}
	
	$key = mysql_escape_string($_REQUEST['keyword']);
	searchwordcloud($key);
	$q="select * from media where (permission='public') and  
		(medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%')";
	if($userlogin){
		$q .= " UNION select * from media where (permission='grouponly') and  
		(medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') 
		and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$userid'))";
	}
	
	
	$key_array=explode(" ", $key);
	$numofkeywords=count($key_array);
	if ($numofkeywords > 1){
	
		for($i=0; $i<$numofkeywords; $i++){
			$key=$key_array[$i];
			searchwordcloud($key);
			$q.="UNION select * from media where (permission='public') and  (medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') ";
			if($userlogin){
				$q .= " UNION select * from media where (permission='grouponly') and  
				(medianame LIKE '%".$key."%' or tag1 LIKE '%".$key."%' or tag2 LIKE '%".$key."%' or tag3 LIKE '%".$key."%' or description LIKE '%".$key."%') 
				and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$userid'))";
			}
		}
	}
	$q.=" order by views desc";
		$r=mysql_query($q) or die("Cannot query media. ".mysql_error());
		if (mysql_num_rows($r) == 0)
			echo "No result";
		else {
			
			while($result_row=mysql_fetch_assoc($r)){
				$q2 = "select * from account where userid=".$result_row['userid'];
				$r2=mysql_query($q2) or die("Cannot query account. ".mysql_error());
				$username=mysql_fetch_assoc($r2);
?>

			<h4>
			
			<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $result_row['medianame']; echo "&nbsp;&nbsp;Views: ".$result_row['views']; echo "&nbsp;&nbsp;Uploaded by: ".$username['username'];?>
			</a>
			
			<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
			<?php
			if(substr($result_row['type'],0,5)=="video"){
			
			?>
			
			
			<img src = "uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt = "img/logo.png" width="200">
			<?php
			}elseif(substr($result_row['type'],0,5)=="image")
			{
			?>
			<img src = "<?php echo $result_row['filepath'].$result_row['filename'];?>" alt = "img/logo.png" width="200">
			
			<?php
			}else{
			?>
			<img src = "img/logo.png" width="200">
			<?php
			}
			?>
			</a>
			
			</h4>

<?php			
			
			
			}
		
	}
?>
</body>
</html>
