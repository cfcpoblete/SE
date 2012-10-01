<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");
	$pid=1;
	
	if(isset($_GET['m']))
	{
		$mess=$_GET['m'];
		
		switch($mess)
		{
			case md5("invalid"):
				$mess="Invalid account entered, please try again.";
				break;
			case md5("no login");
				$mess="You must login first in order to access this page.";
				break;
		}
	}
	else
	{
		$mess="Please register first or log in with your account.";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home - Community Template</title>
	<script type="text/javascript" src="script/oodomimagerollover.js"></script>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<!--for slideshow(jQuery)-->
	
	<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="plugins/loopedslider/loopedslider.js" type="text/javascript" charset="utf-8"></script>
	<script language="JavaScript" src="scripts/gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
	<link rel="stylesheet" type="text/css"  href="plugins/loopedslider/style.css">	
	<!--end slideshow(jQuery)-->
</head>
<body>

<div id="wrap">
	<!--header-->
	<div id="header">
		<div id="header_container">
			<div id="logo">
				<?php
					$logo=new web_template;
					echo $logo->displayLogo();
				?>
			</div>
			<div id="name">
				<?php
					$title=new web_template;
					echo $title->title();
				?>
			</div>
			<div id="loginContainer">
				<?php include('loginmenu.php') ?>
			</div>
		</div>
	</div>
	<!--header end-->
	<div id="divider"style="margin-bottom: 1px"></div>
	<!--menu-->
	<div id="menuHolder">
		<div id="menuContainer">
			<ul style="margin:0; padding-left:15px; text-align: left">
				<?php
					$menu=new web_template;
					echo $menu->menu();
				?>
			</ul>
		</div>
	</div>
	<!--menu end-->
	<div id="divider" style="margin-top: 1px"></div>
	<!--content-->
	<div id="contentContainer">
		<!--content-->
		<div id="content">
			<div class="invalidstatement"><?php echo $mess; ?></div>
		</div>
	</div>
	<div id="divider"></div>
	<!--footer-->
	
	<div id="footer">
	</div>
	<!--footer end-->
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$('#loopedSlider').loopedSlider({
			autoStart: 3000
		});
		$('#newsSlider').loopedSlider({
			autoHeight: 400
		});
	});
</script>
</body>
</html>