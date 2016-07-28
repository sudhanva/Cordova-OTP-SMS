<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="sample.php" method="post">
<input type="text" id="sudhanva" name="sudhanva">
<input type="Submit" id="Submit" name="Submit">
</form> 
</body>
</html>

<?php
if(isset($_POST['Submit']))
{
	$fname=$_POST['sudhanva']; 
	echo $fname;
}
?>