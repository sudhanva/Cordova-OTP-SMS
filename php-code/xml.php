<?php
header('Content-type: application/xml');
include "db.php";
$q=mysql_query("select * from `course_details`");
echo "<Training>";
while ($row=mysql_fetch_array($q)) {
	echo "<Course>";
	echo "<course_id>".$row[0]."</course_id>";
	echo "<title>".$row[1]."</title>";
	echo "<duration>".$row[2]."</duration>";
	echo "<price>".$row[3]."</price>";
	echo "</Course>";
}
echo "</Training>";
?>