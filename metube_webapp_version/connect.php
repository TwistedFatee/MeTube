<?php

function buildLink(){
	$link = mysqli_connect("mysql1.cs.clemson.edu","jayqiu16","myyoutube123","myYouTube") or die("Cannot connect:".mysqli_error($link));
	return $link;
}

$link=buildLink();

?>