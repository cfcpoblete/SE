<?php
	
	class web_template
	{		
		function addadminAccount($usertype, $username, $password, $firstname, $middlename, $lastname, $email, $gender, $birthday)
		{

			if($usertype=='Administrator')
			{
				$type=1;
			}
			else if($usertype=='Super User')
			{
				$type=0;
			}
			else
			{
				$type=2;
			}
			
			$password=md5($password);
			$sql="insert into tblaccount (username,password,firstname,middlename,lastname,email,gender,usertype,birthdate,type) values ('$username','$password','$firstname','$middlename','$lastname','$email','$gender','$usertype','$birthday','$type')";
			$result=mysql_query($sql) or die("Error in inserting the account:".mysql_error());
			
			if($usertype=='Administrator')
			{
				$getpriv = 'R';
				$sql1="select * from tblcontent_admin";
			$result1=mysql_query($sql1) or die("Error in listing images:".mysql_error());
			$i=0;
			while($row=mysql_fetch_array($result1))
				{
					$name=$row["adpage_name"];
					$status=$row["status"];
					$id=$row["adpage_no"];
					
					if($id!=1001&&$id!=1002)
					{
						$pv.="0";
					}
				}
				$sql2="insert into tbladmin_privileges values ('$username','$getpriv','$pv')";
				$result2=mysql_query($sql2) or die("Error in inserting privileges:".mysql_error());
			}
			
			
			return $result;
		}
		
		function addAccount($usertype, $username, $password, $firstname, $middlename, $lastname, $email, $gender, $birthday)
		{
			$type=2;
			$password=md5($password);
			$sql="insert into tblaccount (username,password,firstname,middlename,lastname,email,gender,usertype,birthdate,type) values ('$username','$password','$firstname','$middlename','$lastname','$email','$gender','$usertype','$birthday','$type')";
			$result=mysql_query($sql) or die("Error in inserting the account:".mysql_error());
		
			
			return $result;
		}
		function editAccount($username, $password, $firstname, $middlename, $lastname, $email, $gender, $birthday, $type)
		{
			$edit = $_GET['uname'];
			$type=2;
			$password=md5($password);
			$sql="UPDATE tblaccount SET username = '$username', password = '$password', firstname = '$firstname', middlename = '$middlename' ,lastname = '$lastname',email = '$email',gender = '$gender' ,birthdate = '$birthday' , type = '$type' WHERE username='$edit'";
			$result=mysql_query($sql) or die("Error in inserting the account:".mysql_error());
		
			
			return $result;
		}
		
		function checkaccount($username)
		{
			$sql="select username from tblaccount where username=\"$username\"";
			$result=mysql_query($sql) or die("Error in adding account:".mysql_error());
			
			$accounts=mysql_num_rows($result);
			if($accounts>0) 
			{
			return true;
			}
			else
			{
			return false;
			}
		}
		
		function postContent()
			{								
				
								
				
				{
					$id=$_GET["pid"];
					
					if($id==null)
					{
						$id=1;
					}
					
					$sql="select content from tblcontent where page_no=$id";
					$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
					
					$row=mysql_fetch_Array($result);
					return $row["content"];
				}
				
				
				{
					$id=$_GET["id"];
					
					$sql="select content from tblaccessories where id=$id";
					$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
					
					$row=mysql_fetch_Array($result);
					return $row["content"];
				}
				
			}
			
		function updateContent()
		{
			$type=$_GET["type"];
			
			if($type=="access")
			{
				$id=$_GET["id"];
				$name=$_POST["name"];
				$content=$_POST["content"];
				$sql="update tblaccessories set content='$content', name='$name' where id=$id";
				$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
			}
			
			else
			{
				$id=$_GET["pid"];
				$content=$_POST["content"];
				$sql="update tblcontent set content='$content' where page_no='$id'";
				$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
			}
			
			return "Content_updated";
			
		}
		
		function updateinfo($firstname,$middlename,$lastname,$email,$birthdate)
		{
			$username=$_SESSION["username"];
			$sql="update tblaccount set firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', birthdate='$birthdate' where username='$username'";
			$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
		}

			
		
		function menu()
		{		
			
			$sql="select * from tblcontent order by page_no";
			$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					
					$page_name=$row["page_name"];
					$link=$row["link"];
					$page=$row["page_no"];
					
					if($page!=1000)
					{
						echo "<li><a href=\"$link?pid=$page\">$page_name</a></li>";
					}
					
				}
		}
		
		function menuAdmin()
		{
			$sql="select * from tblcontent_admin order by adpage_no";
			$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{			
					$page_name=$row["adpage_name"];
					$link=$row["adlink"];
					$page=$row["adpage_no"];
					if($page!=1001&&$page!=1002)
					{
						echo "<li><a href=\"$link?pid=$page\">$page_name</a></li>";
					}
					
					else
					{
						echo "<li><a href=\"$link\">$page_name</a></li>";
					}
				}			
		}
		
		function slideShow()
		{
			$sql="select * from tblimages";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$alt=$row["alt"];
					$status=$row["status"];
					if($type=='slide' && $status==1)
					{
						echo "<div><img src=\"$address\" width=\"937\" height=\"300\" alt=\"$alt\" /></div>";
					}
				}			
		}
		
		function checklogin()
		{
			// $cnx = $_SESSION['cnx'];
			$_SESSION["loginstatus"]="";
			$SearchFor=$_POST["username"];
			$getpass=$_POST["password"];
			// $password="userPassword";
			$h = false;
			
			// $rdn = "ou=thomasians,dc=ust,dc=edu,dc=ph";
			// $filter = "(uid=$SearchFor)";
			// $LDAPFieldsToFind = array("cn", "ctrlno", "userPassword");
			// $sr = ldap_search($cnx, $rdn, $filter, $LDAPFieldsToFind);
			// $comp = "uid=".$SearchFor.",ou=thomasians,dc=ust,dc=edu,dc=ph";
			
			
			// if($sr)
			// {
			$sql = "select * from tblaccount where username='$SearchFor'";
			$result = mysql_query($sql) or die("Error in finding the username's info: ".mysql_error());
			$count = mysql_num_rows($result);
				if($count == 1)
				{
					$row = mysql_fetch_array($result);
					$getpass = md5($getpass);
					if($row['password'] == $getpass && $row['type'] == 2)
					{
					$_SESSION['type'] = $row['type'];
						$_SESSION['loginstatus'] = true;
						$_SESSION['username'] = $row['username'];
						$_SESSION['uid'] = $SearchFor;
						$u = md5($SESSION_['uid']);
						if($row['type'] == 2)
						{
						header("location:../adminpage.php");
						}
						elseif ($row['type'] == 1)
						{
						header("location:../customerpage.php");
						}
						else
						{
						header("location:../index.php");
						}
						exit;
						$h = true;
					}
					else
					{
						$m=md5("invalid");
						header("location: ../invalidpage.php?m=$m");
						exit;
					}
				}
				else
				{ 
					// $verify=@ldap_compare($cnx, $comp, $password, $getpass);
					// $info = ldap_get_entries($cnx, $sr);
					// if($verify===true)
					// {
					// $_SESSION['loginstatus'] = true;
					// $_SESSION['username'] = $_POST['username'];
					// $_SESSION['password'] = $_POST['password'];
					// $_SESSION['uid'] = $SearchFor;
					// $u = md5($SESSION_['uid']);
					// header("location:../index.php");
					// exit;
					// $h = true;
					// }
					// else if($h===false)
					// {
						$m=md5("invalid");
						header("location: ../invalidpage.php?m=$m");
						exit;	
					// }
				}	
			// }
		}
		
		function transferData()
		{
			
			$username = $_SESSION['username'];
			$sql = "select * from tblaccount where username='$username'";
			$result=mysql_query($sql) or die("Error in verifiying login".mysql_error());
			$num = mysql_num_rows($result);
			
				
			if($num!=1)
			{
				//for finding/transferring the user's information
				$cnx = $_SESSION['cnx']; 
				$rdn = "ou=thomasians,dc=ust,dc=edu,dc=ph";
				$filter = "(uid=$username)";
				$LDAPFieldsToFind = array("uid", "userPassword", "fn", "mi", "sn", "idn", "birthdate" ,"gender" ,"mail");
				$sr = ldap_search($cnx, $rdn, $filter, $LDAPFieldsToFind);
				$info = ldap_get_entries($cnx, $sr);
				$count = $info["count"];
				
				//for finding/transferring the user type
				$member = "uid=$username,ou=thomasians,dc=ust,dc=edu,dc=ph";
				$rdn2 = "ou=thomasianCommunity,dc=ust,dc=edu,dc=ph"; 
				$filter2 = "(&(member=$member)(!(ou=*)))";
				$LDAPFF = array("cn");
				$sr2 = ldap_search($cnx, $rdn2, $filter2, $LDAPFF);
				$get = ldap_get_entries($cnx, $sr2);
				
			
				
				for($i=0; $i<$info['count'];$i++)
				{
					for($j=0; $j<$get['count']; $j++)
					{
						$sem = "sem";
						$cn = $get[$j]['cn'][0];
						if(stripos($cn, $sem) === FALSE)
						{
						
						}
						else
						{
							$cn = "Student";
							break;
						}
					}
					$uid = $info[$i]['uid'][0];
					$userPassword = $_SESSION["password"];
					$fn = $info[$i]['fn'][0];
					$mi = $info[$i]['mi'][0];
					$sn = $info[$i]['sn'][0];
					$gender = $info[$i]['gender'][0];
					$idn = $info[$i]['idn'][0];
					$birthdate = $info[$i]['birthdate'][0];
					$mail = $info[$i]['mail'][0];
					$m = 2;
					$userPassword = md5($userPassword);
					
					$sql = "insert into tblaccount values ($idn, '$uid', '$userPassword', '$fn', '$mi', '$sn', '$mail', '$gender', '$birthdate', '$cn', $m
					)";
					$result=mysql_query($sql) or die("Error in transferring data: ".mysql_error());
					
					//echo "$uid $userPassword $fn $mi $sn $birthdate $gender $idn $mail $m";
					
				}
			}
			else
			{
				
			}
				
			
			
		
		}
		
		function control()
		{
			$sql="select * from tblimages";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$alt=$row["alt"];
					$status=$row["status"];
					if($type=='slide' && $status==1)
					{
						echo "<li><a href=\"#\"><img src=\"$address\" width=\"45\" height=\"30\" alt=\"$alt\"/></a></li>";
					}
				}			
		}
		
		function displayLogo()
		{
			$sql="select * from tblimages";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$alt=$row["alt"];
					if($type=='logo')
					{
						echo "<div><img src=\"$address\" width=\"100%\" height=\"100%\" alt=\"$alt\"></div>";
					}
				}	
		}
		
		function control_slides()
		{
			$sql="select * from tblimages where type='slide'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			echo "<table cellspacing=\"0px\" style=\"margin: 15px\" border=\"0\">";
			
			$btn=$_GET['editbtn'];
			$iid=$_GET['iid'];

			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$status=$row["status"];
					$id=$row["img_id"];
					$link=$row["link"];
					$name=$row["name"];
					$sql1="select * from tblcontent_admin where adpage_no='1'";
					$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
					while($row1=mysql_fetch_array($result1))
					{
						$getstatus=$row1["status"];
					}
					
					if($btn==1)
					{
						if($status==1&&$iid==$id)
						{
							echo "<tr height=\"28px\">
							<td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  
							<td style=\"width:150px\">
								<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
									<input name=\"padd\" value=\"$address\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
							</td>
							<td style=\"width:250px\">
								
									<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
							</td><td></td>";
							
							
							if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
							{
								echo "<td></td>
							<td style=\"width:50px\">
									<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0 auto\">
								</form>
							</td>
							
							<td style=\"width:75px; text-align: center\">
								<a href=\"template.php?pid=1&p=slide\">Cancel</a>
							</td>";
							}
						}
						
						else if($name=="No Image Selected")
						{
							if($id!=$iid)
							{
								echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  <td style=\"width:150px\">$name </td><td width=\"250px\">$link</td>";
									
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td style=\"width:75px; text-align: center\"></td>
									<td></td>
									<td></td>
									<td style=\"width:100px; text-align: center\">
										<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Add Image</a>
									</td>";
								}
							}
						
							else
							{
								echo "<tr height=\"28px\">
								<td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  
								<td style=\"width:150px\">
									<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
										<input name=\"padd\" value=\"\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
								</td>
								<td style=\"width:250px\">
									
										<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
								</td><td></td>";
								
								
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td></td>
								<td style=\"width:50px\">
										<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0 auto\">
									</form>
								</td>
								
								<td style=\"width:75px; text-align: center\">
									<a href=\"template.php?pid=1&p=slide\">Cancel</a>
								</td>";
								}
							}
						}
							
						
							
						else if($btn==1&&$status==0&&$iid==$id)
							{
								echo "<tr height=\"28px\">
								<td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  
								<td style=\"width:150px\">
									<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
										<input name=\"padd\" value=\"$address\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
								</td>
								<td style=\"width:250px\">
									<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
										<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\" autocomplete=\"off\">
								</td><td></td>";
								
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
								echo "<td></td>
								<td style=\"width:50px\">
										<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0 auto\">
									</form>
								</td>
								<td style=\"width:75px; text-align: center\">
									<a href=\"template.php?pid=1&p=slide\">Cancel</a>
								</td>";
								}
							}	

						else if($status==1&&$iid!=$id)
						{
							echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  <td style=\"width:150px\">$name </td><td width=\"250px\">$link</td>";
							
							if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
							{
								echo "<td style=\"width:75px; text-align: center\"></td>
								<td> 
									status:  <span style=\"color: green\">ON</span>
									<a href=\"changeStatus.php?iid=$id&stat=$status\" style=\"color: black text-decoration: underline\">OFF</a>
								</td>
								<td style=\"text-align: center; width: 50px\">
									<a href='delete.php?type=slide&iid=$id'>Delete</a>
								</td>
								<td style=\"width:100px; text-align: center\">
									<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Edit</a>
								</td>";
							}
						}
						
						else
						{
							echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td><td style=\"width:150px\">$name</td><td width=\"250px\">$link</td>";
							
							if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
							{
								echo "<td style=\"width:75px; text-align: center\"></td>
								<td> 
									status:  <a href=\"changeStatus.php?iid=$id&stat=$status\" style=\"color: black text-decoration: underline\">ON</a> 
									<span style=\"color: red\">OFF</span>
								</td>
								<td style=\"text-align: center; width: 50px\">
									<a href=delete.php?type=slide&iid=$id>Delete</a>
								</td>
								<td style=\"width:100px; text-align: center\">
									<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Edit</a>
								</td>";
							}
						}
					}
							
					else
					{
						if($status==1)
							{
								echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  <td style=\"width:150px\">$name </td><td width=\"250px\">$link</td>";
								
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td style=\"width:75px; text-align: center\"></td>
									<td> 
										status:  <span style=\"color: green\">ON</span> 
										<a href=\"changeStatus.php?iid=$id&stat=$status\" style=\"color: black text-decoration: underline\">OFF</a>
									</td>
									<td style=\"text-align: center; width: 50px\">
										<a href=delete.php?type=slide&iid=$id>Delete</a>
									</td>
									<td style=\"width:100px; text-align: center\">
										<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Edit</a>
									</td>";
								}
							}
							
							else if($name=="No Image Selected")
							{
								echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  <td style=\"width:150px\">$name </td><td width=\"250px\">$link</td>";
									
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td style=\"width:75px; text-align: center\"></td>
									<td></td>
									<td></td>
									<td style=\"width:100px; text-align: center\">
										<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Add Image</a>
									</td>";
								}
							}
							
							else
							
							{
								echo "<tr height=\"28px\"><td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td><td style=\"width:150px\">$name</td><td width=\"250px\">$link</td>";
								
								if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td style=\"width:75px; text-align: center\"></td>
									<td> 
										status:  <a href=\"changeStatus.php?iid=$id&stat=$status\" style=\"color: black text-decoration: underline\">ON</a> 
										<span style=\"color: red\">OFF</span>
									</td>
									<td style=\"text-align: center; width: 50px\">
										<a href=delete.php?type=slide&iid=$id>Delete</a>
									</td>
									<td style=\"width:100px; text-align: center\">
										<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Edit</a>
									</td>";
								}
							}
						
					}
				}
			echo "</table>";
		}
		
		function changeStatus()
		{
			$id=$_GET["iid"];
			$stat=$_GET["stat"];
			$count=$this->counter();
			$sql="select * from tblimages where type='slide' and img_id=$id";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
				while($row=mysql_fetch_array($result))
				{
					$img_id=$row["img_id"];
					$status=$row["status"];
					
					
			
					if($status==1&&$count>3)
					{
					$sql="update tblimages set status='0' where img_id='$id'";
					
					}
					
					else if($status==0)
					{
					$sql="update tblimages set status='1' where img_id='$id'";
					
					}
					
					else{
						return "ayaw";
					}
					
					$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
				}
		}
		
		function counter()
		{
			$sql="select * from tblimages where type='slide'";
			$count=0;
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$stat=$row["status"];
					
					if($stat==1)
					{
						$count++;
					}
				}
				
			return $count;
		}
		
		function upload()
		{			
			$type=$_GET["type"];
			
			
			if(isset($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name']<>"")
			{
				$typ = $_FILES['fileToUpload']['type'];
				if($typ == "image/gif" || $typ == "image/png" || $typ == "image/jpeg" || $typ == "image/pgif" || typ == "image/ppng" || $typ =="image/pjpeg")
				{						
				
					$uploaddir = "../uploads/";
					$uploadimages = $uploaddir.basename($_FILES['fileToUpload']['name']);
					if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadimages))
					{
						if($type==slide)
						{
							$sql="select * from tblimages where type='slide' ORDER BY img_id desc limit 1";
							$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
								
							while($row=mysql_fetch_array($result))
								{
									$last=$row["img_id"];
								}
								
							$cur=$last+1;
							
							$sql="insert into tblimages (address,type,img_id) values ('$uploadimages', '$type', $cur)";
							$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
							return "Slide_updated";
						}
						
						if($type==logo)
						{
							$sql="update tblimages set address='$uploadimages' where type='$type'";
							$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
							return "logo_update";
						}
						
						if($type==ad)
						{
							$id=$_GET["id"];
							$sql="update tblimages set address='$uploadimages' where type='$type' and img_id=$id";
							$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
							return "ad_update";
						}
					}
				}
			}
				
			else
			{
				if($type=="slide")
				{
					return "Slide_failed";
				}
						
				if($type=="logo")
				{
					return "logo_fail";
				}
				
				if($type=="ad")
				{
					return "ad_fail";
				}
			}
		}
		
		function delete()
		{
			$type=$_GET["type"];
			
			if($type=='slide')
			{
				$sql="select * from tblimages where type='slide'";
				$count=0;
				$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
				
				while($row=mysql_fetch_array($result))
					{
						$name=$row["name"];
						
						if($name!="No Image Selected")
						{
							$count++;
						}
					}
								
				if($count>3)
				{	
					$id=$_GET["iid"];
					$sql="update tblimages set address='../images/none.png', status='0', link='', name='No Image Selected' where img_id=$id";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					return "Image_done";
				}
				
				else
				{
					return "Image_failed";
				}
			}
			
			if($type=='single')
			{
				$sql="update tblimages set address='../images/none.png', status='1', link='', name='No Image Selected' where type='single'";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				return "Image_done";
			}
			
			if($type=='page')
			{
				
				$id=$_GET["pid"];
				if($id!=1)
					{$sql="delete from tblcontent where page_no=$id";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					$sql="delete from tblcontent_admin where adpage_no=$id";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					
					$sql1="select * from tblcontent where not page_no=1000 and not page_no=1001";
					$result1=mysql_query($sql1);
					while($row=mysql_fetch_array($result1))
					{
						$pid=$row["page_no"];
							if($pid>$id)
							{
								if($pid!=1000||$pid!=1001)
								{
									$temp=$pid-1;
									$sql="update tblcontent set page_no=$temp where page_no=$pid";
									$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
									$sql="update tblcontent_admin set adpage_no=$temp where adpage_no=$pid";
									$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
								}
							}
						
					}
					
					$sql="select pagevalue from tbladmin_privileges";
					$result=mysql_query($sql);
					$row=mysql_fetch_array($result);
					$priv=$row["pagevalue"];
					
					$i=1;
					$p=0;
					while(isset($priv[$i]))
					{
						if($i==$id)
							{
								$temp=$priv[$i];
								$priv[$i]=null;
								$priv[$p]=$temp;

							}
						$i++;
						$p++;
					}
					
					$sql="update tbladmin_privileges set pagevalue=$priv";
					$result=mysql_query($sql);
					
				}
				return "Page_deleted";
			}
			
			if($type=='user')
			{
				$un=$_GET['un'];
				$na=$_GET['na'];
				$sql="delete from tblaccount where username='$un'";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				if($na!=1)
				{
					return "User_deleted";
				}
				
				else
				{
					return "User_deleted1";
				}
			}
			
			if($type=='accessory')
			{
				$id=$_GET["id"];
				$sql="delete from tblaccessories where id=$id";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				
				return "Accessory_deleted";
			}
			
			if($type=='news')
			{
				$id=$_GET["id"];
				$sql="delete from tblnews where news_id=$id";
				$result=mysql_query($sql) or die("Error in deleting news: $sql".mysql_error());
				
				return "news_deleted";
			}
		}
		
		function changepassword($newpassword)
		{
			$username=$_SESSION["username"];
			$sql="update tblaccount set password='$newpassword' where username='$username'";
			$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
		}
		
		function title()
		{
			$sql="select * from tbltitle";
			$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
			while($row=mysql_fetch_array($result))
				{
					$title=$row["title"];
					$sub=$row["subtitle"];
					
					echo"<h1>$title</h1>";
					echo"<h4 id=\"subtitle\">$sub</h4>";
				}
		}
		
		function edit($name)
		{
			$type=$_GET["type"];
			
			if($type=="page")
			{
				$id=$_GET["pid"];
				$sql="update tblcontent set page_name='$name' where page_no=$id ";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				$sql="update tblcontent_admin set adpage_name='$name' where adpage_no=$id ";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				
				return "Page_edited";
			}
			
			else if($type=="title")
			{
				$id=$_GET["id"];
				
				if($id=="title")
				{
					$sql="update tbltitle set title='$name'";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					return "Title_edited";
				}
				
				else if($id=="sub")
				{
					$sql="update tbltitle set subtitle='$name'";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					return "Subtitle_edited";
				}
			}
			
			if($type=="link")
			{
				$add=$_POST["padd"];
				$id=$_GET["iid"];
				$t=$_GET["t"];
				
				if($add!="")
				{
					$sql="update tblimages set link='$name', address='$add', name='".basename($add)."' where img_id=$id ";
					$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
					if($t=='a')
					{
						return "Adlink_updated";
					}
					
					else if($t=='l')
					{
						return "logo_update";
					}
		
					else
					{
						return "Link_edited";
					}
				}
				
				else
				{
					return "no_name";
				}
				
			}
			
		}
		
		function addMenu($name)
		{
			
			$sql="select * from tblcontent where not page_no=1000 ORDER BY page_no desc limit 1";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
								
			while($row=mysql_fetch_array($result))
			{
				$page=$row["page_no"];
			}
			
			$cur=$page+1;
			
			if($name!=null)
			{
				$sql="insert into tblcontent (page_name, page_no) values ('$name', $cur)";
				$result=mysql_query($sql) or die("Error in adding pages: $sql".mysql_error());
				$sql="insert into tblcontent_admin (adpage_name, adpage_no) values ('$name', $cur)";
				$result=mysql_query($sql) or die("Error in adding pages: $sql".mysql_error());
				
				$sql="select pagevalue from tbladmin_privileges";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				$priv=$row["pagevalue"];
				$x=strlen($priv);
				$i=$x-1;
				$p=$x;
				$temp=$priv[$i];
				$priv[$i]=0;
				$priv[$p]=$temp;
				
				$sql="update tbladmin_privileges set pagevalue=$priv";
				$result=mysql_query($sql);
				
				return "Page_added";
			}
			
			else
			{
				return "no page";
			}
		}
		
		function checkLoginadmin()
		{
			$_SESSION["loginadminstatus"]="";
			$username=$_POST["username"];
			$password=$_POST["password"];
			$password=md5($password);
			
			$sql="select * from tblaccount where username='$username'and password='$password'";

			$result=mysql_query($sql) or die("Error in verifying login: ".mysql_error());
			
			$row=mysql_fetch_array($result);
			$num=mysql_num_rows($result);
			$check = $row["type"];
			if($num!=1 || ($check!=1 && $check!=0))
			{
				$m=md5("invalid");
				header("location: ../cpanelweb/index.php?m=$m");
				exit;
			}
			
			
			$_SESSION["loginadminstatus"]="true";
			
			$_SESSION["middlename"]=$row["middlename"];
			$_SESSION["firstname"]=$row["firstname"];
			$_SESSION["lastname"]=$row["lastname"];
			$_SESSION["password"]=$password;
			$_SESSION["email"]=$row["email"];
			$_SESSION["birthdate"]=$row["birthdate"];
			//$_SESSION["contactnum"]=$row["contactnum"];
			$_SESSION["username"]=$row["username"];
			$_SESSION["access"]=$row["type"];
			
		if($_SESSION['access']==1)
		{
			$user=$_SESSION["username"];
			$sql="select pagevalue from tbladmin_privileges where username='$user'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$priv=$row["pagevalue"];
			
			$sql1="select * from tblcontent_admin";
			$count=mysql_query($sql1);
			$c=0;
			while($row=mysql_fetch_array($count))
			{
				$a[$c]=$row["adpage_no"];
				
				if($a[$c]!=1001)
					{
						$p=$priv[$c];
						
						$sql2="update tblcontent_admin set status=$p where adpage_no=$a[$c]";
						$result=mysql_query($sql2);						
						$c++;
					}
					
				else
				{
					$sql2="update tblcontent_admin set status='' where adpage_no=$a[$c]";
						$result=mysql_query($sql2);
				}
			}
			
		}
			
			
			
			
			header("location:../cpanelweb/template.php?pid=1");
			exit;
		}
		
		function addAccessory()
		{
			$name=$_POST["name"];
			$content=$_POST["content"];
			
			$sql="select * from tblaccessories ORDER BY id desc limit 1";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
								
			while($row=mysql_fetch_array($result))
			{
				$last=$row["id"];
			}
								
			$cur=$last+1;
			
			$sql="insert into tblaccessories (name, content, id) values ('$name', '$content', $cur)";
			$result=mysql_query($sql) or die("Error in verifiying login".mysql_error());
			
			return 1;
		}
		
		function control_ad()
		{
			
			$btn=$_GET["btn"];
			$iid=$_GET["iid"];
			$sql="select * from tblimages where type='ad'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			echo "<table cellspacing=\"0px\" style=\"margin: 15px\" border=\"0\">";
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$id=$row["img_id"];
					$link=$row["link"];
						
					if($iid==$id)
					{
						if($btn==1)
						{
						
							echo "<tr height=\"28px\">
							<td><img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/></td>  
							<td style=\"width:150px\">
								<form method=\"post\" action=\"edit.php?iid=$id&type=link&t=a\">
								<input name=\"padd\" value=\"$address\" style=\"margin-left: 0px; width: 150px\" autocomplete=\"off\">
							</td>
							<td style=\"width:250px\">
								<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\" autocomplete=\"off\">
							</td>
							<td></td>
							<td style=\"width:100px\">
									<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin-left: 12px\">
								</form>
							</td>
							<td>
								<a href=\"template.php?pid=1&p=ad\">Cancel</a></td>
							</td>
							</tr>";
						}
					}
					
					else
					{
						$sql1="select * from tblcontent_admin where adpage_no='1'";
						$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
						while($row1=mysql_fetch_array($result1))
						{
							$getstatus=$row1["status"];
						}
						echo "<tr style=\"width:150px; height: 28px\">
						<td >
							<img src=\"../$address\" width=\"20\" height=\"15\"alt=\"$alt\"/>
						</td>
						<td style=\"width:150px\">".basename($address)."</td>
						<td width=\"250px\">$link</td>";
						
						if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
						{
							echo "<td style=\"width:75px; text-align: center\"></td><td><a href=template.php?pid=1&p=ad&iid=$id&type=ad&btn=1>Change Ad</a></td><td style=\"width:50px\"></td></tr>";
						}
					}
					
				}
			echo "</table>";
		}
		
		function Ads()
		{
			$sql="select * from tblimages where type='ad'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$id=$row["img_id"];
					$link=$row["link"];
					if($id==1000)
					{
						echo "<div class=\"add\" id=\"ad1\" onmouseover=\"moveleftx()\" onmouseout=\"moverightx()\"><a href=\"$link\"><img src=\"$address\" id=\"x\" width=\"600px\" height=\"150px\" style=\"position:relative;left:00px;\" /></a></div>";
					}
					
					else if($id==1001)
					{
						echo "<div class=\"add\" id=\"ad2\" onmouseover=\"movelefty()\" onmouseout=\"moverighty()\" ><a href=\"$link\"><img src=\"$address\" id=\"y\" width=\"600px\" height=\"150px\" alt=\"Fourth Image\" style=\"position:relative;left:00px;\"/></a></div>";
					}
					
					else if($id==1002)
					{
						echo "<div class=\"add\" id=\"ad3\" onmouseover=\"moveleftz()\" onmouseout=\"moverightz()\" ><a href=\"$link\"><img src=\"$address\" id=\"z\" width=\"600px\" height=\"150px\" alt=\"Fourth Image\" style=\"position:relative;left:00px;\"/></a></div>";
					}
				}			
		}
		
		function news()
		{
			$sql="select * from tblnews";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$link=$row["link"];
					$news=$row["news"];
					
					echo "<li><a href=\"$link\">$news</a></li>";
				}
		}
		
		function control_news()
		{
			$sql="select * from tblnews";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			$btn=$_GET["btn"];
			$nid=$_GET["nid"];
			echo "<table cellspacing=\"0px\" style=\"margin: 15px\" border=\"0\">";
			
			while($row=mysql_fetch_array($result))
				{
					$link=$row["link"];
					$news=$row["news"];
					$id=$row["news_id"];
					$sql1="select * from tblcontent_admin where adpage_no='1'";
					$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
					while($row1=mysql_fetch_array($result1))
					{
						$getstatus=$row1["status"];
					}
					if($btn==1&&$nid==$id)
					{
						echo "<tr>
						<td width=\"150px\" height=\"30px\">
						<form method=\"post\" action=\"editnews.php?nid=$id\">
						<input name=\"news\" value=\"$news\" style=\"margin-left: 0px; width: 250px; height: 13px\" autocomplete=\"off\">
						</td>
						
						<td width=\"140px\" height=\"20px\">
						<input name=\"link\" value=\"$link\" style=\"margin-left: 0px; width: 250px; height: 13px\" autocomplete=\"off\">
						</td>
						
						<td><input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0\"></form></td>
						<td width: 75px><a href=\"template.php?pid=1&p=news\">Cancel</a>
						</td>";
					}
					
					else
					{
						echo "<tr style=\" height: 30px\">
						<td width=\"250px\">$news</td>
						<td width=\"250px\">$link</td>";
						
						if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
						{
							echo "<td style=\"width:75px; text-align: left\"><a href=template.php?pid=1&p=news&nid=$id&btn=1>Edit</a></td>
							<td style=\"width:75px; text-align: left\"><a href=delete.php?type=news&id=$id>Delete</a></td>
							</tr>";
						}
					}
				}
		}
		
		function edit_news($news, $link)
		{
			$id=$_GET["nid"];
			$sql="update tblnews set news='$news', link='$link' where news_id=$id ";
			$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());

				
			return "news_edited";
		}
		
		function add_news($news, $link)
		{
			$id=$_GET["nid"];
			
			if($news!="")
			{
				$sql="insert into tblnews (news, link) values ('$news', '$link')";
				$result=mysql_query($sql) or die("Error in displaying title: $sql".mysql_error());
				return "news_added";
			}
			
			else
			{
				return "no news";
			}
		}
	
		function get_link($img_id)
		{
			$sql="select link from tblimages where img_id=\"$img_id\"";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			$row=mysql_fetch_Array($result);
			return $row["link"];
		}
		
		function accessories()
		{
			$sql="select * from tblaccessories";
			$count=1;
			$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
			$btn=$_GET["btn"];
			$aid=$_GET["id"];
			$range=20; //number of accessories to be displayed
			
			while($row=mysql_fetch_array($result))
			{
				$id=$row["id"];
				$name=$row["name"];
				$content=$row["content"];
				
				if($btn==null)
				{
					if($id%$range==1)
					{
						if($count%2!=0)
						{
							echo"<tr style=\"background: #EDDA74\" ><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php?btn=true&id=$id' style='text-decoration: none'>+</a></td><td> $name </td><td>$id</td>";
							
							$sql1="select * from tblcontent_admin where adpage_no='1000'";
							$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
							while($row1=mysql_fetch_array($result1))
							{
								$getstatus=$row1["status"];
							}
							if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
							{
							echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
							}
							else
							{
								echo "<td></td></tr>";
							}
						}
							
						else
						{
							echo"<tr style=\"background: #ADA96E\"><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php?btn=true&id=$id' style='text-decoration: none'>+</a></td><td> $name  </td><td>$id</td>";
							
							$sql1="select * from tblcontent_admin where adpage_no='1000'";
							$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
							while($row1=mysql_fetch_array($result1))
							{
								$getstatus=$row1["status"];
							}
							if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
							{
							echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
							}
							else
							{
								echo "<td></td></tr>";
							}
						}
						$count++;
					}
									
				}				
				else
				{
					if($aid==$id)
					{					
							if($count%2!=0)
							{
								echo"<tr style=\"background: #EDDA74\" ><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php' style='text-decoration: none'>-</a></td><td> $name </td><td>$id</td>";
								
								$sql1="select * from tblcontent_admin where adpage_no='1000'";
								$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
								while($row1=mysql_fetch_array($result1))
								{
									$getstatus=$row1["status"];
								}
								if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
								}
								else
								{
									echo "<td></td></tr>";
								}
							}
								
							else
							{
								echo"<tr style=\"background: #ADA96E\"><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php' style='text-decoration: none'>-</a></td><td> $name  </td><td>$id</td>";
								
									
								$sql1="select * from tblcontent_admin where adpage_no='1000'";
								$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
								while($row1=mysql_fetch_array($result1))
								{
									$getstatus=$row1["status"];
								}
								if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
								{
								echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
								}
								else
								{
									echo "<td></td></tr>";
								}
							}
							$count++;
					}	

					else
					{
						if($id%$range==1)
						{
							if($count%2!=0)
							{
								echo"<tr style=\"background: #EDDA74\" ><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php?btn=true&id=$id' style='text-decoration: none'>+</a></td><td> $name </td><td>$id</td><td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
							}
								
							else
							{
								echo"<tr style=\"background: #ADA96E\"><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"><a href='manage.php?btn=true&id=$id' style='text-decoration: none'>+</a></td><td> $name  </td><td>$id</td><td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> </td></tr>";
							}
							$count++;
						}	
						
						else if($aid<$id&&$id<($aid+$range))
						{
							if($count%2!=0)
							{
								echo"<tr style=\"background: #EDDA74\" ><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"></td><td> $name </td><td>$id</td>
								";
								
								
								$sql1="select * from tblcontent_admin where adpage_no='1000'";
								$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
								while($row1=mysql_fetch_array($result1))
								{
									$getstatus=$row1["status"];
								}
								if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> <a href=\"delete.php?id=$id&type=accessory\">Delete</a></td></tr>";
								}
								else
								{
									echo "<td></td></tr>";
								}
							}
								
							else
							{
								echo"<tr style=\"background: #ADA96E\"><td width=\"5px\" style=\"background: #FDEEF4; text-decoration: none;\"></td><td> $name  </td><td>$id</td>
								";
								
									$sql1="select * from tblcontent_admin where adpage_no='1000'";
									$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
									while($row1=mysql_fetch_array($result1))
									{
										$getstatus=$row1["status"];
									}
									if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
									{
										echo "<td> <a href=\"manageAccessory.php?id=$id&btn=1&type=access\">Edit</a> <a href=\"delete.php?id=$id&type=accessory\">Delete</a></td></tr>";
									}
									else
									{
										echo "<td></td></tr>";
									}
							}
							$count++;
						}
					}
				}
				
			}
		}
		
		function title_menu()
		{
			$ebtn=$_GET["editbtn"];
			$tid=$_GET["id"];
			$sql="select * from tbltitle";
			$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
			echo"<table cellspacing=\"0px\" style=\"margin-left: 20px; \">";
			
			while($row=mysql_fetch_array($result))
			{
				$title=$row["title"];
				$sub=$row["subtitle"];

					if($ebtn==1&&$tid=="title")
					{
						echo "<tr><td><strong>Title:</strong></td><td width=\"260px\" height=\"40px\"><form method=\"post\" action=\"edit.php?id=title&type=title\"><input name=\"pname\" value=\"$title\" style=\"margin-left: 0px; width: 240px\" autocomplete=\"off\"></td><td><input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin-left: -7px\"></form></td><td width=\"25px\"><a href=\"manage.php\">Cancel</a></td>";
						
						echo "<tr><td><strong>Sub-Title:</strong></td> <td width=\"260px\" height=\"40px\">$sub</td><td><a href=\"manage.php?id=sub&editbtn=1\">Edit</a></td><td width=\"30px\"></td>";
					}
					
					else if($ebtn==1&&$tid=="sub")
					{
						echo "<tr><td><strong>Title:</strong></td><td width=\"260px\" height=\"40px\">$title</td><td><a href=\"manage.php?id=title&editbtn=1\">Edit</a></td><td width=\"25px\"></td>";
						
						echo "<tr><td><strong>Sub-Title:</strong></td><td width=\"260px\" height=\"40px\"><form method=\"post\" action=\"edit.php?id=sub&type=title\"><input name=\"pname\" value=\"$sub\" style=\"margin-left: 0px; width: 240px\" autocomplete=\"off\"></td><td><input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin-left: -7px\"></form></td><td width=\"25px\"><a href=\"manage.php\">Cancel</a></td>";
					}
					
					else
					{
						echo "<tr> <td><strong>Title:</strong></td><td width=\"260px\" height=\"40px\">$title</td>";
						
						$sql1="select * from tblcontent_admin where adpage_no='1000'";
						$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
						while($row1=mysql_fetch_array($result1))
						{
							$getstatus=$row1["status"];
						}
						if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
						{
							echo "<td><a href=\"manage.php?id=title&editbtn=1\">Edit</a></td><td width=\"50px\"></td>";
						}
						
						echo "<tr><td><strong>Sub-Title:</strong></td> <td width=\"260px\" height=\"40px\">$sub</td>";
						
						if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
						{
							echo "<td><a href=\"manage.php?id=sub&editbtn=1\">Edit</a></td><td width=\"50px\"></td>";
						}
					}
			}
			
			if($m==null)
			{
				echo"<tr><td></td><td width=\"250px\" height=\"20px\" ></td>";
			}
			
			else{
				echo"<tr><td></td><td width=\"250px\" height=\"20px\" valign=\" top\">$mess2</td>";
			}
			echo "</table>";
		}
		
		function change_logo()
		{
			$b=$_GET["b"];
			$sql="select * from tblimages where type='logo'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
					
			while($row=mysql_fetch_array($result))
			{
				$address=$row["address"];
				$type=$row["type"];
				$alt=$row["alt"];

				echo "<tr><td><img src=\"../$address\" width=\"20px\" height=\"20px\" alt=\"$alt\"</td>";
				
				$sql1="select * from tblcontent_admin where adpage_no='1000'";
				$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
				
				while($row1=mysql_fetch_array($result1))
				{
					$getstatus=$row1["status"];
				}
				
				
				if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
				{
					if($b!=1)
					{
						echo "<td width=200px>".basename($address)."</td>";
						echo "<td><a href='manage.php?b=1'>Change</a></td>";
					}
					
					else
					{
						echo "<form enctype='multipart/form-data' method='post' action='edit.php?iid=0&type=link&t=l' style='padding-left: 18px'>";
						echo "<td width=200px><input name='padd' value='$address' style='margin-left: 0px; width: 200px' autocomplete='off'></td>";
						echo "<td><input type='submit' value='Save' id=\"submitEdit\"/></td>";
						echo "</form>";
						echo "<td><a href='manage.php'>Cancel</td>";
					}
				}
				
				else
				{
					echo "<td>".basename($address)."</td>";
				}
				echo "</tr>";
			}
		}
		
		function get_privileges($un, $getpriv, $getp)
		{
			$sql="update tbladmin_privileges set priv='$getpriv', pagevalue='$getp' where username='$un'";
			$result=mysql_query($sql) or die("Error in updating privileges:".mysql_error());
			
			return "Privileges successfully updated";
		}
		
		
		function edit_pages()
		{
			$ebtn=$_GET["editbtn"];
			$id=$_GET["pid"];
			$sql="select * from tblcontent order by page_no";
			$result=mysql_query($sql) or die("Error in listing menu:".mysql_error());
			echo"<table cellspacing=\"3\" style=\"margin-left: 20px\">";
						
			while($row=mysql_fetch_array($result))
				{
					$page_name=$row["page_name"];
					$link=$row["link"];
					$page=$row["page_no"];

					if($page!=1000)
					{
						if($ebtn==1&&$page==$id)
						{
						echo "<tr height=\"28px\"><td style=\"width:150px\"><form method=\"post\" action=\"edit.php?pid=$page&type=page\"><input name=\"pname\" value=\"$page_name\" style=\"margin-left: 0px; width: 150px\" autocomplete=\"off\"></td><td style=\"width:25px\"><input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin-left: -7px\"></form></td><td><a href=\"manage.php\">Cancel</a></td>";
						}
						else if($page==1)
						{
							echo "<tr height=\"28px\"><td width=\"160px\">$page_name</td>";
						}					
						else
						{
							echo "<tr height=\"28px\"><td width=\"160px\">$page_name</td>";
							
							$sql1="select * from tblcontent_admin where adpage_no='1000'";
							$result1=mysql_query($sql1) or die("Error in searching page: $sql1".mysql_error());
							while($row1=mysql_fetch_array($result1))
							{
								$getstatus=$row1["status"];
							}
							if($_SESSION['access']==0||($_SESSION['access']==1&&$getstatus==1))
								{
									echo "<td style=\"width:40px\"><a href=\"manage.php?pid=$page&editbtn=1\">Edit</a></td><td width=\"25px\"><a href=\"delete.php?pid=$page&type=page\">Delete</a></td>";
								}
							
						}
					}
					
				}
			echo "</table>";
		}
		
		
		function slidecontrol($type)
		{
			$status=$_GET["s"];
			if($status=="on")
			{
				$sql="update tblcontrol set status='on' where name='$type'";
				$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
			}
			
			else
			{
				$sql="update tblcontrol set status='off' where name='$type'";
				$result=mysql_query($sql) or die("Error in editing item: $sql".mysql_error());
			}
			
		}
		
		function status($type)
		{
			$sql="select status from tblcontrol where name='$type'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$stat=$row["status"];
				}
			return $stat;
		}
		
		function control_single_photo()
		{
			$btn=$_GET["editbtn"];
			$sql="select * from tblimages where type='single'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			echo "<table cellspacing=\"0px\" style=\"margin: 15px\" border=\"0\">";

			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$name=$row["name"];
					$link=$row["link"];
					$id=1003;
								
					if($btn==1&&$name!="No Image Selected")
					{
						echo "<tr height=\"28px\">
						<td>
							<img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/>
						</td>  
						<td style=\"width:150px\">
							<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
								<input name=\"padd\" value=\"$address\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
						</td>
						<td style=\"width:150px\">
								<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
						</td>
						<td style=\"width:50px\">
								<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0 auto\">
							</form>
						</td>
						<td style=\"width:75px; text-align: center\">
							<a href=\"template.php?pid=1&p=slide\">Cancel</a>
						</td>";
						
					}
					
					else if($btn==1&&$name=="No Image Selected")
					{
						echo "<tr height=\"28px\">
						<td>
							<img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/>
						</td>  
						<td style=\"width:150px\">
							<form method=\"post\" action=\"edit.php?iid=$id&type=link\">
								<input name=\"padd\" value=\"\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
						</td>
						<td style=\"width:150px\">
								<input name=\"pname\" value=\"$link\" style=\"margin-left: 0px; width: 150px\"autocomplete=\"off\">
						</td>
						<td style=\"width:50px\">
								<input type=\"submit\" value=\"Save\" id=\"submitEdit\" style=\"margin: 0 auto\">
							</form>
						</td>
						<td style=\"width:75px; text-align: center\">
							<a href=\"template.php?pid=1&p=slide\">Cancel</a>
						</td>";
						
					}
					
					else
					{
						echo "<tr height=\"28px\">
						<td>
							<img src=\"../$address\" width=\"20\" height=\"15\" alt=\"$alt\"/>
						</td>
						<td style=\"width:150px\">$name</td>
						<td style=\"width:150px\">$link</td>";
						
						if($_SESSION['access']==0  ||($_SESSION['access']==1&&$getstatus==1))
						{
							echo "<td style=\"text-align: center; width: 50px\">
								<a href=delete.php?type=single&iid=$id>Delete</a>
							</td>
							<td style=\"width:100px; text-align: center\">
								<a href=\"template.php?pid=1&editbtn=1&iid=$id&p=slide\">Edit</a>
							</td>";
						}
						
					}
						
					
				}
			echo "</table>";
		}
		function changeSinglePhotoStatus()
		{
			$iid=$_GET["iid"];
			$sql="select * from tblimages where type='slide'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
				while($row=mysql_fetch_array($result))
				{
					$id=$row["img_id"];
					
					if($id==$iid)
					{
						$sql2="update tblimages set alt='on' where img_id=$iid";
						$result2=mysql_query($sql2) or die("Error in editing item: $sql".mysql_error());
					}
					else
					{
						$sql3="update tblimages set alt='' where img_id=$id";
						$result3=mysql_query($sql3) or die("Error in editing item: $sql".mysql_error());
					}
				}
		}
		
		function singlePhoto()
		{
			$sql="select * from tblimages where type='single'";
			$result=mysql_query($sql) or die("Error in listing images:".mysql_error());
			
			while($row=mysql_fetch_array($result))
				{
					$address=$row["address"];
					$type=$row["type"];
					$alt=$row["alt"];
					$status=$row["status"];
					if($type=='single')
					{
						echo "<div><img src=\"$address\" width=\"937\" height=\"300\" alt=\"$alt\" /></div>";
					}
				}			
		}
		
		function changePass($email)
		{
			$email=$_POST["email"];
			$sql="select * from tblaccount where email='$email'";
			$result=mysql_query($sql) or die("Error in getting account info:".mysql_error());
			$count = mysql_num_rows($result);
			
			if($count!=1)
			{
				$m=md5('no match');
				header("location:forgot.php?m=$m");
				exit;
			}
			else
			{
				while($row=mysql_fetch_array($result))
				{
					$e=$row["email"];
					$name=$row["firstname"];
					
						$bday=$row["birthdate"];
						$new=md5($bday);
						$sql1="update tblaccount set password='$new' where email='$email'";
						$result1=mysql_query($sql1) or die("updating:".mysql_error());
						
						$header = "From: Me";
						$subject = "testing mail";
						$message = "Hello $name! \n\n\tYour password has been reset to your birthdate (YYYY-MM-DD). \n\te.g. \"1980-12-30\" \n\n\tLog in to your account to change your password. \n\tClick link to login: http://localhost/index.php?pid=1";
						
						ini_set("SMTP","172.17.1.12");
						ini_set("sendmail_from","ustojt@mnl.ust.edu.ph");
						mail($email,$subject,$message);
					
				}
			}
		}
		
	}
		
?>