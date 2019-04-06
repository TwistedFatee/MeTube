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

	<p>Welcome <?php echo $_SESSION['username'];?></p>
	<p>Welcome <?php echo $_SESSION['userid'];?></p>
<?php
if(isset($_GET['mid'])) {
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['mid']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_assoc($result);
	
	updateMediaTime($_GET['mid']);
	updateViews($_GET['mid']);
	
	$filename=$result_row['filename'];
	$filepath=$result_row['filepath'];
	$type=$result_row['type'];
	if(substr($type,0,5)=="image") //view image
	{
		echo "Viewing Picture:";
		echo $result_row['filepath'].$result_row['filename'];
		echo "<br>";
		echo "<img src='".$filepath.$filename."'/>";
	}
	else //view movie
	{	
?>	

	<p>Viewing Video:<?php echo $result_row['medianame'];?></p>
	<object id="MediaPlayer" align="middle" width=420 height=386 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">

<param name="filename" value="<?php echo $result_row['filepath'].$result_row['filename'];  ?>">
<param name="Showcontrols" value="True">
<param name="autoStart" value="True">

<embed type="application/x-mplayer2" src="<?php echo $result_row['filepath'].$result_row['filename'];  ?>" name="MediaPlayer" width=420 height=340></embed>

</object>
	
<?php
	}
}
else
{
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
    
<div class="tool-bar">
        <div class="ops">
            <span title="like" class="like"><i class="iconfont" style="color: grey; font-weight: bold;">&#xe60c;</i>
                Favorite
            </span>
        
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="share" class="share">
            <i class="iconfont" style= "color: grey; font-weight: bold;" >&#xe632;</i>
            Share
            </span>
            
            <canvas width="34" height="34" class="ring-progress" style="width:34px;height:34px;left:-3px;top:-3px;">
            </canvas>
            
            <span title="Favorites" class="subscribe">
                <i class="iconfont" style="color: grey; font-weight: bold;">&#xe63f;</i>
                Subscribe
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
            <form id="commentForm" method="GET" action="http://127.0.0.1:8888/comment">
                <span class="comment-avatar">
                    <img src="images/frog.jpeg" alt="profile">
                </span>
                <textarea class="comment-send-input" name="comment" form="commentForm" cols="80" rows="5" placeholder="Add a public comment..."></textarea>
                <input class="comment-send-button" type="submit" value="Comment">
            </form>
        </div>
        <div class="comment-list" id="commentList">
            <div class="comment">
                <span class="comment-avatar">
                    <img src="images/frog.jpeg" alt="avatar">
                </span>
                <div class="comment-content">
                    <p class="comment-content-name">Daniel</p>
                    <p class="comment-content-article">Amazing!</p>
                    <p class="comment-content-footer">
                        <span class="comment-content-footer-id">#2</span>
                        <span class="comment-content-footer-device">From iPhone</span>
                        <span class="comment-content-footer-timestamp">2019-03-10 14:25</span>
                    </p>
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

<script type="text/javascript" src="js/comment.js"></script>
<script type="text/javascript">
    var video = document.querySelector("video");
    var isPlay = document.querySelector(".switch");
    var expand = document.querySelector(".expand");
    var progress = document.querySelector(".progress");
    var loaded = document.querySelector(".progress > .loaded");
    var currPlayTime = document.querySelector(".timer > .current");
    var totalTime = document.querySelector(".timer > .total");

    video.oncanplay = function(){
        this.style.display = "block";
        totalTime.innerHTML = getFormatTime(this.duration);
    };

    isPlay.onclick = function(){
        if(video.paused) {
            video.play();
        } else {
            video.pause();
        }
        this.classList.toggle("fa-pause");
    };

    expand.onclick = function(){
        video.webkitRequestFullScreen();
    };

    video.ontimeupdate = function(){
        var currTime = this.currentTime,    
            duration = this.duration;       

        var pre = currTime / duration * 100 + "%";
        
        loaded.style.width = pre;

        currPlayTime.innerHTML = getFormatTime(currTime);
    };

    progress.onclick = function(e){
        var event = e || window.event;
        video.currentTime = (event.offsetX / this.offsetWidth) * video.duration;
    };

    video.onended = function(){
        var that = this;
        isPlay.classList.remove("fa-pause");
        isPlay.classList.add("fa-play");
        loaded.style.width = 0;
        currPlayTime.innerHTML = getFormatTime();
        that.currentTime = 0;
    };

    function getFormatTime(time) {
        var time = time || 0;

        var h = parseInt(time/3600),
            m = parseInt(time%3600/60),
            s = parseInt(time%60);
        h = h < 10 ? "0"+h : h;
        m = m < 10 ? "0"+m : m;
        s = s < 10 ? "0"+s : s;

        return h+":"+m+":"+s;
    }
</script>
</body>
</html>