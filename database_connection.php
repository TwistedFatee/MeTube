<?php
header('Content-type:text/html;charset=uft-8');
//establishing connection with MySql database;
$link = @mysqli_connect('mysql1.cs.clemson.edu','jayqiu16','myyoutube123');
//pop up connection error 
if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}

//set default character encoding
mysqli_set_charset($link, 'utf8');

//select table
mysqli_select_db($link, 'myYouTube');
//var_dump(mysqli_select_db($link, 'myYouTube'));

// $query = "insert into media(name) values('Mike')";
// var_dump(mysqli_query($link, $query));


//close database connection
//mysqli_close($link);