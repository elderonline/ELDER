<?php
session_start();
//Page for Managing A Word's See Also Words
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
echo "<h1>Upload Unassociated File</h1>";
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_uploadMiscellany_form();
		redirectInNewWindow("miscellany/");
		show_uploadMiscellany_form("");
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_uploadMiscellany_form($errorMessage);
	}
		
}
else{
	// The form wasn't submitted, so display
	show_uploadMiscellany_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";


