<?php
include "db.php";
if(isset($_POST['insert']))
{
	$title=$_POST['title'];
	$duration=$_POST['duration'];
	$price=$_POST['price'];
	$q=mysql_query("INSERT INTO `course_details` (`title`,`duration`,`price`) VALUES ('$title','$duration','$price')");
	if($q)
		echo "ok";
	else
		echo "error";
}
?>