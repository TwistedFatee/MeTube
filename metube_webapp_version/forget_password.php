<html>
<head>
    <meta charset="UTF-8">
    <meta name="Viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MeTube System Login</title>
    <link rel="icon" href="../../img/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="../Register/Register.css">
    <link rel="stylesheet" type="text/css" href="../Login/Login.css">
    <link rel="stylesheet" type="text/css" href="ForgetPassword.css">
    <script type="text/javascript" src="../jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../jquery-3.2.1.js"></script>
</head>

<body>
<div class = "header">
    <div class = "nav_logo">
        <div class = "logo">
            <a href ="http://www.clemson.edu/">
                <img src="../../img/logo.png" alt = "">
            </a>
            <p style="display: inline-block; font-size: 68px; font-weight: bold; vertical-align: top;">MeTube</p>
        </div>
    </div>
</div>

<div class = "wrapper">
    <h1>
        Forgot Password?<br>
		Use your email or security question to retrieve your password. 
    </h1>

    <div class = "main">
        <form name = "loginForm" method = "post" >
            <div class = "item">
                <label>Username</label>
                <input id = "username" name  = "username" type = "text" class = "basic_input" tabindex = "1" maxlength = "20" required>
                <div id = "name_error" class = "val_error"></div>
            </div>
			<div class = "item">
                <label>Email</label>
                <input id = "email" name  = "email" type = "text" class = "basic_input" tabindex = "1" maxlength = "60" placeholder = "Name@g.clemson.edu" value>
                <div id = "email_error" class = "val_error"></div>
            </div>
            <div class = "item">
                <label>Password</label>
                <input id = "password" name = "password" type = "password" class = "basic_input" tabindex = "2" maxlength = "20" placeholder = "Password">
                <div id = "password_error" class = "val_error"></div>
            </div>
            <div class = "item">
                <label>Confirm</label>
                <input id = "confirm-password" name = "confirm-password" type = "password" class = "basic_input" tabindex = "3" maxlength = "20" placeholder = "Confirm Password">
                <div id = "confirm_password_error" class = "val_error"></div>
            </div>
            <div class = "item">
                <label>Verify Code</label>
                <input id = "Verify-Code" name = "VerifyCode" type = "text" class = "basic_input" tabindex = "4" maxlength = "20" placeholder = "Verifcation Code">
                <div id = "verify-code-error" class = "val_error"></div>
            </div>
            <div class = "item_submit">
                <label>&nbsp;</label>
                <input type = "submit" name = "Verify_submit" id = "send-verify" value = "SendCode" class = "Login_submit" onclick="verifyCode.emailVerify()">
                <input type = "submit" name = "Login_submit" id = "Login_submit" value = "Submit" class = "Login_submit" onclick="changePassword.myChangePassword()">

            </div>
        </form>
    </div>

    <div id = "right-content" class = "right-content">
        <h3>How Do I Create a Strong and Unique Password?</h3>
        <ol>
            <li>Use a phrase and incorporate shortcut codes or acronyms.</li>
            <li>Use passwords with common elements, but customized to specific sites.</li>
            <li>Play with your keyboard.</li>
            <li>Change your password frequently.</li>
        </ol>
    </div>
</div>

<div class = "footer_login">
    <div class = "footer_nav">
			<span class = "fright">
				<a href = "../StaticPage/AboutUs.html">About MeTube</a>
				<a href = "../StaticPage/Developer.html">Developers</a>
				<a href = "../StaticPage/MeTubeRule.html">MeTube Rule</a>
				<a href = "../StaticPage/Help.html">Help</a>
			</span>
    </div>
</div>

<script type="text/javascript" src="VerifyCode.js"></script>
<script type="text/javascript" src="ChangePassword.js"></script>
</body>
</html>
