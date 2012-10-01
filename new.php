<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");
	include("requisition/requisitionClass.php");
	$id=$_GET["pid"];
	
	$sql="select * from tblcontent where page_no='$id'";
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
				
				/*requisition starts here*/
				?>
				<li><a href="#" class="dir">Request</a>
					<ul>
						<li style="color: #808080"><span style="padding-left:5px">ITEMS</li>
						<li><a href="requisition/addlaptop.php">Laptop</a></li>
						<li><a href="requisition/addusb.php">USB Dongle</a></li>
						<li><a href="requisition/addrouter.php">Access Point/Router</a></li>
						<li style="color: #808080"><span style="padding-left:3px">SERVICES</li>
						<li><a href="requisition/addwebhost.php">Web Hosting</a></li>
						<li><a href="requisition/addvserver.php">Virtual Server</a></li>
						<li><a href="requisition/addvdesktop.php">Virtual Desktop</a></li>
						
					</ul>
				</li>
				<li><a href="#" class="dir">Status</a>
					<ul>
						<li style="color: #808080"><span style="padding-left:5px">ITEMS</li>
						<li><a href="requisition/listlaptop.php">Laptop</a></li>
						<li><a href="requisition/listusb.php">USB Dongle</a></li>
						<li><a href="requisition/listrouter.php">Access Point/Router</a></li>
						<li style="color: #808080"><span style="padding-left:3px">SERVICES</li>
						<li><a href="requisition/listwebhost.php">Web Hosting</a></li>
						<li><a href="requisition/listvserver.php">Virtual Server</a></li>
						<li><a href="requisition/listvdesktop.php">Virtual Desktop</a></li>						
						
						
					</ul>
				</li>
				<li><a href="#" class="dir">History</a>
					<ul>
						<li style="color: #808080"><span style="padding-left:5px">ITEMS</li>
						<li><a href="requisition/listhistorylaptop.php">Laptop</a></li>
						<li><a href="requisition/listhistoryusb.php">USB Dongle</a></li>
						<li><a href="requisition/listhistoryrouter.php">Access Point/Router</a></li>
						<li style="color: #808080"><span style="padding-left:3px">SERVICES</li>
						<li><a href="requisition/listhistorywebhost.php">Web Hosting</a></li>
						<li><a href="requisition/listhistoryvserver.php">Virtual Server</a></li>
						<li><a href="requisition/listhistoryvdesktop.php">Virtual Desktop</a></li>						
						
					</ul>
				</li>
				<?php
				/*end*/
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