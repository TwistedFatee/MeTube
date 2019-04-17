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
                        &nbsp;&nbsp;&nbsp;
						<a href="advancedsearch.php">Advanced Search</a>
						
                    </form>
					<br>
					<p>
					<a href="all_groups.php">Discussion Groups</a>&nbsp;&nbsp;
					
					</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">

			<div class="movie">
                <p class="recommend clearfloat">Video</a></p>
                <ul class="clearfloat">
<?php
//videos
if ($userlogin) {
	$q="select * from media where permission='public' and type like 'video%'  
		and userid not in (select userid from block where blockid='$uid') 
		UNION
		select * from media where permission='public' and type like 'video%' 
			and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid'))
			and userid not in (select userid from block where blockid='$uid') 
		order by views desc ";
}
else	
	$q="select * from media where permission='public' and type like 'video%' order by views desc ";		

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
           
            
	</div>
    
</div>
   

</body>
</html>