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
    <p>MeTube Video Player</figcaption>
	


<?php
ini_set('session.save_path','/home/cai7/temp');
session_start();
include_once "function.php";
?>

<?php
	if (isset($_SESSION['username'])){
?>

		<p>Welcome <?php echo $_SESSION['username'];?></p>
	
<?php
		if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){			
			$checkrandomstring=user_randomstring_check($_SESSION['userid'], $_SESSION['randomstring']);
			if($checkrandomstring == 0){
				$userid=$_SESSION['userid'];
				$randomstring=$_SESSION['randomstring'];
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
	$result = mysql_query( $query );
	$result_row = mysql_fetch_assoc($result);
	
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
		echo "<img src='".$filepath.$filename."'/>";
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
?>
    
<div class="tool-bar">
        <div class="ops">
            <span title="like" class="like"><i class="iconfont" style="color: grey; font-weight: bold;">&#xe60c;</i>
              <a href="favorite.php?mid=<?php echo $result_row['mediaid'];?>"> Favorite </a>
            </span>
        
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="share" class="share">
            <i class="iconfont" style= "color: grey; font-weight: bold;" >&#xe632;</i>
            <a href="share.php?mid=<?php echo $result_row['mediaid'];?>">Share</a>
            </span>
            
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="Favorites" class="playlist">
                <i class="iconfont" style="color: grey; font-weight: bold;">&#xe63f;</i>
                <a href="playlist.php?mid=<?php echo $result_row['mediaid'];?>" target='_blank'>Add to Playlist</a>
            </span>
			
			<canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span>
                <i class="iconfont" style="color: grey; font-weight: bold;">&#xe63f;</i>
                <a href="media_download_process.php?mid=<?php echo $result_row['mediaid'];?>" target='_blank'> Download </a>
            </span>
        </div>




</div>
    <div class="container">
        <div class="comment-send">
		
            <form id="commentForm" method="POST" action="comment.php?mid=<?php echo $mediaid;?>">
                <span class="comment-avatar">
                    <img src="images/frog.jpeg" alt="profile">
                </span>			
                <textarea class="comment-send-input" name="comment" form="commentForm" cols="80" rows="5" placeholder="Add a public comment..."></textarea>
                <input class="comment-send-button" type="submit" value="Comment">
            </form>
        </div>
        <div class="comment-list" id="commentList">
		
<?php
$q="select username, comment, comment.createtime as ctime 
	from comment inner join media inner join account on comment.userid=account.userid 
	where comment.mediaid='$mediaid'";
$r=mysqli_query($q);
if(!r){
	die("Cannot query comments from table comment, account.<br>".mysql_error());
}

$result=mysqli_fetch_assoc($r);
if(mysqli_num_rows($result) != 0){

?>
            <div class="comment">
                <span class="comment-avatar">
                    <img src="images/frog.jpeg" alt="avatar">
                </span>
                <div class="comment-content">
<?php
	while($result){
		$username = $result['username'];
		$time=$result['ctime'];
		$comment=
?>
                    <p class="comment-content-name">Daniel</p>
                    <p class="comment-content-article">Amazing!</p>
                    <p class="comment-content-footer">   
                        <span class="comment-content-footer-device">From iPhone</span>
                        <span class="comment-content-footer-timestamp">2019-03-10 14:25</span>
                    </p>
<?php
	}
}
?>
                </div>
                <div class="cls"></div>
            </div>
            <div class="comment comment-bottom">
                <span class="comment-avatar">
          <img src="images/frog.jpeg" alt="avatar">
        </span>
                <div class="comment-content">
                    <p class="comment-content-name">Michael</p>
                    <p class="comment-content-article">Very helpful!</p>
                    <p class="comment-content-footer">
                        <span class="comment-content-footer-id">#1</span>
                        <span class="comment-content-footer-device">From Windows</span>
                        <span class="comment-content-footer-timestamp">2019-03-15 13:15</span>
                    </p>
                </div>
                <div class="cls"></div>
            </div>
        </div>
    </div>


</body>
</html>