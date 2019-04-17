<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MeTube</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/iconfont.css">
</head>
<body>
   <div class = "allDiv">
    <div class="topbar">
        <div class="container">
            <div class="topbar-developer" >
                <a href="">MeTube by Ying Cai & Yining Qiu</a> 
            </div>
			<div class="topbar-developer" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
            </div>
			
            
			
            <div class="topbar-developer" align="right">
<?php
	ini_set('session.save_path','/home/cai7/temp');
	session_start();	
	include_once "function.php";
	
	$userlogin = FALSE;
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$userid = $_SESSION['userid'];			
		$randomstring= $_SESSION['randomstring'];
		$username=$_SESSION['username'];
		$result = user_randomstring_check($userid, $randomstring);
		if($result == 0){
			$userlogin = TRUE;
			$uid=$_SESSION['userid'];
			$q="select count(message) as cnt from message where touserid='$userid' and beenread='0'";
			$r=mysql_query($q) or die("Cannot query message.  ".mysql_error());
			$result=mysql_fetch_assoc($r);
			$unreadmessage=$result['cnt'];
			echo "<font color=\"red\" size=\"4\">Welcome ".$username."</font><span> | </span><a href=\"userprofile.php?uid=".$userid."\"><font color=\"red\">Account</font></a><span> | </span>
			<a href=\"logout.php\"><font color=\"red\">Log Out</font></a><span> | </span>
			<div class=\"topbar-message\"><a href=\"message.php\"> <i class=\"iconfont\">&#xe625;</i><span> (".$unreadmessage.") </span></a></div>";
		}
		else
			echo "<a href=\"login.php\"><font color=\"red\">Sign In</font></a><span> | </span><a href=\"register.php\"><font color=\"red\">Sign Up</font></a><span> | </span>";
				
	}
	else
		echo "<a href=\"login.php\"><font color=\"red\">Sign In</font></a><span> | </span><a href=\"register.php\"><font color=\"red\">Sign Up</font></a><span> | </span>";
			
	
?>   
            </div>
        </div>
    </div>


	
	
    <!-- Category bar -->
    <div class="layout">
        <div class="header">
            <div class="header-container">
                <div class="header-logo">
                    <a href="index.php" class="t1">MeTube</a>
                </div>
                <div class="header-category">
                    <ul class="category-list clearfloat" id="tabs">
                        <li class="item">
                            <a href="category.php?category=sport">Sports</a>
                        </li>
						<li class="item">
                            <a href="category.php?category=music">Music</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=movie">Movie</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=tv">TV Series</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=talkshow">Talk Show</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=cartoon">Cartoon</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=game">Games</a>
                        </li>
                        <li class="item">
                            <a href="category.php?category=othertype">Other</a>
                        </li>
                    </ul>
                </div>
				
                <div class="header-search">
                    <form action="search.php" class="search-form">
                        <input type="search" name="keyword" class="search-text" placeholder="search">						
                        
						<a href="advancedsearch.php">Advanced Search</a>
						
						
                    </form>
					<br>
					<p>
					<a href="all_groups.php">Discussion Groups</a>&nbsp;&nbsp;&nbsp;&nbsp;
					<a target='_blank' href='wordcloud.php'>Word Cloud</a>
					</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
<?php	
if($userlogin){
	$uid=$_SESSION['userid'];			
	//recently views by userid 	
	$q="select * from view inner join media on view.mediaid=media.mediaid where view.userid='$uid' order by view.viewtime desc limit 12";	
	
	
}else{
	$ip = $_SERVER['REMOTE_ADDR'];
	$q="select * from view inner join media on view.mediaid=media.mediaid 
		where media.permission='public' and view.ip='$ip'  order by view.viewtime desc limit 12";
			
}	
		$r=mysql_query($q) or die ("Could not query the database view: <br />". mysql_error());
		
?>
		
			<div class="movie">
                <p class="recommend clearfloat"><a href="recentlyviews.php">Recently Views</a></p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>
					<li class="view">					
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
					<?php
					if (substr($result_row['type'],0,5) == "video"){
					
					?>					
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
					<?php
					}
					elseif(substr($result_row['type'],0,5) == "image"){
					?>
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
					<?php						
					}
					else
					{
					?>					
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
					<?php
					}					
					?>					
							</a>
						</div>
						<div class="intro">
						<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
						</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p>
						</div>
					</li>
				<?php
				}
				?>
                </ul>
            </div>
		
		<?php

if ($userlogin){
	$q = "select * from media where permission='public' 
		and userid not in ( select userid from block where blockid='$uid' ) order by uploadtime desc limit 12";
}
else
	$q="select * from media where permission='public' order by uploadtime desc limit 12";
		
		
$r=mysql_query($q);
if(!$r){
	die ("Could not query the database view: <br />". mysql_error());
}
		
		
?>
			<div class="movie">
                <p class="recommend clearfloat"><a href="recentlyupload.php">Recently Uploads</a></p>
                <ul class="clearfloat">
<?php
while ($result_row = mysql_fetch_assoc($r))
{ 
	$mname=$result_row['medianame'];
	$uploaderid = $result_row['userid'];
	$quploader = "select username from account where userid = '$uploaderid'";
	$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
	$uploader = mysql_fetch_row($ruploader)[0];
?>			
					<li>				
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
					<?php
					if (substr($result_row['type'],0,5) == "video"){
					
					?>					
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
					<?php
					}
					elseif(substr($result_row['type'],0,5) == "image"){
					?>
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
					<?php						
					}else
					{
					?>					
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
					<?php
					}					
					?>					
							</a>
						</div>
						<div class="intro">
						<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
						</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					</li>
<?php
}
?>
                </ul>
            </div>
			
<?php	
if($userlogin){        //recently uploaded group-only media 	
	$q = "select * from media where permission='grouponly' and 
		userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		and userid not in (select userid from block where blockid='$uid') 
		order by uploadtime desc limit 12";
		
		
	$r=mysql_query($q) or die ("Could not query the database groupmember: <br />". mysql_error());		
		
?>
			<div class="movie">
                <p class="recommend clearfloat">Recently Group-member Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>			
                    <li>					
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
					<?php
					if (substr($result_row['type'],0,5) == "video"){
					
					?>					
						<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
					<?php
					}
					elseif(substr($result_row['type'],0,5) == "image"){
					?>
					<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
					<?php						
					}
					else
					{
					?>					
						<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
					<?php
					}					
					?>					
							</a>
						</div>
						<div class="intro">
						<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
						</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					</li>
				<?php
				}
				?>
				</ul>
            </div>
			<?php
}
?>
                
			
<?php	//most views
if($userlogin){
	$q="select * from media where permission='public' and userid not in (select userid from block where blockid='$uid') 
		UNION
		select * from media where permission='grouponly' 
			and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
			and userid not in (select userid from block where blockid='$uid') 
		order by views desc limit 12";
}
else
	$q="select * from media where permission='public' order by views desc limit 12";
		
		
$r=mysql_query($q);
if(!$r){
	die ("Could not query the database view: <br />". mysql_error());
}
		
		
?>
		
		
			<div class="movie">
                <p class="recommend clearfloat"><a href="mostviews.php">Most Views</a></p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>			
                    <li>
						
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
					
					<?php
					if (substr($result_row['type'],0,5) == "video"){
					
					?>		
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >	
																
					<?php
					}
					elseif(substr($result_row['type'],0,5) == "image"){
					?>
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
					<?php						
					}
					else
					{
					?>					
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
					<?php
					}					
					?>					
							</a>
						</div>
						<div class="intro">
							<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
							</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					
					</li>
				<?php
				}
				?>
                </ul>
            </div>
		
<?php
if ($userlogin){
	$q = "select distinct tag from 
		(select distinct tag1 as tag from (select tag1, viewtime from view inner join media on view.mediaid = media.mediaid where view.userid = '$uid' order by view.viewtime desc ) as a where tag1 != '' 
		union 
		select distinct tag2 as tag from (select tag2, viewtime from view inner join media on view.mediaid = media.mediaid where view.userid = '$uid' order by view.viewtime desc ) as b where tag2 != ''  
		union
		select distinct tag3 as tag from (select tag3, viewtime from view inner join media on view.mediaid = media.mediaid where view.userid = '$uid' order by view.viewtime desc ) as c where tag3 != ''   
		) as d limit 4";
}else{
	$q = "select distinct tag from 
		(select distinct tag1 as tag from (select tag1, viewtime from view inner join media on view.mediaid = media.mediaid where view.ip = '$ip' order by view.viewtime desc ) as a where tag1 != '' 
		union 
		select distinct tag2 as tag from (select tag2, viewtime from view inner join media on view.mediaid = media.mediaid where view.ip = '$ip' order by view.viewtime desc ) as b where tag2 != ''  
		union
		select distinct tag3 as tag from (select tag3, viewtime from view inner join media on view.mediaid = media.mediaid where view.ip = '$ip' order by view.viewtime desc ) as c where tag3 != ''   
		) as d limit 4";
}
	$r = mysql_query($q) or die("Could not query the database media or view: <br />". mysql_error());
	$q = " ";
	while($result = mysql_fetch_assoc($r)){
		$q .= "select * from media where tag1 like '%".$result['tag']."%' or tag2 like '%".$result['tag']."%' or tag3 like '%".$result['tag']."%' or 
			medianame like '%".$result['tag']."%' or description like '%".$result['tag']."%'  UNION ";
	}
	$q.=" select * from media where mediaid=0";
	$r = mysql_query($q) or die("Could not query the database media: <br />". mysql_error());
	$loop = 0;
	
?>
 
            <div class="movie">
                <p class="recommend clearfloat"><a href="recommend.php">Recommend</a></p>
                <ul class="clearfloat">
				
<?php
	while ($result_row = mysql_fetch_assoc($r)){
		$uploaderid = $result_row['userid'];
		
		if ($result_row['permission'] == 'private')
			continue;
		
		if ($userlogin){
			
			$blocked = checkblocked($uploaderid, $uid);
			if ($blocked > 0)
				continue;
		
			$grouped = checkgrouped($uploaderid, $uid);
			if ($result_row['permission'] == 'grouponly' && $grouped > 0)
				continue;
			
		}
		
		if (!$userlogin && $result_row['permission'] != 'public')
			continue;
		
					$mname=$result_row['medianame'];
					
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
					
					
?>
	

                   <li>
						
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
					
					<?php
					if (substr($result_row['type'],0,5) == "video"){
					
					?>		
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >	
																
					<?php
					}
					elseif(substr($result_row['type'],0,5) == "image"){
					?>
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
					<?php						
					}
					else
					{
					?>					
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
					<?php
					}					
					?>					
							</a>
						</div>
						<div class="intro">
							<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
							</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					
					</li>
<?php	
		$loop += 1;
		if ($loop >11)
			break;
	}


?>
                </ul>
            </div>
          
        

        
			<div class="movie">
                <p class="recommend clearfloat"><a href="videolist.php">Video</a></p>
                <ul class="clearfloat">
<?php
//videos
if ($userlogin) {
	$q="select * from media where permission='public' and type like 'video%'  
		and userid not in (select userid from block where blockid='$uid') 
		UNION
		select * from media where permission='grouponly' and type like 'video%' 
			and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
			and userid not in (select userid from block where blockid='$uid') 
		order by views desc limit 12";
}
else	
	$q="select * from media where permission='public' and type like 'video%' order by views desc limit 12";		

		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
				
				
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>			
                    <li>			
					
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
										
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
								
							</a>
						</div>
						<div class="intro">
						<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
						</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					</li>
					
				<?php
				}
				?>
				
				
                </ul>
            </div>
           
            <div class="movie">
                <p class="recommend clearfloat"><a href="audiolist.php">Audio</a></p>
                <ul class="clearfloat">
<?php	//audios
if ($userlogin) {
	$q="select * from media where permission='public' and type like 'audio%'  
		and userid not in (select userid from block where blockid='$uid') 
		UNION
		select * from media where permission='grouponly' and type like 'audio%' 
			and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
			and userid not in (select userid from block where blockid='$uid') 
		order by views desc limit 12";
}
else	
	$q="select * from media where permission='public' and type like 'audio%' order by views desc limit 12";	
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
				
				
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>			
					<li>
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">			
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
										
							</a>
						</div>
						<div class="intro">
						<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
						</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p> 
						</div>
					</li>
				<?php
				}
				?>				
                </ul>
            </div>
        
		
			<div class="movie">
                <p class="recommend clearfloat"><a href="imagelist.php">Image</a></p>
                <ul class="clearfloat">
<?php	//public image
if ($userlogin) {
	$q="select * from media where permission='public' and type like 'image%'  
		and userid not in (select userid from block where blockid='$uid') 
		UNION
		select * from media where permission='grouponly' and type like 'image%' 
			and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
			and userid not in (select userid from block where blockid='$uid') 
		order by views desc limit 12";
}
else	
	$q="select * from media where permission='public' and type like 'image%' order by views desc limit 12";	
		
		$r=mysql_query($q) or die ("Could not query the database view: <br />". mysql_error());		
		
		?>		
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
					$uploaderid = $result_row['userid'];
					$quploader = "select username from account where userid = '$uploaderid'";
					$ruploader = mysql_query($quploader) or die ("Could not query the database account: <br />". mysql_error());
					$uploader = mysql_fetch_row($ruploader)[0];
				?>			
                    <li>
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
							</a>
						</div>
						<div class="intro">
							<p><a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?>
							</p><p><font size="2" color="grey">Upload:&nbsp;<?php echo $uploader;?></font></a> </p>
						</div>
					</li>
					
				
				<?php
				}
				?>
                </ul>
        </div>
	</div>
    
</div>
<br><br>

</body>
</html>