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
	
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$username = $_SESSION['username'];			
		$password = $_SESSION['password'];
		$result = user_pass_check($username, $password);
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
                            <a href="">Sports</a>
                        </li>
                        <li class="item">
                            <a href="">Movie</a>
                        </li>
                        <li class="item">
                            <a href="">TV Series</a>
                        </li>
                        <li class="item">
                            <a href="">Talk Show</a>
                        </li>
                        <li class="item">
                            <a href="">Cartoon</a>
                        </li>
                        <li class="item">
                            <a href="">Games</a>
                        </li>
                        <li class="item">
                            <a href="">Documentary</a>
                        </li>
                    </ul>
                </div>
                <div class="header-search">
                    <form action="search.php" class="search-form">
                        <input type="search" name="keyword" class="search-text">
                        <input type="submit" value="&#xe71f;" class="search-button iconfont">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
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
           
            <div class="movies">
                <p class="recommend clearfloat">Audio</p>
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

    </div>
   </div>
</body>
</html>