<?php

	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");	
	
	if(trim($_POST["email"])==null || trim($_POST["email"]) == "")
	{
		$m=md5('blank');
		header("location:forgot.php?m=$m");
		exit;
	}
	else
	{
		$change=new web_template;
		$change->changePass($_POST["email"]);
		$_SESSION['sending']=1;
		$_SESSION['forgotemail']=$_POST["email"];				
		header("location:forgot.php");
		exit;
	}	

?>