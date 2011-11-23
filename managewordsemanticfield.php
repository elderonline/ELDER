<?php
session_start();
//Page for Managing A Word's See Also Words
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
echo "<h1>Manage Semantic Field list fot a Word</h1>";
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
$semanticFields = array_flip(getExistingSemanticFields());
$wordSemanticFields = getWordSemanticFields($_REQUEST['wordID']);

//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_manageWordSemanticField_form();
		$wordSemanticFields = getWordSemanticFields($_REQUEST['wordID']);
		show_manageWordSemanticField_form($wordSemanticFields);
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_manageWordSemanticField_form($wordSemanticFields);
	}
		
}
else{
	// The form wasn't submitted, so display
	show_manageWordSemanticField_form($wordSemanticFields);
}
//###################################END MAIN LOGIC####################################
echo "</div>";
require_once('footer.php');
?>