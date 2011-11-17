<script type='text/javascript'>
function removeWordValidator(){
	return confirm("Truly delete this word?");
}
</script>

<?php
//Page for Deletion of a Word
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
$wordID = $_REQUEST['wordID'];
$hiddensToUse = ""; //placeholder for when further functionality is implemented
checkPermissions(getPersonHandle(getEnteredBy($wordID, "word")));
if(isset($_REQUEST['wordID']) && strcmp($wordID, '') != 0){
	echo "<h1>Delete a Word</h1>";
	deleteFromTable("word_syllable", $wordID, "wordID");	//cut any strings to the word from the right side
	deleteFromTable("sentence_word", $wordID, "wordID");	//cut any strings to the word from the left side
	deleteFromTable2Param("word_semanticfield", array("wordID" => $wordID));
	deleteFromTable2Param("audioFile", array("linguisticObjectID" => $wordID, "linguisticObjectTypeID" => getLinguisticObjectTypeID("word")));
	deleteFromTable("word", $wordID, "wordID");
	
	print "Word successfully deleted.";
}
//NOTHING BELOW THIS POINT SHOULD BE USED (USABLE?) YET
else if ($_REQUEST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
			process_searchWord_form("REMOVE");
	}
	else{
	echo "<h1>Search for a word to delete</h1>";
		$_REQUEST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_searchWord_form($errorMessage, $hiddensToUse);
	}	
}
else{
	echo "<h1>Search for a word to delete</h1>";
	// The form wasn't submitted, so display
	show_searchWord_form("", $hiddensToUse);
}
//###################################END MAIN LOGIC####################################
echo "</div>";
