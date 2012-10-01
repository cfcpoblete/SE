<?php
	session_start();
	require_once("dbconnect.php");
	require_once("webTemplateClass.php");
	session_destroy();
	header("location: ../index.php");
?>
