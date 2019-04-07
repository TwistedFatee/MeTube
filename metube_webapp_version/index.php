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
            <div class="topbar-developer">
                <a href="">MeTube by Ying Cai & Yining Qiu</a> 
            </div>
            <div class="topbar-message"><a href=""> <i class="iconfont">&#xe625;</i><span> (0) </span></a></div>
			
            <div class="topbar-info clearfloat">
<?php
	ini_set('session.save_path','/home/cai7/temp');
	session_start();	
	include_once "function.php";
	
	if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$userid = $_SESSION['userid'];			
		$randomstring= $_SESSION['randomstring'];
		$username=$_SESSION['username'];
		$result = user_randomstring_check($userid, $randomstring);
		if($result == 0)
			echo "Welcome ".$username."<span> | </span><a href=\"profile.php\">Account</a><span> | </span><a href=\"logout.php\">Log Out</a><span> | </span>";
		else
			echo "<a href=\"login.php\">Sign In</a><span> | </span><a href=\"register.php\">Sign Up</a><span> | </span>";
				
	}
	else
		echo "<a href=\"login.php\">Sign In</a><span> | </span><a href=\"register.php\">Sign Up</a><span> | </span>";
	
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
                            <a href="category.php?category='sports'">Sports</a>
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
                            <a href="category.php?category=documentary">Documentary</a>
                        </li>
                    </ul>
                </div>
				
                <div class="header-search">
                    <form action="search.php?key=$keyword" class="search-form">
                        <input type="search" name="keyword" class="search-text">
                        <input type="submit" name="search_submit" value="&#xe71f;" class="search-button iconfont" >
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
<?php	
if(isset($_SESSION['userid'])){
	$uid=$_SESSION['userid'];
			
	//recently views by userid 
		
		$q="select * from view inner join media on view.mediaid=media.mediaid where view.userid='$uid' order by viewtime desc limit 8";			
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
?>
		
			<div class="recently view">
                <p class="recommend clearfloat">Recently Views</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
                </ul>
            </div>
		
		<?php	//recently uploaded media 
		$q="select * from media where permission='public' order by uploadtime desc limit 8";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
			<div class="recently upload">
                <p class="recommend clearfloat">Recently Public Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
                </ul>
            </div>
			
		<?php	//recently uploaded group-only media 	
		$q="select * from media where userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 8";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database groupmember: <br />". mysql_error());
		}
		
		
		?>
			<div class="recently upload">
                <p class="recommend clearfloat">Recently Group-member Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
                </ul>
            </div>
			
		
            <div class="movies">
                <p class="recommend clearfloat">Recommend</p>
                <ul class="clearfloat">
                    <li>
                        <div class="bg"><img src="img/division2.jpg" alt=""></div>
                        <div class="intro">
                            <a href="" class="name">THE DIVISION 2 Walkthrough Gameplay Part 1 - INTRO - Campaign Mission 1 (PS4 Pro)</a>
                        </div>
                    </li>

                    <li>
                        <div class="bg"><img src="img/GOT.jpg" alt=""></div>
                        <div class="intro">
                            <a href="" class="name">Game Of Thrones Season 8 Jon Snow Roberts Rebellion Secret History Breakdown</a>
                        </div>
                    </li>

                    <li>
                        <div class="bg"><img src="img/nba.jpg" alt=""></div>
                        <div class="intro">
                            <a href="" class="name">2019 NBA Slam Dunk Contest - Full Highlights | 2019 NBA All-Star Weekend</a>
                        </div>
                    </li>

                    <li>
                        <div class="bg"><img src="img/talkshow.jpg" alt=""></div>
                        <div class="intro">
                            <a href="" class="name">Why 'Michael Cohen Is A Liar' Is A Lazy Argument</a>
                        </div>
                    </li>
                </ul>
            </div>
          
        </div>

        <div class="container">
			<div class="vedio">
                <p class="recommend clearfloat">Vedio</p>
                <ul class="clearfloat">
				<p>Public</p>
		<?php	//recently uploaded media 
		$q="select * from media where permission='public' and type like 'video%' order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
				
				
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				<p>Group</p>
		<?php	//recently uploaded vedio group-only 	
		$q="select * from media where type like 'video%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database groupmember: <br />". mysql_error());
		}
		
		
		?>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				
                </ul>
            </div>
           
            <div class="vedio">
                <p class="recommend clearfloat">Audio</p>
                <ul class="clearfloat">
				<p>Public</p>
		<?php	//recently uploaded media 
		$q="select * from media where permission='public' and type like 'audio%' order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
				
				
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				<p>Group</p>
		<?php	//recently uploaded vedio group-only 	
		$q="select * from media where type like 'audio%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database groupmember: <br />". mysql_error());
		}
		
		
		?>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				
                </ul>
            </div>
        </div>
		
		<div class="image">
                <p class="recommend clearfloat">Image</p>
                <ul class="clearfloat">
				<p>Public</p>
		<?php	//recently uploaded media 
		$q="select * from media where permission='public' and type like 'image%' order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
				
				
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				<p>Group</p>
		<?php	//recently uploaded vedio group-only 	
		$q="select * from media where type like 'image%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database groupmember: <br />". mysql_error());
		}
		
		
		?>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
				
                </ul>
            </div>

    </div>
   </div>
   
<?php
} 
   else{
			$ip = $_SERVER['REMOTE_ADDR'];
			$q="select * from view inner join media on view.mediaid=media.mediaid where view.ip='$ip' and view.userid=0 order by view.viewtime desc limit 8";
			$r=mysql_query($q);
			if(!$r){
				die ("Could not query the database view: <br />". mysql_error());
			}
		
		
?>
		
			<div class="recently view">
                <p class="recommend clearfloat">Recently Views</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
                </ul>
            </div>
		
		<?php	//recently uploaded media 
		$q="select * from media where permission='public' order by uploadtime desc limit 8";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
			<div class="recently upload">
                <p class="recommend clearfloat">Recently Public Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <tr>			
					
					<td>
					<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
					</td>
					
					<br>
					</tr>
				<?php
				}
				?>
                </ul>
            </div>
<?php
		}
?>
</body>
</html>