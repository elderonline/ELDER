<script type='text/javascript'>
function addWordValidator(){
	return true;
}
</script>

<?php
session_start();
//Page for Adding a Word
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

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_addWord_form();
	}
	else{
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_addWord_form($errorMessage);
	}
		
}
else{
	// The form wasn't submitted, so display
	//First we must populate the values that will start off the fields
	$_POST['wordRoot'] = -1;
	show_addWord_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";
//cleanup
// Closing connection
mysql_close($link);
?>

