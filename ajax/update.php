<?php
include "db.php";
if(isset($_POST['update']))
{
	$course_id=$_POST['course_id'];
	$title=$_POST['title'];
	$duration=$_POST['duration'];
	$price=$_POST['price'];
	$q=mysql_query("UPDATE `course_details` SET `title`='$title',`duration`='$duration',`price`='$price' where `course_id`='$course_id'");
	if($q)
		echo "ok";
	else
		echo "error";
}
?>