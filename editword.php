<script type='text/javascript'>
function editWordValidator(){
	return true;
}
</script>

<?php
session_start();
//Page for Editing of a Word
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

//load pre-existing data into globals for list presentation
$words = array_flip(getExistingWords());###!!!THIS DOES NOT ACCOUNT FOR WORDS WITH THE SAME DESCRIPTION.  FIX OR SUFFER!!!
$lexCats = array_flip(getExistingLexCats());
$morphoTypes = array_flip(getExistingMorphoTypes());
$semanticFields = array_flip(getExistingSemanticFields());
$tones = getExistingTones();
$wordID = mysql_real_escape_string($_POST['wordID']);
echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_editWord_form();
	}
	else{
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_addWord_form($errorMessage);
	}
		
}
else{
	// The form wasn't submitted, so display
	//First we must populate the values that will start off the fields
	initializeEditWordForm();
	checkPermissions($_POST['wordEnteredBy']);
	show_addWord_form("");
	printRelatedPhrases($_REQUEST['wordID']);
	if($_POST['wordRoot'] < 0){printWordsInClass($_REQUEST['wordID']);}
	else {printWordsInClass($_POST['wordRoot']);}
}
//###################################END MAIN LOGIC####################################
echo "</div>";
//cleanup
// Closing connection
mysql_close($link);
?>

