<?php
	class requisition2{
		private $existAcct = 0; #0 is no account, 1 if exists
	
		function checkCode(){
			$_SESSION['loginstatus']="";
			
			$code=$_POST['code'];
			
			$sql="select * from guestcodes where codes='$code'";
			$result=mysql_query($sql) or die("Error in verifying code.".mysql_error());
			
			$num=mysql_num_rows($result);
			if($num!=1){
				$m=md5("invalid");
				header("location: index.php?m=$m");
				exit;
			}
			
			$_SESSION['loginstatus']="true";
			$row=mysql_fetch_array($result);
			$_SESSION['code']=$row['code'];
			header("location: register.php");
			exit;
		}
	
		function addadminAccount(){
			$idnumber = $_POST["idnumber"];
			$password = $_POST["password"];
			$email = $_POST["email"];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$gender = $_POST['gender'];
			$birthdate = $_POST['birthdate'];
			$department = $_POST['department'];
			$position = $_POST['position'];
			
			if(trim($idnumber)=="") return "<p>Error creating account! ID Number is empty!</p>";
			if(trim($password)=="") return "<p>Error creating account! Password is empty!</p>";
			if(trim($email)=="") return "<p>Error creating account! E-mail Address is empty!</p>";
			if(trim($firstname)=="") return "<p>Error creating account! Firstname is empty!</p>";
			if(trim($lastname)=="") return "<p>Error creating account! Lastname is empty!</p>";
			if(trim($birthdate)=="") return "<p>Error creating account! Birthdate is empty!</p>";
			if(trim($position)=="") return "<p>Error creating account! Position is empty!</p>";
			
			$pw=$password;
			$password = md5($password);
			
			$this -> existAcct = 0;
			$this -> existAcct = $this -> checkadminAccount($idnumber); 
			
			if($this -> existAcct == 1) return "<p>ERROR: ID Number is already registered!<p>";
			
			$sql = "insert into adminaccounts (idnumber, password, email, firstname, lastname, gender, birthdate, department, position) values (\"$idnumber\", \"$password\", \"$email\", \"$firstname\", \"$lastname\", \"$gender\", \"$birthdate\", \"$department\", \"$position\")";
			$result = mysql_query($sql) or die ("Error in adding account. ".mysql_error());
			
			/**
			$to=$email;
			$subject=($to, $subject, $message, $header);
			$message="Dear $firstname $lastname, \n \n Thank you for signing up to stEps On-line Auction Center!";
			$message.="Your account details: \n\n Username: $username\nPassword: $pw";
			$header="From This->adminemail";
			**/
			
			return "<p>Account for $idnumber successfully created.</p>";
		}
	
		function checkadminLogin(){
			$_SESSION['loginstatus']="";
			
			$idnumber=$_POST['idnumber'];
			$password=$_POST['password'];
			$password=md5($_POST['password']);
			
			$sql="select * from adminaccounts where idnumber='$idnumber' and password='$password'";
			$result=mysql_query($sql) or die("Error in verifying login".mysql_error());
			
			$num=mysql_num_rows($result);
			if($num!=1){
				$m=md5("invalid");
				header("location: index.php?m=$m");
				exit;
			}
			
			$_SESSION['loginstatus']="true";
			$row=mysql_fetch_array($result);
			$_SESSION['adminid']=$row['adminid'];
			$_SESSION['idnumber']=$row['idnumber'];
			header("location: home.php");
			exit;
		}
		
		private function checkadmidAccount($username){
			$sql = "select username from accounts where username =\"$username\"";
			$result = mysql_query($sql) or die ("Error in checking account. $sql".mysql_error());
			
			$account = mysql_num_rows($result);
			
			if($account > 0 ) return 1;
			else return 0;
		}
		
		function getadminInfo(){
			$adminid=$_SESSION["adminid"];
			
			$sql = "SELECT * FROM adminaccounts WHERE adminid=$adminid";
			$result = mysql_query($sql) or die ("Error in displaying profile. ".mysql_error());

			while($row = mysql_fetch_array($result)){
						echo "<strong>Welcome " .$row["firstname"]. "!</strong>";
					echo "<br \><br \><table width=\"90%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr>";
						echo "<td>ID Number:<span style=\"padding-left:15px\">" .$row["idnumber"]."</td>";
						echo "<td rowspan=\"4\"><img src=\"../images/accounts/" .$row["adminid"]. ".jpg\" style= \"height: 80px; width: 80px;\"\></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Name:<span style=\"padding-left:50px\">" .$row["firstname"]. " " .$row["lastname"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>E-mail:<span style=\"padding-left:50px\">" .$row["email"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Department:<span style=\"padding-left:15px\">" .$row["department"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Position:<span style=\"padding-left:15px\">" .$row["position"]."</td>";
					echo "</tr>";

					echo "</table>";
			}
		}
		
		function listHostadmin(){
			$sql="select * from webhostrequest where status='Pending'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewwebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editwebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approvewebhost.php?webhost=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectwebhost.php?webhost=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listVserveradmin(){
			$accountid=$_SESSION['userid'];

		$sql="select * from vserverrequest where status='pending'";
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$servername=$row['servername'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["servername"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewvserver.php?vserver=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editvserver.php?vserver=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approveserver.php?vserver=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectserver.php?vserver=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listVdesktopadmin(){
			$accountid=$_SESSION['userid'];

		$sql="select * from vdesktoprequest where status='pending'";
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewvdesktop.php?vdesktop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editvdesktop.php?vdesktop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approvedesktop.php?vdesktop=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectdesktop.php?vdesktop=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listUSBadmin(){
			$accountid=$_SESSION['userid'];

		$sql="select * from usbrequest where status='pending'";
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested USB Dongle for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewusb.php?usb=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editusb.php?usb=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approveusb.php?usb=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectusb.php?usb=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listRouteradmin(){
			$accountid=$_SESSION['userid'];

			$sql="select * from routerrequest where status='Pending'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Access Point/Router for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewrouter.php?router=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editrouter.php?router=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approverouter.php?router=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectrouter.php?router=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listLaptopadmin(){
			$accountid=$_SESSION['userid'];

			$sql="select * from laptoprequest where status='Pending'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Laptop for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewlaptop.php?laptop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"View\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"editlaptop.php?laptop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approvelaptop.php?laptop=$requestid\ onclick=\"return confirmapp();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectlaptop.php?laptop=$requestid\ onclick=\"return confirmrej();\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
						</center>";
					echo "</tr>";
				}
				echo "</table>";
		return $out;
		}
		
		function listhistoryHost(){
		$accountid=$_SESSION['userid'];
		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from webhostrequest where status='Approved'||status='Rejected'||status='Cancelled' order by webhostrequest.recentact desc";
		if(isset($filter)){
		$sql="select * from webhostrequest where status='$filter' order by webhostrequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistorywebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
			}
		}
		
		function listhistoryVserver(){
			$accountid=$_SESSION['userid'];

		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from vserverrequest where (status='Approved'||status='Rejected'||status='Cancelled') order by vserverrequest.recentact desc";
		if(isset($filter)){
		$sql="select * from vserverrequest where status='$filter' order by vserverrequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$servername=$row['servername'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["servername"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistoryvserver.php?vserver=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
		}
		}
		
		function listhistoryVdesktop(){
			$accountid=$_SESSION['userid'];

		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from vdesktoprequest where (status='Approved'||status='Rejected'||status='Cancelled') order by vdesktoprequest.recentact desc";
		if(isset($filter)){
		$sql="select * from vdesktoprequest where status='$filter' order by vdesktoprequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Web Hosting for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistoryvdesktop.php?vdesktop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
		}
		}
		
		function listhistoryUSB(){
			$accountid=$_SESSION['userid'];

		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from usbrequest where status='Approved'||status='Rejected'||status='Cancelled' order by usbrequest.recentact desc";
		if(isset($filter)){
		$sql="select * from usbrequest where status='$filter' order by usbrequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested USB Dongle for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistoryusb.php?itemreq=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
		}
		}
		
		function listhistoryRouter(){
			$accountid=$_SESSION['userid'];

		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from routerrequest where status='Approved'||status='Rejected'||status='Cancelled' order by routerrequest.recentact desc";
		if(isset($filter)){
		$sql="select * from routerrequest where status='$filter' order by routerrequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested Wifi/Router for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistoryrouter.php?itemreq=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
		}
		}
		
		function listhistoryLaptop(){
			$accountid=$_SESSION['userid'];

		if(isset($_POST['button'])){
		
		$filter=$_POST['historyfilter'];
		$sql="select * from laptoprequest where status='Approved'||status='Rejected'||status='Cancelled' order by laptoprequest.recentact desc";
		if(isset($filter)){
		$sql="select * from laptoprequest where status='$filter' order by laptoprequest.recentact desc";
		}
		$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
				while($row=mysql_fetch_array($result)){
				
					$accountid=$row['userid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
					
					echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"70%\"><span style=\"padding-left:20px\">Requested USB Dongle for  ".$row["requesttitle"]. "</td>";
						echo "<td width=\"20%\"><span style=\"padding-left:20px\">Status: " .$row["status"]. "</td>";
						echo "<td>
						<center>
							<form id = \"form1\" method = \"post\" action = \"viewhistorylaptop.php?itemreq=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
							</form>
						</center>";
					echo "</tr>";	
				}
				echo "</table>";
		return $out;
		}
		}
		
		function viewwebHostadmin(){
			$request=$_GET["webhost"];
			
			$sql = "select * from webhostrequest where requestid='$request'";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Details of Web Hosting Request for ".$row["requesttitle"]."</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:108px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Title <span style=\"padding-left:83px\">" .$row["requesttitle"]."</td>";
						echo "<td>Contact Person <span style=\"padding-left:30px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Requested URL <span style=\"padding-left:82px\">" .$row["requesturl"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:22px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Capacity <span style=\"padding-left:52px\">" .$row["requestcap"]." MB</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:35px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Design Type <span style=\"padding-left:100px\">" .$row["requestdestype"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Database Type <span style=\"padding-left:85px\">" .$row["requestdbtype"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Requesting Department <span style=\"padding-left:30px\">" .$row["deptname"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:35px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:121px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:95px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"editwebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"approvewebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Approve\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"rejectwebhost.php?webhost=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Reject\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"listwebhost.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
		function viewVserveradmin(){
			$request=$_GET["vserver"];
			
			$sql = "select * from vserverrequest where requestid='$request'";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$servername=$row['servername'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:150px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Server Name <span style=\"padding-left:70px\">" .$row["servername"]."</td>";
						echo "<td>Computer Requirements <span style=\"padding-left:30px\">" .$row["cpureq"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>RAM Requirements <span style=\"padding-left:100px\">" .$row["ramreq"]."</td>";
						echo "<td>Operating System<span style=\"padding-left:77px\">" .$row["operatingsystem"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>OS Architecture <span style=\"padding-left:120px\">" .$row["osarchitecture"]." MB</td>";
						echo "<td>Custom OS install <span style=\"padding-left:78px\">" .$row["customosinstall"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Custom OS Install Requirements <span style=\"padding-left:19px\">" .$row["customosinstallreq"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Application Type <span style=\"padding-left:114px\">" .$row["applicationtype"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Type of data stored on server <span style=\"padding-left:30px\">" .$row["typeofdata"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:90px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Date Needed <span style=\"padding-left:135px\">" .$row["dateneeded"]. "</td>";
						echo "<td>Status<span style=\"padding-left:150px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"editvserver.php?vserver=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"cancelvserver.php?vserver=$requestid\" onclick=\"return confirmdel();\" >
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Cancel\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listvserver.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
		function viewVdesktopadmin(){
			$request=$_GET["vdesktop"];
			
			$sql = "select * from vdesktoprequest where requestid=$request";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:128px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Title <span style=\"padding-left:100px\">" .$row["requesttitle"]."</td>";
						echo "<td>Contact Person <span style=\"padding-left:70px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Architecture <span style=\"padding-left:120px\">" .$row["architecture"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:63px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>CPU Cores <span style=\"padding-left:128px\">" .$row["cpucore"]." MB</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:75px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"\">Ram Requirements <span style=\"padding-left:78px\">" .$row["ramreq"]."</td>";
						echo "<td colspan=\"\">Department of Affiliation <span style=\"padding-left:20px\">" .$row["deptname"]."</td>";
					echo "<tr class=\"rowcolor2\">";						
						echo "<td width=\"50%\" colspan=\"2\">Hardware Recommendations <span style=\"padding-left:16px\">" .$row["hardwarereco"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"\">Virtual Desktop <span style=\"padding-left:100px\">" .$row["virtuald"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:74px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:138px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:134px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"editvdesktop.php?vdesktop=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"cancelvdesktop.php?vdesktop=$requestid\" onclick=\"return confirmdel();\" >
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Cancel\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listdesktop.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
		function viewUSBadmin(){
			$itemreq=$_GET["requestid"];
			
			$sql = "select * from usbrequest where requestid='$itemreq'";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			$row = mysql_fetch_array($result);
			//while($row = mysql_fetch_array($result)){
					//$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					//$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:108px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Item <span style=\"padding-left:83px\">USB Dongle</td>";
						echo "<td>Contact Person <span style=\"padding-left:30px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Requested Brand <span style=\"padding-left:82px\">" .$row['requestitembrand']."</td>";
						echo "<td>Contact Number <span style=\"padding-left:22px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Capacity <span style=\"padding-left:52px\">" .$row["requestmemcap"]." MB</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:35px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Requested Color <span style=\"padding-left:100px\">" .$row["requestcolor"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Requested Quantity <span style=\"padding-left:85px\">" .$row["requestqty"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Requesting Department <span style=\"padding-left:30px\">" .$row["deptname"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:35px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:121px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:95px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"edititemusb.php?item=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"cancelwebhost.php?webhost=$requestid\" onclick=\"return confirmdel();\" >
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Cancel\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listusb.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
					echo "</table>";
		//}
		}
		
		function viewRouteradmin(){
			$itemreq=$_GET["itemreq"];
			
			$sql = "select * from routerrequest where requestid='$itemreq'";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			//while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:108px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Item <span style=\"padding-left:83px\">Access Point/Router</td>";
						echo "<td>Contact Person <span style=\"padding-left:30px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Access Type <span style=\"padding-left:52px\">" .$row["routertype"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:22px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Brand <span style=\"padding-left:82px\">" .$row["routerbrand"]."</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:35px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Requested Color <span style=\"padding-left:100px\">" .$row["routercolor"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Requested Quantity <span style=\"padding-left:85px\">" .$row["requestqty"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Requesting Department <span style=\"padding-left:30px\">" .$row["deptname"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:35px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:121px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:95px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"edititem.php?item=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"cancelwebhost.php?webhost=$requestid\" onclick=\"return confirmdel();\" >
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Cancel\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listrouter.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				//}
					echo "</table>";
		}
		
		function viewLaptopadmin(){
			$itemreq=$_GET["itemreq"];
			
			$sql = "select * from laptoprequest where requestid='$itemreq'";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			//while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:108px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Item <span style=\"padding-left:83px\">Laptop</td>";
						echo "<td>Contact Person <span style=\"padding-left:30px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Laptop Model <span style=\"padding-left:52px\">" .$row["laptopmodel"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:22px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Quantity <span style=\"padding-left:85px\">" .$row["requestqty"]."</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:35px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Requesting Department <span style=\"padding-left:30px\">" .$row["deptname"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:35px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:121px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:95px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center><form id = \"form1\" method = \"post\" action = \"editlaptop.php?item=$requestid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Edit\" />
							</form>
							
							<form id = \"form1\" method = \"post\" action = \"cancelwebhost.php?webhost=$requestid\" onclick=\"return confirmdel();\" >
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Cancel\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listlaptop.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				//}
					echo "</table>";
		}
		
		function viewhistoryHost(){
			$request=$_GET["webhost"];
			
			$sql = "select * from webhostrequest where requestid=$request";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:108px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Title <span style=\"padding-left:83px\">" .$row["requesttitle"]."</td>";
						echo "<td>Contact Person <span style=\"padding-left:30px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Requested URL <span style=\"padding-left:82px\">" .$row["requesturl"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:22px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Capacity <span style=\"padding-left:52px\">" .$row["requestcap"]." MB</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:35px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Design Type <span style=\"padding-left:100px\">" .$row["requestdestype"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Database Type <span style=\"padding-left:85px\">" .$row["requestdbtype"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Requesting Department <span style=\"padding-left:30px\">" .$row["deptname"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:35px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:121px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:95px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center>
							<form id = \"form1\" method = \"post\" action = \"listhistorywebhost.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
		function viewhistoryVserver(){
			$request=$_GET["vserver"];
			
			$sql = "select * from vserverrequest where requestid=$request";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$servername=$row['servername'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:150px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Server Name <span style=\"padding-left:70px\">" .$row["servername"]."</td>";
						echo "<td>Computer Requirements <span style=\"padding-left:30px\">" .$row["cpureq"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>RAM Requirements <span style=\"padding-left:100px\">" .$row["ramreq"]."</td>";
						echo "<td>Operating System<span style=\"padding-left:77px\">" .$row["operatingsystem"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>OS Architecture <span style=\"padding-left:120px\">" .$row["osarchitecture"]." MB</td>";
						echo "<td>Custom OS install <span style=\"padding-left:78px\">" .$row["customosinstall"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"2\">Custom OS Install Requirements <span style=\"padding-left:19px\">" .$row["customosinstallreq"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Application Type <span style=\"padding-left:114px\">" .$row["applicationtype"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">Type of data stored on server <span style=\"padding-left:30px\">" .$row["typeofdata"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:90px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Date Needed <span style=\"padding-left:135px\">" .$row["dateneeded"]. "</td>";
						echo "<td>Status<span style=\"padding-left:150px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";				
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center>
							<form id = \"form1\" method = \"post\" action = \"listhistoryvserver.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
		function viewhistoryVdesktop(){
			$request=$_GET["vdesktop"];
			
			$sql = "select * from vdesktoprequest where requestid=$request";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
					$accountid=$row['accountid'];
					$requesttitle=$row['requesttitle'];
					$requestid=$row['requestid'];
				echo "<strong>Request Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Request ID <span style=\"padding-left:128px\">".$row["requestid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Requested Title <span style=\"padding-left:100px\">" .$row["requesttitle"]."</td>";
						echo "<td>Contact Person <span style=\"padding-left:70px\">" .$row["contactname"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Architecture <span style=\"padding-left:120px\">" .$row["architecture"]."</td>";
						echo "<td>Contact Number <span style=\"padding-left:63px\">" .$row["contactnum"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>CPU Cores <span style=\"padding-left:128px\">" .$row["cpucore"]." MB</td>";
						echo "<td>Contact E-mail <span style=\"padding-left:75px\">" .$row["contactemail"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"\">Ram Requirements <span style=\"padding-left:78px\">" .$row["ramreq"]."</td>";
						echo "<td colspan=\"\">Department of Affiliation <span style=\"padding-left:20px\">" .$row["deptname"]."</td>";
					echo "<tr class=\"rowcolor2\">";						
						echo "<td width=\"50%\" colspan=\"2\">Hardware Recommendations <span style=\"padding-left:16px\">" .$row["hardwarereco"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td colspan=\"\">Virtual Desktop <span style=\"padding-left:100px\">" .$row["virtuald"]."</td>";
						echo "<td>Recent Activity <span style=\"padding-left:74px\">" .$row["recentact"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Duration <span style=\"padding-left:138px\">" .$row["startdate"]. " to " .$row["enddate"]."</td>";
						echo "<td>Status<span style=\"padding-left:134px\">" .$row["status"]."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";										
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center>
							<form id = \"form1\" method = \"post\" action = \"listhistoryvdesktop.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
			
		function editWebhost(){
			$webhost=$_GET["webhost"];
			
			$asd="select * from webhostrequest";
			$qwe=mysql_query($asd);
			$row=mysql_fetch_array($qwe);
			
			$requesttitle=$row["requesttitle"];
			$requesturl=$row["requesturl"];
			$requestcap=$row["requestcap"];
			$requestdestype=$row["requestdestype"];
			$requestdbtype=$row["requestdbtype"];
			$deptname=$row["deptname"];
			$contactname=$row["contactname"];
			$contactnum=$row["contactnum"];
			$contactemail=$row["contactemail"];
			$startdate=$row["startdate"];
			$enddate=$row["enddate"];
			
			$sql="update webhostrequest set requesttitle='$requesttitle', requesturl='$requesturl', requestcap='$requestcap', requestdestype='$requestdestype', requestdbtype='$requestdbtype', deptname='$deptname', contactname='$contactname', contactnum='$contactnum', contactemail='$contactemail', startdate='$startdate', enddate='$enddate', recentact=now()  where requestid='$accountid'";
			$result = mysql_query($sql) or die ("Error in editing item. ".mysql_error());
			
			return "<p>Requested Web Hosting for ($requesttitle) is successfully updated.</p>";
			
			header ("location: editwebhost.php");
			exit;
		}
		
		function approveWebhost(){
			$webhost=$_GET["webhost"];
			$sql="UPDATE  `requisition2`.`webhostrequest` SET  `status` =  'Approved' WHERE  `webhostrequest`.`requestid` ='$webhost' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in approving request. ".mysql_error());
			
			return "<p>Request is successfully approved!</p>";
		}
		
		function approveVserver(){
			$vserver=$_GET["vserver"];
			$sql="UPDATE  `requisition2`.`vserverrequest` SET  `status` =  'Approved' WHERE  `vserverrequest`.`requestid` ='$vserver' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in approving request. ".mysql_error());
			
			return "<p>Request is successfully approved!</p>";
		}
		
		function approveVdesktop(){
			$vdesktop=$_GET["vdesktop"];
			$sql="UPDATE  `requisition2`.`vdesktoprequest` SET  `status` =  'Approved' WHERE  `vdesktoprequest`.`requestid` ='$vdesktop' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in approving request. ".mysql_error());
			
			return "<p>Request is successfully approved!</p>";
		}
		
		function approveusb(){
			$usb=$_GET["itemreq"];
			$sql="UPDATE  `requisition2`.`usbrequest` SET  `status` =  'Approved' WHERE  `usbrequest`.`requestid` ='$usb' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in approving request. ".mysql_error());
			
			return "<p>Request is successfully approved!</p>";
		}
		
		function approverouter(){
			$router=$_GET["itemreq"];
			$sql="UPDATE  `requisition2`.`routerrequest` SET  `status` =  'Approved' WHERE  `routerrequest`.`requestid` ='$router' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in approving request. ".mysql_error());
			
			return "<p>Request is successfully approved!</p>";
		}
		
		function rejectWebhost(){
			$webhost=$_GET["webhost"];
			$sql="UPDATE  `requisition2`.`webhostrequest` SET  `status` =  'Rejected' WHERE  `webhostrequest`.`requestid` ='$webhost' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		function rejectVserver(){
			$vserver=$_GET["vserver"];
			$sql="UPDATE  `requisition2`.`vserverrequest` SET  `status` =  'Rejected' WHERE  `vserverrequest`.`requestid` ='$vserver' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		function rejectusb(){
			$usb=$_GET["itemreq"];
			$sql="UPDATE  `requisition2`.`usbrequest` SET  `status` =  'Rejected' WHERE  `usbrequest`.`requestid` ='$usb' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		function rejectrouter(){
			$router=$_GET["itemreq"];
			$sql="UPDATE  `requisition2`.`routerrequest` SET  `status` =  'Rejected' WHERE  `routerrequest`.`requestid` ='$router' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		function rejectlaptop(){
			$laptop=$_GET["itemreq"];
			$sql="UPDATE  `requisition2`.`laptoprequest` SET  `status` =  'Rejected' WHERE  `laptoprequest`.`requestid` ='$laptop' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		function rejectVdesktop(){
			$vdesktop=$_GET["vdesktop"];
			$sql="UPDATE  `requisition2`.`vdesktoprequest` SET  `status` =  'Rejected' WHERE  `vdesktoprequest`.`requestid` ='$vdesktop' LIMIT 1";
			$result = mysql_query($sql) or die ("Error in rejecting request. ".mysql_error());
			
			return "<p>Request is successfully rejected!</p>";
		}
		
		/**************************INVENTORY****************************/
		function additemusb(){
			$accountid=$_SESSION['adminid'];
			$item_name=$_POST['item_name'];
			$item_quan=$_POST['item_quantity'];
			$duration=$_POST['borrowing_period'];
			$item_cap=$_POST['item_capacity'];
			$item_model=$_POST['item_model'];
			$item_color=$_POST['item_color'];
			$item_mac=$_POST['item_mac'];
			$item_sn=$_POST['item_sn'];
			if(trim($item_name=="")) return "<p>Error item name empty</p>";
			if(trim($item_cap=="")) return "<p>Error item capacity empty</p>";
			if(trim($item_model=="")) return "<p>Error item brand empty</p>";
			if(trim($item_color=="")) return "<p>Error color empty</p>";
			if(trim($item_mac=="")) return "<p>Error mac empty</p>";
			if(trim($item_sn=="")) return "<p>Error sn empty</p>";
			if(trim($item_quan=="")) return "<p>Error qunatity empty</p>";
			if(trim($duration=="")) return "<p>Error borrowing period empty</p>";
			
			$sql="insert into item  (accountid,item_name, item_quantity, borrowing_period, item_capacity, item_model, item_color, item_mac, item_sn) values ('$accountid','$item_name','$item_quan','$duration','$item_cap','$item_model','$item_color','$item_mac','$item_sn')";	
			$result=mysql_query($sql) or die("Error in adding item $sql".mysql_error());
				
			return "<p>Item $item_name successfully added!</p>";
			}
		
		function additemrouter(){
			$accountid=$_SESSION['adminid'];
			$item_name=$_POST['item_name'];
			$item_quan=$_POST['item_quantity'];
			$duration=$_POST['borrowing_period'];
			$item_type=$_POST['item_type'];
			$item_model=$_POST['item_model'];
			$item_color=$_POST['item_color'];
			$item_mac=$_POST['item_mac'];
			$item_sn=$_POST['item_sn'];
			if(trim($item_name=="")) return "<p>Error item name empty</p>";
			if(trim($item_type=="")) return "<p>Error item type empty</p>";
			if(trim($item_model=="")) return "<p>Error item brand empty</p>";
			if(trim($item_color=="")) return "<p>Error color empty</p>";
			if(trim($item_mac=="")) return "<p>Error mac empty</p>";
			if(trim($item_sn=="")) return "<p>Error sn empty</p>";
			if(trim($item_quan=="")) return "<p>Error quantity empty</p>";
			if(trim($duration=="")) return "<p>Error borrowing period empty</p>";
			
			
			$sql="insert into item  (accountid,item_name,item_quantity,borrowing_period,item_type,item_model,item_color,item_mac,item_sn) values ('$accountid','$item_name','$item_quan','$duration','$item_type','$item_model','$item_color','$item_mac','$item_sn')";	
			$result=mysql_query($sql) or die("Error in adding item $sql".mysql_error());
				
			return "<p>Item $item_name successfully added!</p>";
		}
		
		function additemlaptop(){
			$accountid=$_SESSION['adminid'];
			$item_name=$_POST['item_name'];
			$item_quantity=$_POST['item_quantity'];
			$borrowing_period=$_POST['borrowing_period'];
			$item_os=$_POST['item_os'];
			$item_model=$_POST['item_model'];
			$item_color=$_POST['item_color'];
			$item_ram=$_POST['item_ram'];
			$item_mac=$_POST['item_mac'];
			$item_sn=$_POST['item_sn'];
			$item_vc=$_POST['item_vc'];
			$item_screen=$_POST['item_screen'];
			$item_battery=$_POST['item_battery'];
			$item_hd=$_POST['item_hd'];
			$item_processor=$_POST['item_processor'];
			$item_weight=$_POST['item_weight'];
			
			if(trim($item_name=="")) return "<p>Error item name empty</p>";
			if(trim($item_quantity=="")) return "<p>Error item quantity empty</p>";
			if(trim($borrowing_period=="")) return "<p>Error borrowing period empty</p>";
			if(trim($item_os=="")) return "<p>Error os empty</p>";
			if(trim($item_model=="")) return "<p>Error item brand empty</p>";
			if(trim($item_color=="")) return "<p>Error color empty</p>";
			if(trim($item_ram=="")) return "<p>Error ram empty</p>";
			if(trim($item_mac=="")) return "<p>Error mac empty</p>";
			if(trim($item_sn=="")) return "<p>Error sn empty</p>";
			if(trim($item_vc=="")) return "<p>Error vc empty</p>";
			if(trim($item_screen=="")) return "<p>Error screen empty</p>";
			if(trim($item_battery=="")) return "<p>Error bat empty</p>";
			if(trim($item_hd=="")) return "<p>Error hd empty</p>";
			if(trim($item_processor=="")) return "<p>Error proc empty</p>";
			if(trim($item_weight=="")) return "<p>Error weight empty</p>";
			
			
			$sql="insert into item  (accountid, item_name, item_quantity, borrowing_period, item_os, item_model, item_color, item_ram, item_mac, item_sn, item_vc, item_screen, item_battery, item_hd, item_processor, item_weight) values ('$accountid', '$item_name', '$item_quantity', '$borrowing_period', '$item_os', '$item_model', '$item_color', '$item_ram', '$item_mac', '$item_sn', '$item_vc', '$item_screen', '$item_battery', '$item_hd', '$item_processor', '$item_weight')";	
			$result=mysql_query($sql) or die("Error in adding item $sql".mysql_error());
				
			return "<p>Item $item_name successfully added!</p>";
		}
		
		function listitemUSB(){
			$sql="select * from item where item_name='USB Dongle'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				echo "<strong>USB Dongle Inventory</strong><br><br>";
				echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td><div width=\"16%\" align=\"center\">Item</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Qty.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Capacity</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Model</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Color</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">MAC Address</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Serial No.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">  </div></td>";

				while($row=mysql_fetch_array($result)){
				
					$itemid=$row['itemid'];	
					
					echo "<tr class=\"rowcolor2\">";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_name']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_quantity']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_capacity']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_model']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_color']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_mac']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_sn']."</div></td>";
						echo "<td>
								<center>
									<form id = \"form1\" method = \"post\" action = \"edititemusb.php?item=$itemid\">
										<input type = \"submit\" name = \"button\" id = \"button\" value = \"Update\" />
									</form>
								</center>";
						echo "</tr>";	
					}
				echo "</table>";
			return $out;
		}
		
		function listitemRouter(){
			$sql="select * from item where item_name='Access Point/Router'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				echo "<strong>USB Dongle Inventory</strong><br><br>";
				echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td><div width=\"16%\" align=\"center\">Item</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Qty.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Access Type</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Model</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Color</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">MAC Address</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Serial No.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">  </div></td>";

				while($row=mysql_fetch_array($result)){
				
					$itemid=$row['itemid'];	
					
					echo "<tr class=\"rowcolor2\">";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_name']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_quantity']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_type']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_model']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_color']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_mac']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_sn']."</div></td>";
						echo "<td>
								<center>
									<form id = \"form1\" method = \"post\" action = \"edititemrouter.php?item=$itemid\">
										<input type = \"submit\" name = \"button\" id = \"button\" value = \"Update\" />
									</form>
								</center>";
						echo "</tr>";	
					}
				echo "</table>";
			return $out;
		}
		
		function listitemLaptop(){
			$sql="select * from item where item_name='Laptop'";
			$result=mysql_query($sql) or die("Error in selecting items ".mysql_error());
			$out="<ul>";
			
				echo "<strong>USB Dongle Inventory</strong><br><br>";
				echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\">";
					echo "<tr class=\"rowcolor1\">";
						echo "<td><div width=\"16%\" align=\"center\">Item</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Qty.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Operating System</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Model</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Color</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">MAC Address</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">Serial No.</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">  </div></td>";

				while($row=mysql_fetch_array($result)){
				
					$itemid=$row['itemid'];	
					
					echo "<tr class=\"rowcolor2\">";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_name']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_quantity']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_os']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_model']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_color']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_mac']."</div></td>";
						echo "<td><div width=\"13%\" align=\"center\">".$row['item_sn']."</div></td>";
						echo "<td>
								<center>
									<form id = \"form1\" method = \"post\" action = \"viewitemlaptop.php?item=$itemid\">
										<input type = \"submit\" name = \"button\" id = \"button\" value = \"Details\" />
									</form>
									<form id = \"form1\" method = \"post\" action = \"edititemlaptop.php?item=$itemid\">
										<input type = \"submit\" name = \"button\" id = \"button\" value = \"Update\" />
									</form>
								</center>";
						echo "</tr>";	
					}
				echo "</table>";
			return $out;
		}
		
		function viewitemlaptop(){
			$item=$_GET["item"];
			
			$sql = "select * from item where itemid=$item";
			$result = mysql_query($sql) or die ("Error in displaying Request.$sql ".mysql_error());
			
			while($row=mysql_fetch_array($result)){
				
				$itemid=$row['itemid'];	
				
				echo "<strong>Laptop Information</strong><br \>";
				echo "<table  id=\"table2\" width=\"100%\" border=\"0\" cellpadding=\"2\"";
					echo "<tr class=\"rowcolor1\" >";
						echo "<td width=\"50%\" colspan=\"2\">Item ID <span style=\"padding-left:108px\">".$row["itemid"]. "</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Item <span style=\"padding-left:83px\">" .$row["item_name"]."</td>";
						echo "<td>Borrowing Period <span style=\"padding-left:30px\">" .$row["contactname"]." days</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Item Model <span style=\"padding-left:82px\">" .$row["item_model"]."</td>";
						echo "<td>Color <span style=\"padding-left:22px\">" .$row["item_color"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td colspan=\"2\">Operating System <span style=\"padding-left:85px\">" .$row["item_os"]."</td>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td>Hard Drive <span style=\"padding-left:100px\">" .$row["item_hd"]."</td>";
						echo "<td>Video Card <span style=\"padding-left:100px\">" .$row["item_vc"]."</td>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Processor <span style=\"padding-left:52px\">" .$row["item_processor"]." MB</td>";
						echo "<td>RAM <span style=\"padding-left:35px\">" .$row["item_ram"]."</td>";
					echo "</tr>";
					echo "</tr>";
					echo "<tr class=\"rowcolor1\">";
						echo "<td width=\"50%\">MAC Address <span style=\"padding-left:30px\">" .$row["item_mac"]."</td>";
						echo "<td>Serial No. <span style=\"padding-left:35px\">" .$row["item_sn"]."</td>";
					echo "</tr>";
					echo "<tr class=\"rowcolor2\">";
						echo "<td>Screen Measurement <span style=\"padding-left:121px\">" .$row["item_screen"]." inches</td>";
						echo "<td>Weight <span style=\"padding-left:95px\">" .$row["item_weight"]." lbs.</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=\"20px\" colspan=\"2\"> </td>";
					echo "</tr>";					
					echo "<tr>";
						echo "<td colspan=\"2\">
							<center>
							<form id = \"form1\" method = \"post\" action = \"edititemlaptop.php?item=$itemid\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Update\" />
							</form>
							<form id = \"form1\" method = \"post\" action = \"listitemlaptop.php\">
								<input type = \"submit\" name = \"button\" id = \"button\" value = \"Back to List\" />
							</form>
							</center>
						</td>";
					echo "</tr>";
				}
					echo "</table>";
		}
		
	}
	
?>