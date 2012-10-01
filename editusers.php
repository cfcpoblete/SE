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
	
	<div id="contentContainer">
	
			<table>	
				<?php
				$result = mysql_query("SELECT * FROM tblaccount");
				while($row = mysql_fetch_array($result))
				{
					echo '<tr><td>'. $row['idnumber'].'</td>';
					echo '<td>'. $row['username'].'</td>';
					echo '<td>'. $row['gender'].'</td>';
					echo '<td>'. $row['firstname'].'</td>';
					echo '<td>'. $row['lastname'].'</td>';
					echo '<td>'. $row['middlename'].'</td>';
					echo '<td>'. $row['birthdate'].'</td>';
					echo '<td>'. $row['usertype'].'</td>';
					echo '<td>'. $row['type'].'</td>';
					$edit = $row['username'];
					$edit = '?uname='.$edit;
					echo "<td><a href='edit.php$edit'>EDIT</a></td>";
					echo '</tr>';
				}
				?>
			</table>

</div>
