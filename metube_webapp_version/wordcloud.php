<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Word Cloud</title>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
td {
	color: red;
}
</style>
</head>

<body>

<h1 align='center'> Search Keyword Cloud </h1>
<?php

include_once "function.php";

$q="select * from searchwordcloud order by repeats desc";
$r = mysql_query($q) or die("Cannot query searchwordcloud.  ".mysql_error());




?>
<table style="width:50%" align='center'>
  <tr>
    <th>Key Word</th>
    <th>Repeats</th> 
    <th>Last Search</th>
  </tr>
  
<?php
while($result_row = mysql_fetch_assoc($r)){
?>
  <tr>
    <td><?php echo $result_row['searchkey'];?></td>
    <td><?php echo $result_row['repeats'];?></td>
    <td><?php echo $result_row['lastaccess'];?></td>
  </tr>
<?php
}
?>

</table>
<br>
<h1 align='center'> Media Tag Cloud </h1>
<?php

include_once "function.php";

$q="select * from tagwordcloud order by repeats desc";
$r = mysql_query($q) or die("Cannot query searchwordcloud.  ".mysql_error());




?>
<table style="width:50%" align='center'>
  <tr>
    <th>Tag</th>
    <th>Repeats</th> 
    <th>Last Add</th>
  </tr>
  
<?php
while($result_row = mysql_fetch_assoc($r)){
?>
  <tr>
    <td><?php echo $result_row['tag'];?></td>
    <td><?php echo $result_row['repeats'];?></td>
    <td><?php echo $result_row['lastaccess'];?></td>
  </tr>
<?php
}
?>

</table>

<br><br>


</body>
</html>