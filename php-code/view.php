<?php
include "db.php";
$q=mysql_query("select * from `course_details`");
echo "<table border='1'>";
while ($row=mysql_fetch_array($q)) {
	echo "<tr>";
	echo "<td>".$row[0]."</td>";
	echo "<td>".$row[1]."</td>";
	echo "<td>".$row[2]."</td>";
	echo "<td>".$row[3]."</td>";
	echo "<td><a href='update.php?id=$row[0]'>Edit</a> <a href='delete.php?id=$row[0]'>Delete</a></td>";
	echo "</tr>";
}
echo "</table>";
?>
<a href="insert.php">Insert</a>
<a href="view.php">View</a>