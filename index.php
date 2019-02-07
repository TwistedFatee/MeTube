<?php
header('Content-type:text/html;charset=uft-8');
//establishing connection with MySql database;
$link = @mysqli_connect('mysql1.cs.clemson.edu','jayqiu16','myyoutube123');
//pop up connection error 
if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}