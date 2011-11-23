<?php
require_once('formdisplayhelperfunctions.php');
echo "<h1>Register a Username and Password</h1>";
require_once ('titletop.php');
require_once ('navheaderside.php');

$link = connectToDB();
$unregisteredUsers = getUnregisteredUsers();
echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
//If the user is already logged in...
if(isset($_SESSION['userName'])){
	//Inform the user that her session is in progress already and cease execution of the page.
	die("You're already logged in, ".$_SESSION['userName'].".");
}

if ($_POST['_submit_check']){
	//We now validate that the two entered passwords are the same and not blank; if there's a problem we show the form again instead of processing it
	if(strcmp($_POST['passWord'], $_POST['repeatPassWord']) == 0 && strcmp($_POST['passWord'], "") != 0){
		//process the submitted data
		process_registration_form();
	}
	else{
		$errorMessage = "Your password and confirmation differ, or you didn't enter a password.  Please recheck and resubmit.";
		show_registration_form($errorMessage);
	}
}
else{
	// The form wasn't submitted, so display
	show_registration_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";
require_once('footer.php');
?>