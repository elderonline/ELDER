<script type='text/javascript'>
function editSentenceValidator(){
	return true;
}
</script>

<?php
//Page for Editing of a Sentence
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

//load pre-existing data into globals for list presentation
$words = getExistingWords();###!!!THIS DOES NOT ACCOUNT FOR WORDS WITH THE SAME DESCRIPTION.  FIX OR SUFFER!!!
$types = getExistingSentenceTypes();
$sentenceID = $_REQUEST['sentenceID'];

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		if(isset($_POST['sentenceAdd'])){
			process_editSentence_form();
		}
		else{
			process_addSentence_form2();
		}
		show_addSentence_form2("");
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_addSentence_form($errorMessage, true);
	}
		
}
else{
	// The form wasn't submitted, so display
	initializeEditSentenceForm();
	checkPermissions($_POST['sentenceEnteredBy']);
	$_POST['sentenceInsertID'] = $_REQUEST['sentenceID'];
	show_addSentence_form("", true);	//basically the same as addSentenceForm; only difference so far is tone boxes vs. single tone box
}
//###################################END MAIN LOGIC####################################
echo "</div>";