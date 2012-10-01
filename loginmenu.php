<?php
	if(isset($_SESSION['loginstatus'])&& $_SESSION['loginstatus']==true)
	{
		include('logged.php');
	}
	else
	{
		include('login.php');
	}
?>