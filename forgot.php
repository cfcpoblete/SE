<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");	
	
	if(isset($_GET['m'])&&$_GET['m']==md5('no match'))
	{
		$mess='Invalid email address.';
	}
	
	if(isset($_GET['m'])&&$_GET['m']==md5('blank'))
	{
		$mess='Please type your email address.';
	}
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
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
		<div id="content">
		<?php
		if($_SESSION['sending']==1)
		{
			$_SESSION['sending']=0;
			$email=$_SESSION["forgotemail"];
			echo "<h2 style='color: red'>Password Recovery</h2>";
			echo "<div style='padding-left: 10px'><span style='color: red'>Password recovery email successfully sent to $email.</span></div>";
			echo "<br/><a href='index.php'>Return Home</a>";
			
		}
		
		else
		{
		$_SESSION['sending']=0;
		?>
			<h2 style="color: red">Password Recovery</h2>
			<h4>Please enter email</h4>
			<form method="post" action="forgotprocess.php">
				<table style="margin-left: 25px">
					
					<tr>
						<td>Enter Email:</td>
						<td>
							<input name="email" autocomplete="off" style="width: 200px">
						</td>
						<td>
							<input type="submit" id="submitEdit" name="submitEdit">
						</td>
					</tr>
				</table>
			</form>
		<?php
		}
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
</body>
</html>