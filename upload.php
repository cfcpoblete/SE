<?php
	session_start();
	require_once("../scripts/dbconnect.php");
	require_once("../scripts/webTemplateClass.php");
	$stat=$_GET["stat"];
	$id=$_GET["iid"];
	
	$up=new web_template();
	$up->upload();
	
	header("Location: template.php?pid=1");
?>