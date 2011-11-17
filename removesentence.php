<script type='text/javascript'>
function removeWordValidator(){
	return confirm("Truly delete this word?");
}
</script>

<?php
//Page for Deletion of a Sentence from the Database
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
$sentenceID = $_REQUEST['sentenceID'];
$hiddensToUse = ""; //placeholder for when further functionality is implemented
checkPermissions(getPersonHandle(getEnteredBy($sentenceID, "sentence")));
if(isset($_REQUEST['sentenceID']) && strcmp($sentenceID, '') != 0){
	echo "<h1>Delete a Sentence</h1>";
	deleteFromTable("sentence_word", $sentenceID, "sentenceID");	//cut any strings to the sentence
	deleteFromTable("sentence_tone", $sentenceID, "sentenceID");
	deleteFromTable("sentence_pitch", $sentenceID, "sentenceID");
	deleteFromTable2Param("audioFile", array("linguisticObjectID" => $sentenceID, "linguisticObjectTypeID" => getLinguisticObjectTypeID("sentence")));
	deleteFromTable("sentence", $sentenceID, "sentenceID");
	
	print "Sentence successfully deleted.";
}
//NOTHING BELOW THIS POINT SHOULD BE USED (USABLE?) YET
else if ($_REQUEST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
			process_searchSentence_form("REMOVE");
	}
	else{
	echo "<h1>Search for a sentence to delete</h1>";
		$_REQUEST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_searchSentence_form($errorMessage, $hiddensToUse);
	}	
}
else{
	echo "<h1>Search for a word to delete</h1>";
	// The form wasn't submitted, so display
	show_searchSentence_form("", $hiddensToUse);
}
//###################################END MAIN LOGIC####################################
echo "</div>";
