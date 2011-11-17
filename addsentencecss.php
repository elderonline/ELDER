<script type='text/javascript'>
function addSentenceValidator(){
	return true;
}
</script>

<?php
//Page for Entry of a Sentence
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');


//load pre-existing data into globals for list presentation
$words = getExistingWords();###!!!THIS DOES NOT ACCOUNT FOR WORDS WITH THE SAME DESCRIPTION.  FIX OR SUFFER!!!
$types = getExistingSentenceTypes();
echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		if(isset($_POST['sentenceAdd'])){
			process_addSentence_form();
		}
		else{
			process_addSentence_form2();
		}
		show_addSentence_form2("");
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_addSentence_form($errorMessage);
	}
		
}
else{
	// The form wasn't submitted, so display
	show_addSentence_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";
