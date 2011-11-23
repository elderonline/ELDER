<?php
require_once('formdisplayhelperfunctions.php');
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
//If the user is already logged in...
if(isset($_SESSION['userName'])){
	//Log the user out.
	print "Logging you out, ".$_SESSION['userName'].".";
	unset($_SESSION['userName']);
}
else{
	print "You are not logged in!";
}
echo "</div>";
require_once('footer.php');
?>