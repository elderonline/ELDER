<?php
require_once('formdisplayhelperfunctions.php');
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
//If the user is already logged in...
if(isset($_SESSION['userName'])){
	//Inform the user that her session is in progress already and cease execution of the page.
	die("You're already logged in, ".$_SESSION['userName'].".");
}

if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		$link = connectToDB();
		process_login_form();
	}
	else{
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_login_form($errorMessage);
	}
}
else{
	// The form wasn't submitted, so display
	show_login_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";
?>