<html>
<body>
<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);

	if(! $conn ) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('lucas');
	
	/*
	$sql = 'SELECT * FROM games';
	$retval = mysql_query($sql, $conn);

	if(! $retval ) {
		die('Could not get data: ' . mysql_error());
	}

	while($row = mysql_fetch_assoc($retval) ) {
		echo "{$row['Field']} - {$row['Type']}\n";
	} */

	//Login/register
	//Form entry here
	//takes username and password
	//both fields are required
	//

	mysql_close($conn);
?>
</body>
</html>
