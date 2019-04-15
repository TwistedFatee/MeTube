<!DOCTYPE html>
<html>
<body>
<?php
	$filename="uploads/abcd4/bigbang_blue_mv.mp4";
	$type="video/mp4";


		echo "Viewing Video:";
		echo "blue";
		echo "<br>";
		echo "<video controls autoplay width=\"960\" height=\"580\"><source src='".$filename."' type='".$type."'>";
		echo "</video>";
?>



</body>
</html>
	
