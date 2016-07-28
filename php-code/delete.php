<?php
include "db.php";
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	$q=mysql_query("delete from `course_details` where `course_id`='$id'");
	if($q)
		echo "ok";
	else
		echo "error";
	echo mysql_error();
}
?>