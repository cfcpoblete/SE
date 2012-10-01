<?php 
		require_once("scripts/dbconnect.php");
		//require_once("scripts/ldapcon.php");
		$session = $_SESSION['username'];
		/*$new=new web_template;
		$new->transferData();*/
?>

<div id="login">
	<div id="choicebox"><a href="scripts/logoutprocess.php" class="choices">Logout</a></div>
		<div id="welcomeUser">Welcome <?php echo $session; ?></div>		
</div>