<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");



	if(isset($_GET['id']))
	{
		$accessoryid=$_GET['id'];
		$sql="select name from tblaccessories where id=\"$accessoryid\"";
		$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
		$row=mysql_fetch_array($result);
		$page=$row["name"];
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home - Community Template</title>
	<script type="text/javascript" src="script/oodomimagerollover.js"></script>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<script language="JavaScript" src="scripts/gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
	<!--for slideshow(jQuery)-->	
	<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="plugins/loopedslider/loopedslider.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css"  href="plugins/loopedslider/style.css">	
	<script type="text/javascript" src="plugins/news_ticker/jquery.innerfade.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/css.css">
	<script type="text/javascript">
	function wOpen(id)
	{
		window.open('slide.php?id='+id,'name','width=985,height=350,resizable=no');
		
	}

	</script>
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
	<center>
		<a href="editusers.php" class='tool' target="boxes">
			Edit Users
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			Customerpage
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			link3
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			link4
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			link5
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			link6
		</a>
		<a href="customerpage.php" class='tool' target="boxes">
			link7
		</a><br>
			<iframe src="editusers.php"  width="950" height="4	00"  frameborder="0" name="boxes"></iframe>

	</center>		
	</div>
	<div id="divider" style="margin: 10px 0 -10px 0"></div>
	<!--footer-->
	<div id="footer">
		<p style="text-align: center; font-size: 10px; padding: 5px">Copyright © University of Santo Tomas. All rights reserved 2012</p>
	</div>
	<!--footer end-->
<script>
	   $(document).ready(
				function(){
					$('#news').innerfade({
						speed: 450,
						timeout: 5000,
						type: 'random',
						containerheight: '1px'
					});
			});
</script>
<script>
$('#ad1').hover( function() {
    $('#x').stop().animate({
        left: '-' + $(this).width() + 'px'
    });
}, function() {
    $('#x').stop().animate({
        left: '0px'
    });
});
$('#ad2').hover( function() {
    $('#y').stop().animate({
        left: '-' + $(this).width() + 'px'
    });
}, function() {
    $('#y').stop().animate({
        left: '0px'
    });
});
$('#ad3').hover( function() {
    $('#z').stop().animate({
        left: '-' + $(this).width() + 'px'
    });
}, function() {
    $('#z').stop().animate({
        left: '0px'
    });
});
</script>
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
</div>
</body>
</html>