   
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>video player</title>
    <meta name="Author" content="Yining Qiu & Ying Cai">
    <meta name="Description" content="video page">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <link type="image/x-icon" rel="shortcut icon" href="favicon.ico"/>
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/player.css">
    <link rel="stylesheet" href="css/iconfont.css">
	
</head>
<body>

<figure>
	<p>
		<a href="index.php">MeTube</a>
	</p>

    <figcaption>MeTube Video Player</figcaption>
	


<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";

$userloggedin = False;

	if (isset($_SESSION['username'])){
?>

		<p>Welcome <?php echo $_SESSION['username'];?></p>
	
<?php
		if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){			
			$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
			if($checkrandomstring == 0){
				$userid=$_SESSION['userid'];
				$randomstring=$_SESSION['randomstring'];
				$userloggedin = True;
			}
		}
	
	}
	else{
?>
	<p>Welcome </p>
	
<?php
	}
	$ip=$_SERVER['REMOTE_ADDR'];
	
if(isset($_GET['mid'])) {
	$mediaid = $_GET['mid'];	
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['mid']."'";
	$result = mysql_query( $query ) or die("Cannot query media. ".mysql_error());
	$result_row = mysql_fetch_assoc($result);
	$uploadid=$result_row['userid'];
	
	if ($userloggedin){
		$bq = "select * from block where blockid='$userid' and userid='$uploadid' ";
		$br = mysql_query($bq) or die("Cannot query block. ".mysql_error());
		if (mysql_num_rows($br) > 0){
			echo "You are blocked by the media uploader!";
			exit();
		}
	}
	
	$permission = $result_row['permission'];
	if ($permission == 'private'){
		echo "This is a private media!";
		exit();
	}
	
	if ($permission == 'grouponly' && !$userloggedin) {		
		echo "This is a group only media!";
		exit();
	}
	
	if ($permission == 'grouponly' && $userloggedin) {	
		$pq = "select * from groupmember where userid = '$userid' and groupid in (select groupid from groupmember where userid = '$uploadid' )";
		$pr = mysql_query($pq) or die("Cannot query groupmember. ".mysql_error());
		if (mysql_num_rows($pr) == 0){
			echo "This is a group only media!";
			exit();
		}		
	}
	
	$q="select * from account where userid='$uploadid'";
	$r=mysql_query($q) or die("Cannot query account. ".mysql_error());
	$uploadaccount=mysql_fetch_assoc($r);
	$uploadname=$uploadaccount['username'];
	
	updateMediaTime($_GET['mid']);
	if(isset($userid) && isset($randomstring)){
		updateViews($_GET['mid'],$ip, $userid);
	}else{
		updateViews($_GET['mid'],$ip, 0);
	}
	
	$filename=$result_row['filename'];
	$filepath=$result_row['filepath'];
	$type=$result_row['type'];
	
	if(substr($type,0,5)=="image") //view image
	{
		echo "Viewing Picture:";
		echo $result_row['medianame'];
		echo "<br>";
		echo "<img width='900' height='600' src='".$filepath.$filename."'/>";
	}
	elseif(substr($type,0,5)=="audio"){
		
		echo "Viewing Audio:";
		echo $result_row['medianame'];
		echo "<br>";
		echo "<audio controls autoplay><source src='".$filepath.$filename."' type='".$type."'>";
		echo "</audio>";
		
		
	}
	else //view movie
	{	
?>	

	<p>Viewing Video:<?php echo $result_row['medianame'];?></p>

	<object id="MediaPlayer" align="middle" width=960 height=580 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $result_row['filepath'].$result_row['filename'];  ?>">
<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

<embed type="application/x-mplayer2" src="<?php echo $result_row['filepath'].$result_row['filename'];  ?>" name="MediaPlayer" width=960 height=540></embed>

</object>

	
<?php
	}
}
else
{
?>
<meta http-equiv="refresh" content="0;url=index.php">
<?php
}

$q="select count(userid) from flistmedia where mediaid='$mediaid'";
$r = mysql_query($q) or die("Cannot query flistmedia. ".mysql_error());
$likes = mysql_fetch_row($r)[0];

$q="select avg(rate) from rate where mediaid='$mediaid'";
$r = mysql_query($q) or die("Cannot query rate. ".mysql_error());
if (mysql_num_rows($r) == 0){
	$norate = True;
}
else{
	$norate = False;
	$rates = round(mysql_fetch_row($r)[0],1, PHP_ROUND_HALF_UP);
}

$subscribed = False;
$friended = False;
$contacted = False;
$blocked = False;
$liked = False;
$rated = False;


if($userloggedin){
	$q="select * from subscribe where userid = '$userid' and targetid = '$uploadid' ";
	$r = mysql_query($q) or die("Cannot query subscribe. ".mysql_error());
	if (mysql_num_rows($r) > 0)
		$subscribed = True;
	
	$q="select * from friend where ((user1 = '$userid' and user2 = '$uploadid') or  (user2 = '$userid' and user1 = '$uploadid')) and approved = 1";
	$r = mysql_query($q) or die("Cannot query friend. ".mysql_error());
	if (mysql_num_rows($r) > 0)
		$friended = True;
	
	$q="select * from contact where userid = '$userid' and targetid = '$uploadid' ";
	$r = mysql_query($q) or die("Cannot query contact. ".mysql_error());
	if (mysql_num_rows($r) > 0)
		$contacted = True;
	
	$q="select * from block where userid = '$userid' and blockid = '$uploadid' ";
	$r = mysql_query($q) or die("Cannot query block. ".mysql_error());
	if (mysql_num_rows($r) > 0)
		$blocked = True;
	
	$q="select * from flistmedia where userid = '$userid' and mediaid = '$mediaid' ";
	$r = mysql_query($q) or die("Cannot query subscribe. ".mysql_error());
	if (mysql_num_rows($r) > 0)
		$liked = True;
	
	$q = "select * from rate where userid='$userid' and mediaid='$mediaid'";
	$r = mysql_query($q) or die("Cannot query rate. ".mysql_error());
	if (mysql_num_rows($r) > 0){
		$rated = True;
		$rater = mysql_fetch_assoc($r);
		$yourrate = $rater['rate'];
	}
}

?>
    
<div class="tool-bar">
        <div class="ops">
			<p class="comment-content-footer">   
                <span class="comment-content-footer-timestamp">Uploaded by: <?php echo $uploadname;?></span>
				&nbsp;&nbsp;&nbsp;
<?php 
if ($subscribed){
?>
				<a href="unsubscribe.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Unsubscribe</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
else{
?>
				<a href="subscribe.php?uid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Subscribe</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
if ($friended){
?>
				<a href="removefriend.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Remove friend</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
else{
?>
				<a href="addfriend.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Add to friend list</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
if ($contacted){
?>
				<a href="removecontact.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Remove contact</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
else{
?>				
				<a href="addcontact.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Add to contact list</a>
				&nbsp;&nbsp;&nbsp;
<?php
}
?>
				<a target="_blank" href="sendmessage.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Send a message</a>
				&nbsp;&nbsp;&nbsp;	
<?php
if ($blocked){
?>		
				<a href="unblock.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Unblock</a>
<?php
}
else{
?>				
				<a href="block.php?targetid=<?php echo $uploadid;?>&mid=<?php echo $result_row['mediaid'];?>">Block this user</a>
<?php
}
?>
            </p>
		
            <span title="like" class="like"><i class="iconfont" style="color: grey; font-weight: bold;">&#xe60c;</i>
<?php
if ($liked){
?>
				<a href="unlike.php?mid=<?php echo $result_row['mediaid'];?>&back=1" ><?php echo $likes;?>&nbsp;Unlike</a>
<?php
}
else{
?>
				<a href="favorite.php?mid=<?php echo $result_row['mediaid'];?>"><?php echo $likes;?> &nbsp;Like </a>
<?php
}
?>
            </span>
        
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="share" class="share">
            <i class="iconfont" style= "color: grey; font-weight: bold;" >&#xe632;</i>
            <a href="share.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">Share</a>
            </span>
            
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="Favorites" class="playlist">
                <i class="iconfont" style="color: grey; font-weight: bold;">&#xe63f;</i>
                <a href="playlist.php?mid=<?php echo $result_row['mediaid'];?>" >Add to Playlist</a>
            </span>
			
			<canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span>
                <i class="iconfont" style="color: grey; font-weight: bold;">&#xe63f;</i>
                <a href="media_download_process.php?mid=<?php echo $result_row['mediaid'];?>" target='_blank'> Download </a>
            </span>
			
			<span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                Average Rate &nbsp;<?php if (!$norate){echo $rates;};?>
            </span>
			
			<span>
                &nbsp;&nbsp;&nbsp;&nbsp;
<?php
if(!$rated){
?>                 
				<a href="ratemedia.php?mid=<?php echo $result_row['mediaid'];?>">Rate this media</a>
<?php
}
else
{
	
?>	
				Your rate: <?php echo $yourrate;}?>

            </span>
        </div>




</div>
    <div class="container">
        <div class="comment-send">
		
            <form name='postcomment' method="POST" action="comment.php">
                <span class="comment-avatar">
                    <img src="img/frog.jpeg" alt="profile">
                </span>			
                <textarea class="comment-send-input" name="comment" form="commentForm" cols="80" rows="5" placeholder="Add a public comment..."></textarea>
				<input type='hidden' name='mid' value=<?php echo $mediaid;?>>
                <input class="comment-send-button" type="submit" value="Submit">
            </form>
        </div>
		

		

        <div class="comment-list" id="commentList">
		
<?php
$q="select * from comment where mediaid='$mediaid' order by createtime desc";
$r=mysql_query($q);
if(!$r){
	die("Cannot query comments from table comment.<br>".mysql_error());
}
	
?>
            
<?php
	while($result=mysql_fetch_assoc($r)){
		$uid=$result['userid'];
		$q="select username from account where userid='$uid'";
		
		$r2 = mysql_query($q) or die("Cannot query table account.<br>".mysql_error());
		$commentuser=mysql_fetch_row($r2);
		$commentuser=$commentuser[0];
		$time=$result['createtime'];
		$commentcontent=$result['comment'];
?>
			<div class="comment">
                <span class="comment-avatar">
                    <img src="img/frog.jpeg" alt="avatar">
                </span>
                <div class="comment-content">
                    <p class="comment-content-name"><?php echo $commentuser;?></p>
                    <p class="comment-content-article"><?php echo $commentcontent;?></p>
                    <p class="comment-content-footer">   
                        <span class="comment-content-footer-timestamp"><?php echo $time;?></span>
                    </p>
				</div>
                <div class="cls"></div>
            </div>
<?php
	}
?>
                
            
        </div>
    </div>

<br><br>
</body>
</html>

