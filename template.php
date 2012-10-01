<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");
	$id=$_GET["pid"];
	
	$sql="select * from tblcontent where page_no=$id";
	$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
	$row=mysql_fetch_array($result);	
	$page=$row["page_name"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $page?></title>
	<script type="text/javascript" src="script/oodomimagerollover.js"></script>
	<link rel="stylesheet" type="text/css" href="style1.css">
		<script language="JavaScript" src="scripts/gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
	<!--for slideshow(jQuery)-->
	
	<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="plugins/loopedslider/loopedslider.js" type="text/javascript" charset="utf-8"></script>	
	
	<script type="text/javascript">
	function wOpen(id)
	{
		window.open('slide.php?id='+id,'name','width=985,height=350,resizable=no');
		
	}
	function userblock()
		{
		
			var otep='<?php $stat=$_SESSION["loginstatus"]; echo $stat; ?>';
			if(otep==1)
			{
				return true;
			}
			else
			{
				location.href = "invalidpage.php";
				return false;
				
			}
		}
	</script>
	
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
			<?php
				echo "<h2 style=\"color: red \">$page</h2>";
		
				$content=new web_template;
				echo $content->postContent();
				
			?>
		</div>
	</div>
	<div id="divider" style="margin: 10px 0 -10px 0"></div>
	<!--footer-->
	<div id="footer">
		<p style="text-align: center; font-size: 10px; padding: 5px">Copyright &copy University of Santo Tomas. All rights reserved 2012</p>
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