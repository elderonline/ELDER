<?php
session_start();
//Page for Managing A Word's See Also Words
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
$seeAlsos = array_flip(getSeeAlsoWords($_REQUEST['wordID']));

//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_manageSeeAlso_form();
		$seeAlsos = array_flip(getSeeAlsoWords($_REQUEST['wordID']));
		show_manageSeeAlso_form($seeAlsos);
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_manageSeeAlso_form($seeAlsos);
	}
		
}
else{
	// The form wasn't submitted, so display
	show_manageSeeAlso_form($seeAlsos);
}
//###################################END MAIN LOGIC####################################
echo "</div>";
require_once('footer.php');
?>