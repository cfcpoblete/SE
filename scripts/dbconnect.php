<?php
	$conn=mysql_connect("localhost", "root", "") or die("Cannot connect to host.".mysql_error());
	
	mysql_select_db("sedb", $conn) or die ("Cannot connect to localhost.".mysql_error());
?>