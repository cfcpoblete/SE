<?php
	//http://anti-spam-verification-image.googlecode.com/svn/trunk/verification_image.class.php
	session_start();	
	include("verification_image.class.php");
	$captchaimage = new verification_image(112,33,"arial.ttf");
	$captchaimage->_output();

	
?>
