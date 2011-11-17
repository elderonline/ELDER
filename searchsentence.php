<script type='text/javascript'>
function searchSentenceValidator(){
	return true;
}
</script>

<?php
//Page for Searching of Sentences
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');


//load pre-existing data into globals for list presentation

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_GET['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_searchSentence_form();
	}
	else{
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_searchSentence_form($errorMessage);
	}
		
}
else{
	// The form wasn't submitted, so display
	show_searchSentence_form("");
}
//###################################END MAIN LOGIC####################################
echo "</div>";
