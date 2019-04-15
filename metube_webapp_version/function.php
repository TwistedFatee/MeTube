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
		if(mysql_num_rows($result) == 0 || strcmp($row['password'],$password))
			return 2; //wrong password or user does not exist
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
		if(mysql_num_rows($result) == 0 || strcmp($row['randomstring'],$randomstring))
			return 1; //wrong randomstring or user does not exist
		else 
			return 0; //Checked.
	}	
}

function requirelogin($userid, $randomstring, $start){
	$checkuser=user_randomstring_check($userid, $randomstring);
	if($checkuser==0){
		$current=time();
	
		if ($current - $start <= 30*60){		//less than 30 mins
			return 0;
		}
		else 
			return 1;
	}
	else
		return 1;
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
		$query = "select * from view where ip='$ip' and mediaid='$mediaid' and userid=0";
					 // Run the query created above on the database through the connection
		$result = mysql_query( $query );
		if (!$result)
		{	
			die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
		}
		
		$numrows=mysql_num_rows($result);
		
		if($numrows==0){
			$query = "insert into view(ip, mediaid) values('$ip','$mediaid')";
					 // Run the query created above on the database through the connection
			$result = mysql_query( $query );
			if (!$result)
			{
				die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
			}
			$viewid=mysql_insert_id();
		}
		else{
			$r=mysql_fetch_assoc($result);
			$viewid=$r['viewid'];
		}
		
	}else{
		$query = "select * from view where mediaid='$mediaid' and userid='$userid'";
					 // Run the query created above on the database through the connection
		$result = mysql_query( $query );
		if (!$result)
		{	
			die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
		}
		
		$numrows=mysql_num_rows($result);
		
		if($numrows==0){
			$query = "insert into view(ip, mediaid,userid) values('$ip','$mediaid','$userid')";
					 // Run the query created above on the database through the connection
			$result = mysql_query( $query );
			if (!$result)
			{
				die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
			}
			$viewid=mysql_insert_id();
		}
		else{		
			$r=mysql_fetch_assoc($result);
			if ($r['ip'] == $ip){
				$viewid=$r['viewid'];
			}else{
				$query = "insert into view(ip, mediaid,userid) values('$ip','$mediaid','$userid')";
					 // Run the query created above on the database through the connection
				$result = mysql_query( $query );
				if (!$result)
				{
					die ("updateViews() failed. Could not query the database view: <br />". mysql_error());
				}
				$viewid=mysql_insert_id();
			}
			
		}
	}
	
	$query = "	update view set viewtime=NOW() where viewid='$viewid'";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Cannot update viewtime. Could not query the database view: <br />". mysql_error());
	}
}

function tagwordcloud($tag){
	if(strlen($tag) <= 0)
		return 2;
	$q="select * from tagwordcloud where tag='".$tag."'";
	$result=mysql_query($q) or die ("tagwordcloud() failed. Could not query the database tagwordcloud: <br />". mysql_error());
	$numofresult=mysql_num_rows($result);
	if ($numofresult == 0){
		$q = "insert into tagwordcloud(tag) values('$tag')";
		$result=mysql_query($q) or die ("tagwordcloud() failed. Could not query the database tagwordcloud: <br />". mysql_error());
		return 0;
	}else{
		$result_row=mysql_fetch_row($result);
		$q = "update tagwordcloud set repeats=repeats+1, lastaccess=NOW() where tagid='".$result_row[0]."'";
		$result=mysql_query($q) or die ("tagwordcloud() failed. Could not query the database tagwordcloud: <br />". mysql_error());
		return 0;
	}
	
	return 1;
}

function searchwordcloud($tag){
	if(strlen($tag) <= 0)
		return 2;
	$q="select * from searchwordcloud where searchkey='".$tag."'";
	$result=mysql_query($q) or die ("searchwordcloud() failed. Could not query the database searchwordcloud: <br />". mysql_error());
	$numofresult=mysql_num_rows($result);
	if ($numofresult == 0){
		$q = "insert into searchwordcloud(searchkey) values('$tag')";
		$result=mysql_query($q) or die ("tagwordcloud() failed. Could not query the database searchwordcloud: <br />". mysql_error());
		return 0;
	}else{
		$result_row=mysql_fetch_row($result);
		$q = "update searchwordcloud set repeats=repeats+1, lastaccess=NOW() where searchid='".$result_row[0]."'";
		$result=mysql_query($q) or die ("searchwordcloud() failed. Could not query the database searchwordcloud: <br />". mysql_error());
		return 0;
	}
	
	return 1;
}

function deleteMedia($mediaid){
	$q = "select * from media where mediaid='".$mediaid."'";
	$r = mysql_query($q) or die("deleteMedia() failed. Could not query the database media: <br />". mysql_error());
	$result = mysql_fetch_assoc($r);
	$cmd = $result['filepath'].$result['filename'];
	$remove=unlink($cmd);
	if (!$remove)
		return "fail to unlink";
	
	
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
	$q="select * from playlist where userid='$userid' and playlistname='$listname'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
	}
	$numrows=mysql_num_rows($result);
	if ($numrows == 0){
		$q="insert into playlist(userid, playlistname, createtime) values('$userid','$listname', NOW())";
		$result=mysql_query($q);
		if (!$result)
		{
			die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
		}
		return mysql_insert_id();
	}else{
		return 0; //already exist
	}
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

function addToPlaylist($playlistid, $mediaid){
	$q="select * from plistmedia where playlistid='$playlistid' and mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
	}
	$numrows=mysql_num_rows($result);
	if ($numrows == 0){
		$q="insert into plistmedia(playlistid,mediaid, addtime) values('$playlistid','$mediaid', NOW())";
		$result=mysql_query($q);
		if (!$result)
		{
			die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
		}
		return 0;
	}else{
		return 1; //already exist
	}
}

function removeFromPlaylist($playlistid, $mediaid){
	$q="delete from plistmedia where playlistid='$playlistid' and mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database playlist: <br />". mysql_error());
	}
	return 0;
}

function addFavorite($userid, $mediaid){
	$q="select * from flistmedia where userid='$userid' and mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database flistmedia: <br />". mysql_error());
	}
	$numrows=mysql_num_rows($result);
	if ($numrows == 0){
		$q="insert into flistmedia(userid, mediaid,addtime) values('$userid','$mediaid',NOW())";
		$result=mysql_query($q);
		if (!$result)
		{
			die ("deleteMedia() failed. Could not query the database flistmedia: <br />". mysql_error());
		}
		return 0;
	}else{
		return 1; //already in favorite list
	}
	
}

function removeFavorite($userid, $mediaid){
	$q="delete from flistmedia where userid='$userid' and mediaid='$mediaid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deleteMedia() failed. Could not query the database flistmedia: <br />". mysql_error());
	}
	
	return 0;
}

function createchannel($uid, $cname, $description){
	$q="insert into channel(userid, channelname, description, createtime) values('$uid','$cname','$description', NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("createchannel() failed. Could not query the database channel: <br />". mysql_error());
	}
	
	return 0;
}

function addmediatochannel($mediaid, $uid){
	$q = "select * from channel where userid='".$uid."'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addmediatochannel() failed. Could not query the database channel: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) == 0 )
		return 1;
	
	$r = mysql_fetch_assoc($result);
	$channelid = $r['channelid'];
	
	$q="select * from channelmedia where channelid='".$channelid."' and mediaid='".$mediaid."' ";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addmediatochannel() failed. Could not query the database channelmedia: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) > 0)
		return 2;
	
	$q = "insert into channelmedia(mediaid, channelid, addtime) values('$mediaid','$channelid',NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addmediatochannel() failed. Could not query the database channelmedia: <br />". mysql_error());
	}
	return 0;
}

function removefromchannel($mediaid, $uid){
	$q = "select * from channel where userid='".$uid."'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("removefromchannel() failed. Could not query the database channel: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) == 0 )
		return 1;
	
	$r = mysql_fetch_assoc($result);
	$channelid = $r['channelid'];	
	
	$q = "delete from channelmedia where channelid='".$channelid."' and mediaid='".$mediaid."' ";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("removefromchannel() failed. Could not query the database channelmedia: <br />". mysql_error());
	}
	return 0;
}

function deletechannel($uid){
	$q = "select * from channel where userid='".$uid."'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deletechannel() failed. Could not query the database channel: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) == 0 )
		return 1;
	
	$r = mysql_fetch_assoc($result);
	$channelid = $r['channelid'];
	
	$q = "delete from channelmedia where channelid='".$channelid."' ";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deletechannel() failed. Could not query the database channelmedia: <br />". mysql_error());
	}
	
	$q = "delete from channel where channelid='".$channelid."' ";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("deletechannel() failed. Could not query the database channel: <br />". mysql_error());
	}
	
	return 0;
}

function followuser($userid, $targetid){
	$q = "select * from subscribe where userid='".$userid."' and targetid='".$targetid."'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("followuser() failed. Could not query the database subscribe: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) > 0 )
		return 1;
	
	$q = "insert into subscribe(userid, targetid, followtime) values('$userid','$targetid',NOW())";
	
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("followuser() failed. Could not query the database subscribe: <br />". mysql_error());
	}
	return 0;
}

function unfollowuser($userid, $targetid){
	$q = "select * from subscribe where userid='".$userid."' and targetid='".$targetid."'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("unfollowuser() failed. Could not query the database subscribe: <br />". mysql_error());
	}
	
	if (mysql_num_rows($result) == 0 )
		return 1;
	
	$q = "delete from subscribe where userid='".$userid."' and targetid='".$targetid."'";
	
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("unfollowuser() failed. Could not query the database subscribe: <br />". mysql_error());
	}
	return 0;
}

function addcontact($userid, $targetid){
	$q = "select * from contact where userid='$userid' and targetid='$targetid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addcontact() failed. Could not query the database contact: <br />". mysql_error());
	}
	if (mysql_num_rows($result) > 0 )
		return 1;
	
	$q = "insert into contact(userid, targetid, addtime) values('$userid','$targetid',NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addcontact() failed. Could not query the database contact: <br />". mysql_error());
	}
	return 0;
}

function removecontact($userid, $targetid){
	$q = "select * from contact where userid='$userid' and targetid='$targetid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("removecontact() failed. Could not query the database contact: <br />". mysql_error());
	}
	if (mysql_num_rows($result) == 0 )
		return 1;
	
	$q = "delete from contact where userid='$userid' and targetid='$targetid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("removecontact() failed. Could not query the database contact: <br />". mysql_error());
	}
	return 0;
}

function blockuser($userid, $blockid){
	$q="insert into block(userid,blockid,blocktime) values('$userid','$blockid',NOW())";
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

function addfriend($from, $to){
	$q = "select * from friend where user1='$from' and user2='$to' and approved = '1'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addfriend() failed. Could not query the database friend: <br />". mysql_error());
	}
	if (mysql_num_rows($result) > 0 )
		return 1;
	
	$q = "insert into friend(user1, user2, addtime) values('$from','$to',NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("addfriend() failed. Could not query the database friend: <br />". mysql_error());
	}
	
	return 0;
}

function removefriend($from, $to){
	
	$q = "delete from friend where user2='$from' and user1='$to' ";
	$result=mysql_query($q);
	if (!$result)
	{
		die ("removefriend() failed. Could not query the database friend: <br />". mysql_error());
	}
	
	
	$q = "delete from friend where user1='$from' and user2='$to' ";
	$result=mysql_query($q);
	if (!$result)
	{
		die ("removefriend() failed. Could not query the database friend: <br />". mysql_error());
	}
	
	return 0;
}

function sendmessage($from, $to, $message){
	$q = "insert into message(fromuserid, touserid, message) values('$from','$to','$message')";
	$result=mysql_query($q);
	if (!$result)
	{
		die ("removefriend() failed. Could not query the database friend: <br />". mysql_error());
	}
}

function creategroup($userid, $groupname){
	$q="insert into discussiongroup(createuserid,groupname) values('$userid','$groupname')";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database discussiongroup: <br />". mysql_error());
	}
	$groupid=mysql_insert_id();
	
	$q="update discussiongroup set createtime=NOW() where groupid='$groupid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not update create time: <br />". mysql_error());
	}
	
	$q="insert into groupmember(groupid,userid,lastaccess) values('$groupid', '$userid', NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database groupmember: <br />". mysql_error());
	}
	return 0;
	
}

function joinGroup($userid, $groupid){
	$q="select * from groupmember where groupid='$groupid' and userid='$userid'";
	$r=mysql_query($q) or die("Cannot query groupmember.  ".mysql_error());
	if(mysql_num_rows($r) > 0)
		return 1;
	
	$q="insert into groupmember(groupid,userid,lastaccess) values('$groupid', '$userid', NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("creategroup() failed. Could not query the database groupmember: <br />". mysql_error());
	}
	return 0;
}

function leaveGroup($userid, $groupid){
	$q="select * from discussiongroup where groupid='$groupid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("leavegroup() failed. Could not query the database discussiongroup: <br />". mysql_error());
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
			
			$q="delete from discussiongroup where groupid='$groupid'";
			$result=mysql_query($q);
			if (!$result)
			{
				die ("leaveGroup() failed. Could not query the database discussiongroup: <br />". mysql_error());
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

function sendgroupmessage($userid, $groupid, $message){
	$q="insert into groupmessage(groupid, userid, message, sendtime) values('$groupid','$userid','$message',NOW())";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("sendgroupmessage() failed. Could not query the database groupmessage: <br />". mysql_error());
	}
	
}

function update_group_access_time($userid, $groupid){
	$q="update groupmember set lastaccess=NOW() where groupid='$groupid' and userid='$userid'";
	$result=mysql_query($q);
	if (!$result)
	{
	   die ("update_group_access_time() failed. Could not query the database groupmember: <br />". mysql_error());
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
