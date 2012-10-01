<?php
	if($_SESSION["loginstatus"]!="true")
	{
		$m=md5("no login");
		header("location: invalidpage.php?m=$m");
		exit;
	}
?>