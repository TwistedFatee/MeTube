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
            
			
            <div class="topbar-info clearfloat">
<?php
	ini_set('session.save_path','/home/cai7/temp');
	session_start();	
	include_once "function.php";
	
	$userlogin = FALSE;
	if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$userid = $_SESSION['userid'];			
		$randomstring= $_SESSION['randomstring'];
		$username=$_SESSION['username'];
		$result = user_randomstring_check($userid, $randomstring);
		if($result == 0){
			$userlogin = TRUE;
			echo "Welcome ".$username."<span> | </span><a href=\"userprofile.php?uid=".$userid."\">Account</a><span> | </span>
			<a href=\"logout.php\">Log Out</a><span> | </span><div class=\"topbar-message\"><a href=\"message.php\"> <i class=\"iconfont\">&#xe625;</i><span> (0) </span></a></div>";
		}
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
                    <form action="search.php" class="search-form">
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
if($userlogin){
	$uid=$_SESSION['userid'];			
	//recently views by userid 		
	$q="select * from view inner join media on view.mediaid=media.mediaid where view.userid='$uid' group by view.mediaid order by viewtime desc limit 8";	
}else{
	$ip = $_SERVER['REMOTE_ADDR'];
	$q="select * from view inner join media on view.mediaid=media.mediaid where view.ip='$ip' and view.userid=0 order by view.viewtime desc limit 8";
			
}	
		$r=mysql_query($q) or die ("Could not query the database view: <br />". mysql_error());
		
?>
		
			<div class="movie">
                <p class="recommend clearfloat">Recently Views</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>
					<li class="view">					
						<div class="intro">
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
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
				?>
                </ul>
            </div>
		
		<?php


		//recently uploaded media 
		$q="select * from media where permission='public' order by uploadtime desc limit 8";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
			<div class="movie">
                <p class="recommend clearfloat">Recently Public Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
					<li>				
						<div class="intro">
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
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
				?>
                </ul>
            </div>
			
		<?php	
		if($userlogin){//recently uploaded group-only media 	
		$q="select * from media where userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 8";
		
		
		$r=mysql_query($q) or die ("Could not query the database groupmember: <br />". mysql_error());		
		
		?>
			<div class="movie">
                <p class="recommend clearfloat">Recently Group-member Uploads</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>					
						<div class="intro">
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
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
		}
				?>
                </ul>
            
			
			<?php	//most views
		$q="select * from media where permission='public' order by views desc limit 8";
		
		
		$r=mysql_query($q);
		if(!$r){
			 die ("Could not query the database view: <br />". mysql_error());
		}
		
		
		?>
		
		
			<div class="movie">
                <p class="recommend clearfloat">Most Views</p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>
						
						<div class="intro">
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
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					
					</li>
				<?php
				}
				?>
                </ul>
            </div>
		
		 
            <div class="movie">
                <p class="recommend clearfloat">Recommend</p>
                <ul class="clearfloat">
                    <li>
						<div class="bg">
							<a href="vedio.php?mid=5" target="_blank" class= "name"><img width="200" src="uploads/thumbs/5.jpg" alt="<?php echo "sample 3";?>" >
							</a>
						</div>
                        <div class="intro">
							<a href="vedio.php?mid=5" target="_blank" class= "name"><?php echo "sample 3";?></a> 
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
          
        

        
			<div class="movie">
                <p class="recommend clearfloat">Vedio</p>
                <ul class="clearfloat">
				<?php 
				if($userlogin){
					?>
					<p>Public</p>
				<?php 
				}
				?>
		<?php	//vedios
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
                    <li>			
					
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
										
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
								
							</a>
						</div>
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
					
				<?php
				}
				?>
				
				
		<?php	
		if ($userlogin){
		//recently uploaded vedio group-only 	
		$q="select * from media where type like 'video%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q) or die ("Could not query the database groupmember: <br />". mysql_error());		
		
		?>	
				<p>Group</p>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">										
							<img width="200" src="uploads/thumbs/<?php echo $result_row['mediaid'];?>.jpg" alt="<?php echo $result_row['medianame'];?>" >											
							</a>
						</div>
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					
					</li>
				<?php
				}
		}
				?>
				
                </ul>
            </div>
           
            <div class="movie">
                <p class="recommend clearfloat">Audio</p>
                <ul class="clearfloat">
				<?php 
				if($userlogin){
					?>
					<p>Public</p>
				<?php 
				}
				?>
		<?php	//audios
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
					<li>
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">			
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
										
							</a>
						</div>
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
				?>
				
		<?php	
		if ($userlogin){
		//group audios	
		$q="select * from media where type like 'audio%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q) or die ("Could not query the database groupmember: <br />". mysql_error());		
		
		?>
				<p>Group</p>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">										
							<img src="img/logo.png" alt="<?php echo $result_row['medianame'];?>" width="200">					
										
							</a>
						</div>
						<div class="bg">
						<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
		
					</li>
	
				<?php
				}
		}
				?>
				
                </ul>
            </div>
        
		
			<div class="movie">
                <p class="recommend clearfloat">Image</p>
                <ul class="clearfloat">
				<?php 
				if($userlogin){
					?>
					<p>Public</p>
				<?php 
				}
				?>
		<?php	//public image
		$q="select * from media where permission='public' and type like 'image%' order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q) or die ("Could not query the database view: <br />". mysql_error());		
		
		?>		
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
							</a>
						</div>
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
					
				
				<?php
				}
				?>
				
		<?php	
		if ($userlogin){
		//group images
		$q="select * from media where type like 'image%' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
		 order by uploadtime desc limit 4";
		
		
		$r=mysql_query($q) or die ("Could not query the database groupmember: <br />". mysql_error());		
		
		?>
				<p>Group</p>
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
				?>			
                    <li>
						<div class="intro">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank">
							<img src="<?php echo $result_row['filepath'].$result_row['filename'];?>" alt="<?php echo $result_row['medianame'];?>" width="200">
							</a>
						</div>
						<div class="bg">
							<a href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
		}
				?>
				
                </ul>
        </div>
	</div>
    
</div>
   

</body>
</html>