<?php
	session_start();
	require_once("dbconnect.php");
	require_once("webTemplateClass.php");
	//require_once("ldapcon.php");
	
	$login=new web_template();
	$login->checkLogin();
?>
