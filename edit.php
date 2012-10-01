<?php
	session_start();
	require_once("scripts/dbconnect.php");
	require_once("scripts/webTemplateClass.php");
	$templateClass=new web_template();
	$mess="";
	$success=false;
	
	if (isset($_REQUEST['btnSubmit']))
	{
		$username =$_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname =$_POST['lastname'];
		$email =$_POST['email'];
		$gender =$_POST['gender'];
		$birthday = $_POST['birthday'];
		$type = $_POST['type'];
	
	 
	if($templateClass->checkaccount($username))
	{
		
		
		$templateClass->editAccount($username, $password, $firstname, $middlename, $lastname, $email, $gender, $birthday, $type);
		
		$success=true;
		$mess="You have created an account successfully!";
	}
	}
	if (isset($_GET['uname']))
	{
		
				$edit = $_GET['uname'];
				$edit = mysql_query("SELECT * FROM tblaccount WHERE username='$edit'");
				while($row = mysql_fetch_array($edit))
				{
		
					$idnumber = $row['idnumber'];
					$username = $row['username'];
					$gender = $row['gender'];
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
					$middlename = $row['middlename'];
					$birthdate = $row['birthdate'];
					$usertype = $row['usertype'];
					$type = $row['type'];
					$password = $row['password'];
					$email = $row['email'];
				}
	}
				?>			
			

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<!--for slideshow(jQuery)-->
	
	<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="plugins/calendar/calendar.css" />
	<script type="text/javascript" src="plugins/calendar/calendar.js"></script> 
	<script src="plugins/loopedslider/loopedslider.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	</script>
	<script language="JavaScript" src="scripts/gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
	
	<link rel="stylesheet" type="text/css"  href="plugins/loopedslider/style.css">	
	<style type="text/css">
	
		#error{
			color:red;
		}
	</style>
	<!--end slideshow(jQuery)-->
</head>
<body>

<div id="wrap">
	<!--header-->

	<!--header end-->
	<!--content-->
	<div id="contentContainer">
			
		<!--content-->
<div id="content">
			<h1 style='color: red '>Edit Account</h1>
			<div id="regmess"><?php echo $mess; ?></div>
			<div>&nbsp;</div>
			<?php if(!$success){?>
			<form id="from1" name="form1"method="post" action="<?php $edit ='edit.php?uname=$edit'; ?>">
				<table width="500px">
					
					<tr>
						<th ><h2 class="title" style='color: red '>Account Information</h2></th>
					</tr>
					<tr class="aeven">
					</tr>
					<tr class="aodd">
						<td>
							<div class="labelreg">Username:</div >
							<div class="inputreg">
								<input type="text" name="username" id="username" tabindex="2" autocomplete="off" maxlength="32" size="20" style="width:150px" value="<?php echo $username; ?>" />
							</div>
						</td>
					</tr>
					<tr class="aeven">
						<td>
							<div class="labelreg">Password:</div >
							<div class="inputreg">
								<input type="password" name="password" id="password" tabindex="3" autocomplete="off" maxlength="32" size="20" style="width:150px" />
							</div>
						</td>
					</tr>
					<tr class="aodd">
						<td>
							<div class="labelreg">Confirm Password:</div >
							<div class="inputreg">
								<input type="password" name="confirmPassword" id="confirmPassword" tabindex="4" autocomplete="off" maxlength="32" size="20" style="width:150px"/>
							</div>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<th ><h2 class="title" style='color: red '>Personal Information</h2></th>
					</tr>
					<tr class="aeven">
						<td>
							<div class="labelreg">First Name:</div >
							<div class="inputreg">
								<input type="text" name="firstname" id="firstname" tabindex="5" autocomplete="off" maxlength="32" size="20" value="<?php echo isset($firstname) ? $firstname: "" ?>" />
							</div>
						</td>
					</tr>
					<tr class="aodd">
						<td>
							<div class="labelreg">Middle Name:</div >
							<div class="inputreg">
								<input type="text" name="middlename" id="middlename" tabindex="6" autocomplete="off" maxlength="32" size="20" value="<?php echo isset($middlename) ? $middlename : "" ?>" />
							</div>
						</td>
					</tr>
					<tr class="aeven">
						<td>
							<div class="labelreg">Last Name:</div >
							<div class="inputreg">
								<input type="text" name="lastname" id="lastname" tabindex="7" autocomplete="off" maxlength="32" size="20" value="<?php echo isset($lastname) ? $lastname : "" ?>" />
							</div>
						</td>
					</tr>
				
					<tr class="aodd">
						<td>
							<div class="labelreg">Email Address:</div >
							<div class="inputreg">
								<input type="text" name="email" id="email" tabindex="8" autocomplete="off" maxlength="32" size="20" value="<?php echo isset($email) ? $email : "" ?>" />
							</div>
						</td>
					</tr>
					
					<tr class="aeven">
						<td>
							<div class="labelreg">Gender:</div >
							<div class="inputreg">
								<select name="gender"id="gender" tabindex="9">
								<?php
									if(isset($gender))
									{
										$var1 = $var2 = $var3 = "";
										if($gender=="M")
										{$var2="selected";}
										else if($gender=="F")
										{$var3="selected";}
										
									}
								?>
								<option value="000" >-Select Gender-</option>
								<option value="M" >Male</option>
								<option value="F" >Female</option>
								</select>
							</div>
						</td>
					</tr>
					<tr class="aodd">
						<td>
							<div class="labelreg">Birth date:</div >
							<div class="inputreg">
								<a onClick="setYears(1947, 2012);showCalender(this, 'birthday');"><input type="text" name="birthday" id="birthday" value="<?php echo isset($birthdate) ? $birthdate : "" ?>" readonly tabindex="10" /></a>
								<table id="calenderTable">
									<tbody id="calenderTableHead">
									  <tr>
										<td colspan="4" align="center">
										  <select onChange="showCalenderBody(createCalender(document.getElementById('selectYear').value,
										   this.selectedIndex, false));" id="selectMonth">
											  <option value="0">Jan</option>
											  <option value="1">Feb</option>
											  <option value="2">Mar</option>
											  <option value="3">Apr</option>
											  <option value="4">May</option>
											  <option value="5">Jun</option>
											  <option value="6">Jul</option>
											  <option value="7">Aug</option>
											  <option value="8">Sep</option>
											  <option value="9">Oct</option>
											  <option value="10">Nov</option>
											  <option value="11">Dec</option>
										  </select>
										</td>
										<td colspan="2" align="center">
											<select onChange="showCalenderBody(createCalender(this.value, 
											document.getElementById('selectMonth').selectedIndex, false));" id="selectYear">
											</select>
										</td>
										<td align="center">
											<a href="#birthday" onClick="closeCalender();" style="font-weight:bold;"><font color="#003333">X</font></a>
										</td>
									  </tr>
								   </tbody>
								   <tbody id="calenderTableDays">
									 <tr style="">
									   <td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td>
									 </tr>
								   </tbody>
								   <tbody id="calender"></tbody>
								</table>
							</div>
						</td>
					</tr>
					<tr class="aeven">
						<td>
							<div class="labelreg">Type:</div >
							<div class="inputreg">
								<input type="text" name="type" id="type" tabindex="7" autocomplete="off" maxlength="32" size="20" value="<?php echo isset($type) ? $type : "" ?>" />
							</div>
						</td>
					</tr>
					<tr>
						<td><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" /><input type="button" value="Clear" onclick="location.href='register.php'"></td>
						
					</tr>
				</table>
				<!-- display the script as an image --> 
		 
			</form><script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("form1");
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
 frmvalidator.EnableMsgsTogether();
 
 frmvalidator.addValidation("firstname","req","Please enter your First Name");
  frmvalidator.addValidation("firstname","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("firstname","alpha_s","Name can contain alphabetic chars only");
  
  frmvalidator.addValidation("middlename","req","Please enter your Middle Name");
  frmvalidator.addValidation("middlename","maxlen=20","For LastName, Max length is 20");
  
   frmvalidator.addValidation("lastname","req","Please enter your Middle Name");
  frmvalidator.addValidation("lastname","maxlen=20","For LastName, Max length is 20");
  
  frmvalidator.addValidation("email","maxlen=50");
  frmvalidator.addValidation("email","req");
  frmvalidator.addValidation("email","email");
  
  frmvalidator.addValidation("gender","dontselect=000");
  frmvalidator.addValidation("confirmPassword","eqelmnt=password","The confirm password is not the same as the password");
  frmvalidator.addValidation("birthday","req","Please select your birth date.");
  frmvalidator.addValidation("password","minlen=6",	"Minimum length for password is 6 characters.");
  frmvalidator.addValidation("code","req","Please enter the security code");
  
//]]></script>
		<?php } ?>
		
		</div>
	
	<!--place ad here-->
	</div>
	<div id="divider"></div>
	<!--footer-->
	
	<div id="footer">
	</div>
	<!--footer end-->
</div>

</body>
</html>