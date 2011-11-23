<script type='text/javascript'>
function searchWordValidator(){
	return true;
}
</script>

<?php
//Page for Association of a Position Within a Sentence with a Given Word
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
$hiddensToUse = array("sentenceID" => $_REQUEST['sentenceID'], "wordSequenceNumber" => $_REQUEST['wordSequenceNumber']);
	//we will pass $hiddensToUse into the search word form as hidden inputs so that we don't lose that data when we come back here

if(isset($_REQUEST['wordID'])){
	associateWordWithSentence($_REQUEST['sentenceID'], $_REQUEST['wordID'], $_REQUEST['wordSequenceNumber'], "Association successful.");
}
else if ($_REQUEST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		echo "<h1>Click a word to associate with this sentence</h1>";
		//process the submitted data
			process_searchWord_form("ASSOCIATE");
	}
	else{
	echo "<h1>Search for a word to associate with this sentence</h1>";
		$_REQUEST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_searchWord_form($errorMessage, $hiddensToUse);
	}	
}
else{
	echo "<h1>Search for a word to associate with this sentence</h1>";
	// The form wasn't submitted, so display
	show_searchWord_form("", $hiddensToUse);
}
//###################################END MAIN LOGIC####################################
echo "</div>";
require_once('footer.php');
?>
