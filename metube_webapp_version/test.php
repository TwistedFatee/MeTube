<?php

include_once "function.php";

$q="select * from media where type LIKE 'video%'";
$r=mysql_query($q) or die("".mysql_error());

while($result_row=mysql_fetch_assoc($r)){
	
							$video = $result_row['filepath'].$result_row['filename'];
							
							$thumbnail = "uploads/thumbs/".$result_row['mediaid'].".jpg";
							$cmd="/usr/bin/ffmpeg -deinterlace -an -ss 1 -i ".$video." -t 1 -r 1 -y -vcodec mjpeg -f mjpeg ".$thumbnail." 2>&1";
							
							$output = `$cmd`;
							echo "<pre>$output</pre>";
							chmod($thumbnail, 0644);
 
						
}



?>