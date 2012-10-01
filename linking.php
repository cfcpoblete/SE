<?php
	session_start();
	require_once("scripts/dbconnect.php");
	include("scripts/webTemplateClass.php");
	
	$img_id=$_GET['t'];
	$templateClass=new web_template();
	$link=$templateClass->get_link($img_id);
	if($link==''||$link==null)
	{
		header("location: index.php");
		exit;
	}
	header("location: $link");
	exit;
?>