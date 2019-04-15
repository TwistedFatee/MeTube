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
	
	$category=$_REQUEST['category'];
	$userlogin = FALSE;
	if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$userid = $_SESSION['userid'];			
		$randomstring= $_SESSION['randomstring'];
		$username=$_SESSION['username'];
		$result = user_randomstring_check($userid, $randomstring);
		if($result == 0){
			$userlogin = TRUE;
			echo "<font color=\"red\" size=\"4\">Welcome ".$username."</font><span> | </span><a href=\"userprofile.php?uid=".$userid."\"><font color=\"red\">Account</font></a><span> | </span>
			<a href=\"logout.php\"><font color=\"red\">Log Out</font></a><span> | </span><div class=\"topbar-message\"><a href=\"message.php\"> <i class=\"iconfont\">&#xe625;</i><span> (0) </span></a></div>";
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
                        <input type="search" name="keyword" class="search-text">
                        <input type="submit" name="search_submit" value="&#xe71f;" class="search-button iconfont" >
						<a href="advancedsearch.php">Advanced Search</a>
                    </form>
					
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
<?php	
$q="select * from media where permission='public' and category='".$category."' ";

if($userlogin){
	$uid=$_SESSION['userid'];			
			
	$q.=" UNION select * from media where category='".$category."' and userid in (select userid from groupmember where groupid in (select groupid from groupmember where userid='$uid')) ";
		
}
$r=mysql_query($q) or die ("Could not query the database view: <br />". mysql_error());
		
?>
		
			<div class="movie">
                <p class="recommend clearfloat"><?php echo $category;?></p>
                <ul class="clearfloat">
				<?php
				while ($result_row = mysql_fetch_assoc($r))
				{ 
					$mname=$result_row['medianame'];
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
						<a class="name" href="vedio.php?mid=<?php echo $result_row['mediaid'];?>" target="_blank"><?php echo $mname;?></a> 
						</div>
					</li>
				<?php
				}
				?>
                </ul>
            </div>
		
		
        </div>
	</div>
    
</div>
   

</body>
</html>