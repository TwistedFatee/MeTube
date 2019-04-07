<?php

	ini_set('session.save_path','/home/cai7/temp');
	session_start();	
	include_once "function.php";

	if(isset($_GET['category'])){
		$category=$_GET['category'];

	}
	
	if(isset($_SESSION['userid']) && isset($_SESSION['randomstring'])){
		$username = $_SESSION['username'];
		$userid=$_SESSION['id'];
		$randomstring = $_SESSION['randomstring'];
		$result = user_randomstring_check($userid, $randomstring);
		if($result == 0){
			
		}
			
		
		
		
		
		
			echo "Welcome ".$username."<span> | </span><a href=\"profile.php\">Account</a><span> | </span><a href=\"logout.php\">Log Out</a><span> | </span>";
		else
			echo "<a href=\"login.php\">Sign In</a><span> | </span><a href=\"register.php\">Sign Up</a><span> | </span>";
		
	}
	else
		echo "<a href=\"login.php\">Sign In</a><span> | </span><a href=\"register.php\">Sign Up</a><span> | </span>";
	


?>