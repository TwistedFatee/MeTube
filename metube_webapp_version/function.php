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
		$row = mysql_fetch_row($result);
		if(strcmp($row[2],$password))
			return 2; //wrong password
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
