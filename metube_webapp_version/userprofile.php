<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/PersonalPage.css">
    <link rel="stylesheet" type="text/css" href="css/DropDownStyle.css">
    <link rel="stylesheet" type="text/css" href="css/Register.css">

	
</head>
<body>
    <div id = "db_global_nav" class = "db_global_nav" >
        <div class = "bd">
            <div class = "top_nav_left">
                <a href = "index.php" class = "nav_clemson">MeTube</a>
            </div>

            <div class = "top_nav_right">
                <a href = "logout.php" class = "nav_login" id = "Logout">Log Out</a>
            </div>
        </div>
    </div>

    <div id = "nav-sns" class = "nav-sns">
        <div class = "logo">
                <a href ="index.php">
                    <img src="img/logo.png" alt = "">
                </a>
                <p style="display: inline-block; font-size: 68px; font-weight: bold; vertical-align: top;">MeTube</p>
            </div>
    </div>

    <div id = "wrapper" class = "wrapper">
        <div id = "content" class = "content">
            <div id = "left-content" class = "left-content">
                <div id = "user-infor-box" class = "user-infor-box">
					<div class = "item">
                        <label>User ID</label>
                        <span class = "permanent" id = "userid"></span>
                    </div>
                    <div class = "item">
                        <label>User Name</label>
                        <span class = "permanent" id = "username"></span>
                    </div>
                    <div class = "item">
                        <label>Email</label>
                        <span class = "permanent" id = "useremail"></span>
                    </div>
        
                    <div class = "item">
                        <label>Phone</label>
                        <span class = "permanent" id = "userphone"></span>
                    </div>
					
					<div class = "item">
                        <a href='updateprofile.php' target='_blank'>Edit User Profile</a></span>
                    </div>
					<div class = "item">
                        <a href='changepassword.php' target='_blank'>Change Password</a></span>
                    </div>
                </div>
            </div>

            <div class = "history-record">
                <h1>
                    <p>Navigator</p>
                </h1>
                
                <div class="choices">
                    <a href="">Contact</a>
                    <br>
                    <a href="">Blocking List</a>
                    <br>
                    <a href="">Upload</a>
                    <br>
                    <a href="">Liked</a>
                    <br>
                    <a href="">Discussion Group</a>
                    <br>
                    <a href="">Message</a>
                </div>
            </div>
        </div>
        <div class = "footer">
            <div class = "footer_nav">
			<span class = "fright">
				<a href = "StaticPage/AboutUs.html">About Us</a>
				<a href = "StaticPage/Developer.html">Developer</a>
				<a href = "StaticPage/MeTubeRule.html">MeTube Rule</a>
				<a href = "StaticPage/Help.html">Help</a>
			</span>
            </div>
        </div>
    </div>
</body>
</html>