<?php
include "mysqlClass.inc.php";

function user_exist_check($username){
	$query = "select * from account where username='$username'";
	$result = mysql_query($query);
	$numofuser = mysql_num_rows($result);
	
	if ($numofuser == 0){

		return 0; // not exist
	}
	else{

		return -1; // exist
	}
	

}

function add_new_user($username, $password, $phone, $email){
	if($phone == "" && $email == ""){
		$query = "insert into account(username, password) values('$username', '$password')";
	}else if($phone == ""){
		$query = "insert into account(username, password, email) values('$username', '$password', '$email')";
	}else if($email == ""){
		$query = "insert into account(username, password, phone) values('$username', '$password', '$phone')";
	}else{
		$query = "insert into account(username, password, phone, email) values('$username', '$password', '$phone', '$email')";
	}
	
	$result = mysql_query($query);
	
	if (!$result)
	{
		die ("add_new_user() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		return 2;
	}
}

function user_pass_check($username, $password)
{
	
	$query = "select * from account where username='$username'";
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_assoc($result);
		if(strcmp($row['password'],$password))
			return 2; //wrong password
		else 
			return 0; //Checked.
	}	
}

function generateRandomString() {
	$length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function user_randomstring_check($userid, $randomstring)
{
	
	$query = "select * from account where userid='$userid'";
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("user_randomstring_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_assoc($result);
		if(strcmp($row['randomstring'],$randomstring))
			return 1; //wrong randomstring
		else 
			return 0; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}

}

function updateViews($mediaid,$ip, $userid)
{	
	$query = "	update  media set views=views+1
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateViews() failed. Could not query the database media: <br />". mysql_error());
	}
	if ($userid == 0){
		$query = "insert into view(ip, mediaid) values('$ip','$mediaid')";
					 // Run the query created above on the database through the connection
		$result = mysql_query( $query );
		if (!$result)
		{
		die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
		}
		
	}else{
		$query = "	insert into view(userid, ip, mediaid) values('$userid','$ip','$mediaid')";
					 // Run the query created above on the database through the connection
		$result = mysql_query( $query );
		if (!$result)
		{
		die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
		}
	}
	
	$viewid=mysql_insert_id();
	$query = "	update view set viewtime=NOW() where viewid='$viewid'";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Cannot update viewtime. Could not query the database view: <br />". mysql_error());
	}
}

function deleteMedia($mediaid){
	$q="delete from download where mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database download: <br />". mysql_error());
	}
	
	$q="delete from flistmedia where mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database flistmedia: <br />". mysql_error());
	}
	
	$q="delete from plistmedia where mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database plistmedia: <br />". mysql_error());
	}
	
	$q="delete from view where mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database view: <br />". mysql_error());
	}
	
	$q="delete from media where mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database media: <br />". mysql_error());
	}
	
	return 0;
}


function createPlayList($userid, $listname){
	
}

function removePlayList($playlistid){
	$q="delete from plistmedia where playlistid='$playlistid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database plistmedia: <br />". mysql_error());
	}
	
	$q="delete from playlist where playlistid='$playlistid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
	}
	return 0;
}

function removeFavoriteList($favoritelistid){
	$q="delete from flistmedia where favorilistid='$favoritelistid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database flistmedia: <br />". mysql_error());
	}
	
	$q="delete from userflist where favorilistid='$favoritelistid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database userflist: <br />". mysql_error());
	}
	return 0;
}

function blockuser($userid, $blockid){
	$q="insert into block values('$userid','$blockid')";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("blockuser() failed. Could not query the database block: <br />". mysql_error());
	}
	return 0;
}

function unblockuser($userid, $blockid){
	$q="delete from block where userid='$userid' and blockid='$blockid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("unblockuser() failed. Could not query the database block: <br />". mysql_error());
	}
	return 0;
}

function creategroup($userid, $groupname){
	$q="insert into group(createuserid,groupname) values('$userid','$groupname')";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database group: <br />". mysql_error());
	}
	$groupid=mysql_insert_id();
	
	$q="update group set createtime=NOW() where groupid='$groupid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not update create time: <br />". mysql_error());
	}
	
	$q="insert into groupmember values('$groupid', '$userid')";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database groupmember: <br />". mysql_error());
	}
	return 0;
	
}

function joinGroup($userid, $groupid){
	$q="insert into groupmember values('$groupid', '$userid')";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database groupmember: <br />". mysql_error());
	}
	return 0;
}

function leaveGroup($userid, $groupid){
	$q="select * from group where groupid='$groupid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("leavegroup() failed. Could not query the database group: <br />". mysql_error());
	}

	$r=mysql_fetch_assoc($result);
	$owner=$r['createuserid'];
	if ($userid == $owner){
		$q="select count(userid) as cnt from groupmember where groupid='$groupid'";
		$result=mysql_query($q);
		if (!$result)
		{
			die ("leavegroup() failed. Could not query the database groupmember: <br />". mysql_error());
		}
		$r=mysql_fetch_assoc($result);
		if($r['cnt'] > 1){
			return 1;
		}
		if($r['cnt'] == 1){
			$q="delete from groupmember where userid='$userid' and groupid='$groupid'";
			$result=mysql_query($q);
			if (!$result)
			{
				die ("leaveGroup() failed. Could not query the database groupmember: <br />". mysql_error());
			}
			
			$q="delete from group where groupid='$groupid'";
			$result=mysql_query($q);
			if (!$result)
			{
				die ("leaveGroup() failed. Could not query the database group: <br />". mysql_error());
			}
			return 0;
			
		}
		
	}
	else{
		$q="delete from groupmember where userid='$userid' and groupid='$groupid'";
		$result=mysql_query($q);
		if (!$result)
		{
			die ("leaveGroup() failed. Could not query the database groupmember: <br />". mysql_error());
		}
		return 0;
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

	
?>
