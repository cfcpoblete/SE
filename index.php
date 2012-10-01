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
	<!--end slideshow(jQuery)-->
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
		<!--place slideshow here-->
			<div id="loopedSlider">	
				
					<div class="container">
					
						<div class="slides">	
							<?php
								$slides=new web_template;
								echo $slides->slideShow();
							?>
						</div>
						<div id="space">
							<div id="left">
							<a href="#" class="previous" style="color: transparent"><img src="plugins/loopedslider/img/left.PNG" width="23" height="30"/></a>
							</div>
							<div id="right">
							<a href="#" class="next" style="color: transparent"><img src="plugins/loopedslider/img/right.PNG" width="23" height="30"/></a>
							</div>
						</div>
						<div id="controls">
							<ul class="pagination">
								<?php
								$controls=new web_template;
								echo $controls->control();
								?>					
							</ul>	
						</div>
					</div>
			</div>
			
				<div id="newsticker">
					<div id="newstitle">
						WHAT'S NEW
					</div>
					<div id="newsfeeds">
						<ul id="news">	
							<?php					
								$news=new web_template;
								echo $news->news();
							?>
						</ul>
								
					</div>
				</div>

			<!--content-->
		
		<!--place ad here-->
			
			<?php
			
			$checkadstatus=new web_template;
			
						
			?>
			
			<div id="adContainer">
				<div id="adHolder">
					<?php					
					$ad=new web_template;
					echo $ad->Ads();
					?>
				</div>
			</div>
			<?php 
			 
		?>
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