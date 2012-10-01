

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home - Community Template</title>
	<script type="text/javascript" src="script/oodomimagerollover.js"></script>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<!--for slideshow(jQuery)-->
	<link rel="stylesheet" type="text/css" href="plugins/calendar/tcal.css" />
	<script type="text/javascript" src="plugins/calendar/tcal.js"></script> 
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

			</div>
			<div id="name">
	
			</div>
			<div id="loginContainer">

			</div>
		</div>
	</div>
	<!--header end-->
	<div id="divider"style="margin-bottom: 1px"></div>
	<!--menu-->
	<div id="menuHolder">
		<div id="menuContainer">
			<ul style="margin:0; padding-left:15px; text-align: left">

			</ul>
		</div>
	</div>
	<!--menu end-->
	<div id="divider" style="margin-top: 1px"></div>
	<!--content-->
	<div id="contentContainer">
		<!--content-->
		<div id="content">
			<div><span class="myaccounttitle">Personal Information</span></div>
			<table>
			<tr><td>&nbsp;</td></tr>
			<form method="post" action="myaccount.php">

				<tr><td><label>ID Number:</label></td><td></td></tr>

			<tr><td><label>Account Type:</label></td><td>
			
			</td></tr>
			<tr><td><label>Username:</label></td><td></td></tr>
			<tr><td><label>First Name:</label></td><td><input autocomplete="off" name="firstname" value="<?php echo $_SESSION['firstname']; ?>"/></td></tr>
			<tr><td><label>Middle Name:</label></td><td><input autocomplete="off" name="middlename" value="<?php echo $_SESSION['middlename']; ?>"/></td></tr>
			<tr><td><label>Last Name:</label></td><td><input autocomplete="off" name="lastname" value="<?php echo $_SESSION['lastname']; ?>"/></td></tr>
			<tr><td><label>Email Address:</label></td><td><input autocomplete="off" name="email" value="<?php echo $_SESSION['email']; ?>"/></td></tr>
			<tr><td><label>Gender:</label></td><td>

			</td></tr>
			<tr><td><label>Birthdate:</label></td><td><input type="text" readonly="readonly" name="birthdate" id="birthdate" class="tcal" value="<?php echo $_SESSION['birthdate']; ?>" />
			<tr><td><input type="submit" name="buttonSubmit" value="Save" /></tr></td>
			</form>
			</table>

				<span class="myaccounttitle">Change Password</span>
				<table>
				<form id="form4"method="post" action="myaccount.php">
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td><label class="myaccountlabel">New Password</label></td><td align="center"><input type="password" name="newpassword" id="newpassword" /></td>
				</tr>
				<tr><td><label class="myaccountlabel">Confirm New Password</label></td><td align="center"><input type="password" name="confirmnewpassword" id="confirmnewpassword" /></td></tr>
				<tr><td></td><td align="right"><input type="submit" name="changepasswordButton" value="Submit" /><a href="myaccount.php"><input type="button" name="cancelbutton" value="Cancel" /></a></td></tr>
				</form><script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("form4");
  frmvalidator.addValidation("newpassword","req","New password is required required...");
  frmvalidator.addValidation("confirmnewpassword","req","Confirm new password required...");
  frmvalidator.addValidation("newpassword","minlen=6",	"Minimum length for password is 6 characters.");
  frmvalidator.addValidation("confirmnewpassword","eqelmnt=newpassword","The confirm password is not the same as the password");
//]]></script>
				</table>

			<hr />
			<div><span class="myaccounttitle">Personal Information</span><br /><a href="myaccount.php?m=">Edit details</a></div>
			<table>
				<tr><td>&nbsp;</td></tr>
					
						<tr><td><span class="myaccountlabel">ID Number: </span></td><td></td><td><span><?php echo $idn?></span></td></tr>
					
				<tr>
					<td>
					<span class="myaccountlabel">Account Type: </span><td/><td><span>
					<?php $atype = $_SESSION['usertype'];
					if($atype=="Admin")
					{
						$atype = "Administrative Officer";
					}
					else if($atype=="Faculty") 
					{
						$atype = "Faculty Member";
					}
					else if($atype=="Support") 
					{
						$atype = "Support Staff";
					}
					else
					{}
					echo "$atype";
					
					?>
					</span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Username: </span><td/><td><span><?php echo $_SESSION['username']; ?></span>
					</td>
				</tr>	
				<tr>
					<td>
					<span class="myaccountlabel">First Name: </span><td/><td><span><?php echo $_SESSION['firstname']; ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Middle Name: </span><td/><td><span><?php echo $_SESSION['middlename']; ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Last Name: </span><td/><td><span><?php echo $_SESSION['lastname']; ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Email Address: </span><td/><td><span><?php echo $_SESSION['email']; ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Gender: </span><td/><td><span>
					<?php 	
					$g = $_SESSION['gender']; 
					if ($g=='M' || $g=='m')
					{
						echo "Male";
					}
					else if ($g=='F' || $g=='f')
					{
						echo "Female";
					} 
					?>
					</span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="myaccountlabel">Birthdate: </span><td/><td><span><?php echo $_SESSION['birthdate']; ?></span>
					</td>
				</tr>
			</table>
			<hr />
			<span class="myaccounttitle">Change Password</span>
			
			<table>
			<form method="post" action="myaccount.php">
			<tr><td>&nbsp;</td><td width="200px"><div class="invalidstatement"><?php echo $mess;?></div></td></tr>
			<tr>
			<td><label class="myaccountlabel">Old Password</label></td><td align="center"><input type="password" name="oldpassword" id="oldpassword" /></td><td><input size="30" type="submit" name="continueButton" value="continue" /></td>
			</tr>
			</form>
			</table>
		
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