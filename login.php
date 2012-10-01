<script>
function asd()
{
	var x= document.getElementById("username");
	if (x.value == "" || x.value == null)
	{
		alert("Username required");
		x.focus();	
		return;
	}
	x= document.getElementById("password");
	if (x.value == "" || x.value == null)
	{
		alert("Password required");
		x.focus();	
		return;
	}
	var form= document.getElementById('form3');
	form.submit();
}
</script>
<div id="login">	
	<form id="form3" method="post" action="scripts/loginverify.php">
		<table>
			<tr>
				<td>
					<div class="label">USERNAME</div>
				</td>
				<td width="120">
					<div class="input">
						<input type="text" name="username" id="username"autocomplete="off" style="width:150px"/>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="label">PASSWORD</div>
				</td>
				<td width="120">
					<div class="input">
						<input type="password" name="password" id="password" autocomplete="off" style="width:150px"/>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td width="120">	
					<div id="buttons">
						<div id="login_button">
							<a href="javascript:void(0);" onclick="asd();">Log In</a>
						</div>
						<div id="register_button">
							<a href="register.php">Register</a>		
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td width="120">
					<div id="forgot">
						<a  href="forgot.php">Forgot Password</a>
					</div>
				</td>
			</tr>
		</table>
	</form>						
</div>