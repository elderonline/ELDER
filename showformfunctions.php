<?php
function show_addSentence_form($errorMessage, $doIndividualTones = false){
?>
<form method="POST" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return addSentenceValidator()'>

<table>
<tr><td>Spoken form:</td>
<td><?php input_text('sentenceSpokenForm', $_POST['sentenceSpokenForm']) ?></td></tr>
<tr><td>Analyzed form:</td>
<td><?php input_text('sentenceAnalyzedForm', $_POST['sentenceAnalyzedForm']) ?></td></tr>
<tr><td>Close Gloss:</td>
<td><?php input_text('sentenceCloseGloss', $_POST['sentenceCloseGloss']) ?></td></tr>
<tr><td>Additional notes:</td>
<td><?php input_text('sentenceDescription', escapeDubQuotes($_POST['sentenceDescription'])) ?></td></tr>
<tr><td>To-Do notes:</td>
<td><?php input_text('sentenceToDo', escapeDubQuotes($_POST['sentenceToDo'])) ?></td></tr>
<tr><td>Free translation:</td>
<td><?php input_text('sentenceFreeTranslation', $_POST['sentenceFreeTranslation']) ?></td></tr>
<tr><td>Analyzed Tone:</td>
<td><?php input_text('sentenceAnalyzedTone', $_POST['sentenceAnalyzedTone']) ?></td></tr>
<tr><td>Pitch:</td>
<td><?php input_text('sentencePitch', $_POST['sentencePitch']) ?></td></tr>
<tr><td>Sentence type:</td>
<td><?php input_select_reversed('sentenceType', $_POST['sentenceType'], $GLOBALS['types']); //BUG: When set to NONE, this does not repopulate correctly after rejected submission?></td></tr> 
</tr>
<table><tr><td>Entered By:</td>
<td><?php input_text_short('sentenceEnteredBy', whicheverIsSet($_POST['sentenceEnteredBy'], $_SESSION['userName'])) ?></td>
<td>Spoken By:</td>
<td><?php input_text_short('sentenceSpokenBy', $_POST['sentenceSpokenBy']) ?></td>
<td>Session:</td>
<td><?php input_text_short('sentenceSession', $_POST['sentenceSession']) ?></td></tr>
<tr><td>Audio File: </td>
<td><?php input_file('sentenceAudioFile', $_POST['sentenceAudioFile']) ?></td>
<td> Delete ALL Audio For This Sentence? <?php input_radiocheck('CHECKBOX', 'noAudio','noAudio','noAudio');?> </td></tr>
<tr><td colspan="2" align="center"><?php input_submit('sentenceAdd','Add Sentence'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>
<?php input_hidden('sentenceInsertID', $_POST['sentenceInsertID']); ?>

</form>
<?php 
print $errorMessage;
}

function show_addSentence_form2($errorMessage = ""){ 
//NOTE: This guy really needs $_POST['sentenceSpokenForm'] set to work, because of the call to updateSelectBoxes().
	updateSelectBoxes();
print "<h3>\"".$_POST['sentenceAnalyzedForm']."\"</h3>"; ?>
<BR>
<form method="POST" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>">

<table>
<tr><td>Keyword:</td><td>Current Association:</td><td>Possible Matches:</td></tr>
<tr><td><?php input_select('keyWord', $_POST['keyWord'], $_POST['keyWords'], 20 ) ?></td>
<td valign="top"><?php printWordsInSentenceSkipBlanks($_POST['sentenceInsertID']); ?></td>
<td><?php input_select('possibleMatch', $_POST['possibleMatch'], $_POST['possibleMatches'], 20) ?></td></tr>

<tr><td align="center"><?php input_submit('autoNew','Autogenerate New'); ?>
</td>
<td align="center"><?php input_submit('manualNew','Create New'); ?>
</td>
<td align="center"><?php input_submit('assocExisting','Associate Selected'); ?>
</td>
<td align="center"><?php input_submit('disassociate','Clear Selected Keyword\'s Association'); ?>
</td>
<td align="center"><?php input_submit('freeAssociate','Associate With Other'); ?>
</td></tr>
<tr><td> <?php print "<a href=\"/viewsentence.php?sentenceID=".$_POST['sentenceInsertID']."\">View Sentence</a>"; ?> </td></tr>
</table>

<?php 	input_hidden("_submit_check", 1);
		input_hidden("sentenceSpokenForm", $_POST['sentenceSpokenForm']);
		input_hidden("sentenceCloseGloss", $_POST['sentenceCloseGloss']);
		input_hidden("sentenceDescription", $_POST['sentenceDescription']);
		input_hidden("sentenceFreeTranslation", $_POST['sentenceFreeTranslation']);
		input_hidden("sentenceInsertID", $_POST['sentenceInsertID']);
		input_hidden("sentenceAnalyzedForm", $_POST['sentenceAnalyzedForm']);
		input_hidden("sentenceType", $_POST['sentenceType']);	?>

</form>

<?php
}
function show_searchWord_form($errorMessage, $additionalHiddenInputs = array()){
	//load pre-existing data into globals for list presentation
	$lexCats = array_flip(getExistingLexCats());
	$words = array_flip(getExistingWords());
	$morphoTypes = array_flip(getExistingMorphoTypes());
	$semanticFields = array_flip(getExistingSemanticFields());
	$users = getAllPersons();
?>

<form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return searchWordValidator()'>

<table>
<tr><td>Written form:</td>
<td><?php input_text('wordWrittenForm', $_GET['wordWrittenForm']) ?></td></tr>
<tr><td>Description:</td>
<td><?php input_text('wordDescription', $_GET['wordDescription']) ?></td></tr>
<tr><td>CEPOM Orthography:</td>
<td><?php input_text('wordEtymology', $_GET['wordEtymology']) ?></td></tr>
<tr><td>Headword:</td>
<td><?php input_select('wordRoot', array("wordRoot" => setInitialDropdownValue('wordRoot')), $words);?></td></tr>
<tr><td>Grammatical category:</td>
<td><?php input_select('wordLexCat', array("wordLexCat" => setInitialDropdownValue('wordLexCat')), $lexCats); //BUG: This does not repopulate correctly after rejected submission?></td></tr> 
<tr><td>Morphological Category:</td>
<td><?php input_select('wordMorphoCat', array("wordMorphoCat" => setInitialDropdownValue('wordMorphoCat')), $morphoTypes); //BUG: This does not repopulate correctly after rejected submission?></td></tr> 
<tr><td>Semantic Field:</td>
<td><?php input_select('wordSemanticField', array("wordSemanticField" => setInitialDropdownValue('wordSemanticField')), $semanticFields); //BUG: This does not repopulate correctly after rejected submission?></td></tr> 
<tr><td>Entered By:</td>
<td><?php input_select('wordEnteredBy', array('wordEnteredBy' => setInitialDropdownValue('wordEnteredBy')), $users);?></td></tr> 
</tr>
<tr><td>Autogenerated?:</td>
<td><?php input_radiocheck('checkbox', 'wordAutoGenerated', array("wordAutoGenerated" => 1), $_GET['wordAutoGenerated']); ?></td></tr>
</tr>
<tr><td colspan="2" align="center"><?php input_submit('wordSearch','Search for Words'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>
<?php 	$i = 0; 
		foreach($additionalHiddenInputs as $key => $value){
			input_hidden($key, $value);
			$i++;
		} ?>

</form>
<?php 
print $errorMessage;
}

function show_searchSentence_form($errorMessage){
	$users = getAllPersons();
	$types = array_flip(getExistingSentenceTypes());
?>

<form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return searchSentenceValidator()'>

<table>
<tr><td>Spoken form:</td>
<td><?php input_text('sentenceSpokenForm', $_GET['sentenceSpokenForm']) ?></td></tr>
<tr><td>Close Gloss:</td>
<td><?php input_text('sentenceCloseGloss', $_GET['sentenceCloseGloss']) ?></td></tr>
<tr><td>Additional notes:</td>
<td><?php input_text('sentenceDescription', $_GET['sentenceDescription']) ?></td></tr>
<tr><td>Analyzed Form:</td>
<td><?php input_text('sentenceAnalyzedForm', $_GET['sentenceAnalyzedForm']) ?></td></tr>
<tr><td>Free translation:</td>
<td><?php input_text('sentenceFreeTranslation', $_GET['sentenceFreeTranslation']) ?></td></tr>
<tr><td>Sentence type:</td>
<td><?php input_select('sentenceType', array('sentenceType' => setInitialDropdownValue('sentenceType')), $types); //BUG: When set to NONE, this does not repopulate correctly after rejected submission?></td></tr> 
</tr>
<tr><td>Entered By:</td>
<td><?php input_select('sentenceEnteredBy', array('sentenceEnteredBy' => setInitialDropdownValue('sentenceEnteredBy')), $users); ?></td></tr> 
</tr>
<tr><td colspan="2" align="center"><?php input_submit('sentenceSearch','Search for Sentences'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php 
print $errorMessage;
}

function show_addWord_form($errorMessage){
?>

<form method="POST" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return editWordValidator()'>

<table>
<tr><td>IPA:</td>
<td><?php input_text('wordWrittenForm', $_POST['wordWrittenForm']) ?></td></tr>
<tr><td>Gloss:</td>
<td><?php input_text('wordDescription', $_POST['wordDescription']) ?></td></tr>
<tr><td>CEPOM Orthography:</td>
<td><?php input_text('wordEtymology', $_POST['wordEtymology']) ?></td></tr>
<tr><td>Head word:</td>
<td><?php input_select('wordRoot', array("wordRoot" => $_POST['wordRoot']), $GLOBALS['words']);?></td></tr>
<tr><td>Lexical category:</td>
<td><?php input_select('wordLexCat', array("wordLexCat" => $_POST['wordLexCat']), $GLOBALS['lexCats']); //BUG: This does not repopulate correctly after rejected submission?></td></tr> 
<tr><td>To-Do:</td>
<td><?php input_text('wordToDo', escapeDubQuotes($_POST['wordToDo'])) ?></td></tr>
<tr><td>Underlying Tone:</td>
<td><?php input_text('wordAnalyzedTone', $_POST['wordAnalyzedTone']) ?></td></tr>
<tr><td>Morphological Type:</td>
<td><?php input_select('wordMorphologicalType', array("wordMorphologicalType" => $_POST['wordMorphologicalType']), $GLOBALS['morphoTypes']); ?></td></tr>
<tr><td>Semantic Field:</td>
<td><?php input_select('wordSemanticField', array("wordSemanticField" => $_POST['wordSemanticField']), $GLOBALS['semanticFields']); ?></td></tr>
<tr><td>Additional Notes:</td>
<td><?php input_text('wordNotes', escapeDubQuotes($_POST['wordNotes'])) ?></td></tr>
<table><tr><td>Entered By:</td>
<td><?php input_text_short('wordEnteredBy', whicheverIsSet($_POST['wordEnteredBy'], $_SESSION['userName'])) ?></td>
<td>Spoken By:</td>
<td><?php input_text_short('wordSpokenBy', $_POST['wordSpokenBy']) ?></td>
<td>Session:</td>
<td><?php input_text_short('wordSession', $_POST['wordSession']) ?></td></tr>
<tr><td>Audio File: </td>
<td><?php input_file('wordAudioFile', $_POST['wordAudioFile']) ?></td>
<td> Delete ALL Audio For This Word? <?php input_radiocheck('CHECKBOX', 'noAudio','noAudio','noAudio');?> </td></tr>
<tr></tr>
</table>
<table>
<tr><td></td><td>S1</td><td>S2</td><td>S3</td><td>S4</td><td>S5</td></tr>
<tr><td>Syllable:</td><td><?php input_text_short('wordS0Description', $_POST['wordS0Description']) ?></td>
<td><?php input_text_short('wordS1Description', $_POST['wordS1Description']) ?></td>
<td><?php input_text_short('wordS2Description', $_POST['wordS2Description']) ?></td>
<td><?php input_text_short('wordS3Description', $_POST['wordS3Description']) ?></td>
<td><?php input_text_short('wordS4Description', $_POST['wordS4Description']) ?></td></tr>
<tr><td>Syllable Type:</td><td><?php input_text_short('wordS0Type', $_POST['wordS0Type']) ?></td>
<td><?php input_text_short('wordS1Type', $_POST['wordS1Type']) ?></td>
<td><?php input_text_short('wordS2Type', $_POST['wordS2Type']) ?></td>
<td><?php input_text_short('wordS3Type', $_POST['wordS3Type']) ?></td>
<td><?php input_text_short('wordS4Type', $_POST['wordS4Type']) ?></td></tr>
<tr><td>Spoken Form:</td><td><?php input_text_short('wordS0SpokenForm', $_POST['wordS0SpokenForm']) ?></td>
<td><?php input_text_short('wordS1SpokenForm', $_POST['wordS1SpokenForm']) ?></td>
<td><?php input_text_short('wordS2SpokenForm', $_POST['wordS2SpokenForm']) ?></td>
<td><?php input_text_short('wordS3SpokenForm', $_POST['wordS3SpokenForm']) ?></td>
<td><?php input_text_short('wordS4SpokenForm', $_POST['wordS4SpokenForm']) ?></td></tr>
<tr><td>Pitches(comma-seperated):</td><td><?php input_text_short('wordS0Tone', $_POST['wordS0Tone']) ?></td>
<td><?php input_text_short('wordS1Tone', $_POST['wordS1Tone']) ?></td>
<td><?php input_text_short('wordS2Tone', $_POST['wordS2Tone']) ?></td>
<td><?php input_text_short('wordS3Tone', $_POST['wordS3Tone']) ?></td>
<td><?php input_text_short('wordS4Tone', $_POST['wordS4Tone']) ?></td></tr>
<tr><td></td><td>S6</td><td>S7</td><td>S8</td><td>S9</td><td>S10</td></tr>
<tr><td>Syllable:</td><td><?php input_text_short('wordS5Description', $_POST['wordS5Description']) ?></td>
<td><?php input_text_short('wordS6Description', $_POST['wordS6Description']) ?></td>
<td><?php input_text_short('wordS7Description', $_POST['wordS7Description']) ?></td>
<td><?php input_text_short('wordS8Description', $_POST['wordS8Description']) ?></td>
<td><?php input_text_short('wordS9Description', $_POST['wordS9Description']) ?></td></tr>
<tr><td>Syllable Type:</td><td><?php input_text_short('wordS5Type', $_POST['wordS5Type']) ?></td>
<td><?php input_text_short('wordS6Type', $_POST['wordS6Type']) ?></td>
<td><?php input_text_short('wordS7Type', $_POST['wordS7Type']) ?></td>
<td><?php input_text_short('wordS8Type', $_POST['wordS8Type']) ?></td>
<td><?php input_text_short('wordS9Type', $_POST['wordS9Type']) ?></td></tr>
<tr><td>Spoken Form:</td><td><?php input_text_short('wordS5SpokenForm', $_POST['wordS5SpokenForm']) ?></td>
<td><?php input_text_short('wordS6SpokenForm', $_POST['wordS6SpokenForm']) ?></td>
<td><?php input_text_short('wordS7SpokenForm', $_POST['wordS7SpokenForm']) ?></td>
<td><?php input_text_short('wordS8SpokenForm', $_POST['wordS8SpokenForm']) ?></td>
<td><?php input_text_short('wordS9SpokenForm', $_POST['wordS9SpokenForm']) ?></td></tr>
<tr><td>Pitches(comma-seperated):</td><td><?php input_text_short('wordS5Tone', $_POST['wordS5Tone']) ?></td>
<td><?php input_text_short('wordS6Tone', $_POST['wordS6Tone']) ?></td>
<td><?php input_text_short('wordS7Tone', $_POST['wordS7Tone']) ?></td>
<td><?php input_text_short('wordS8Tone', $_POST['wordS8Tone']) ?></td>
<td><?php input_text_short('wordS9Tone', $_POST['wordS9Tone']) ?></td></tr>

<tr><td colspan="2" align="center"><?php input_submit('wordEdit','Submit'); ?>
</td></tr>
</table>

<?php 	input_hidden("_submit_check", 1);//todo, analyzed tone, morpho type, semantic field, syllabledesc, syllableIPA, syllable tones, doneyay
		input_hidden("wordID", $_REQUEST['wordID']);
		input_hidden("wordSyllableIDs", serialize($_POST['wordSyllableIDs']));
?>

</form>
<?php
print $errorMessage;
}

function show_uploadMiscellany_form($errorMessage){
?>
<form method="POST" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<tr><td>File To Upload: </td>
<td><?php input_file('miscellaneousFile', $_POST['miscellaneousFile']) ?></td></tr>
<tr><td><?php input_submit('fileUpload','Upload') ?></td></tr>
</table>
<?php input_hidden("_submit_check", 1); ?>
</form>
<?php
print $errorMessage;
print '<BR>';
print 'OR: ';
print '<a href="miscellany/">View All Misc. Files</a>&nbsp;&nbsp;&nbsp;<a href="audio/">View All Audio Files</a>';
}

function show_login_form($errorMessage){
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<tr><td>Username: </td>
<td><?php input_text_short('userName', $_POST['userName']) ?></td></tr>
<tr><td>Password: </td>
<td><?php input_text_short('passWord', $_POST['passWord']) ?></td></tr>
<tr><td><?php input_submit('userLogin','Log In') ?></td><td>Or do you need to <a href="/register.php">register</a>?</td></tr>
</table>
<?php input_hidden("_submit_check", 1); ?>
</form>
<?php
print $errorMessage;
}

function show_registration_form($errorMessage){
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<tr><td>Username: </td>
<td><?php input_select('userName', $_POST['userName'], $GLOBALS['unregisteredUsers']) ?></td><td><a href="/faq.php#register">Why isn't my name in this list?</a></td></tr>
<tr><td>Desired Password: </td>
<td><?php input_text_short('passWord', $_POST['passWord']) ?></td></tr>
<tr><td>Repeat Password: </td>
<td><?php input_text_short('repeatPassWord', $_POST['repeatPassWord']) ?></td></tr>
<tr><td><?php input_submit('userRegistration','Register') ?></td></tr>
</table>
<?php input_hidden("_submit_check", 1); ?>
</form>
<?php
print $errorMessage;
}

function initializeEditWordForm(){
		//let's begin with a query for the simple query of the Word table
		$wordEditDiscoveryQuery = "SELECT wordWrittenForm, etymology, wordDescription, rootID, notes, toDoNotes, lexicalCategoryID, analyzedTone, enteredBy, spokenBy, session, morphologicalTypeID FROM word WHERE word.wordID=".mysql_real_escape_string($_REQUEST['wordID']); 
		$discoveryResult = mysql_query($wordEditDiscoveryQuery) or die('Query failed: ' . mysql_error() . "QUERY STRING: " . $wordEditDiscoveryQuery);
		$discoveryRow = mysql_fetch_array($discoveryResult, MYSQL_BOTH);
		$_POST['wordWrittenForm'] = $discoveryRow['wordWrittenForm'];
		$_POST['wordEtymology'] = $discoveryRow['etymology'];
		$_POST['wordDescription'] = $discoveryRow['wordDescription'];
		$_POST['wordLexCat'] = $discoveryRow['lexicalCategoryID'];
		$_POST['wordRoot'] = $discoveryRow['rootID'];
		$_POST['wordToDo'] = $discoveryRow['toDoNotes'];
		$_POST['wordAnalyzedTone'] = $discoveryRow['analyzedTone'];
		$_POST['wordMorphologicalType'] = $discoveryRow['morphologicalTypeID'];
		$_POST['wordNotes'] = $discoveryRow['notes'];
		$_POST['wordSession'] = $discoveryRow['session'];
		$_POST['wordEnteredBy'] = getPersonHandle($discoveryRow['enteredBy']);
		$_POST['wordSpokenBy'] = getPersonHandle($discoveryRow['spokenBy']);
		
		$_POST['wordSemanticField'] = array_shift(array_flip(getWordSemanticFields($_REQUEST['wordID'])));
		
		//now we move on to a query joining word with word_syllable, syllabletype, and syllable, to find what syllables are in the word
		$wordEditDiscoveryQuery = "SELECT syllableDescription, syllableTypeDescription, syllable.syllableID, syllableSpokenForm, syllableSequenceNumber FROM syllable, word_syllable, syllabletype WHERE word_syllable.syllableID=syllable.syllableID AND syllabletype.syllableTypeID=syllable.syllableTypeID AND word_syllable.wordID=" . $_REQUEST['wordID'];
		$discoveryResult = mysql_query($wordEditDiscoveryQuery) or die('Query failed: ' . mysql_error() . "QUERY STRING: " . $wordEditDiscoveryQuery);
		while($discoveryRow = mysql_fetch_array($discoveryResult, MYSQL_BOTH)){
			$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Description'] = $discoveryRow['syllableDescription'];
			$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Type'] = $discoveryRow['syllableType'];
			$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'SpokenForm'] = $discoveryRow['syllableSpokenForm'];
			$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Type'] = $discoveryRow['syllableTypeDescription'];
			$_POST['wordSyllableIDs'][$discoveryRow['syllableSequenceNumber']] = $discoveryRow['syllableID'];
			//now we join syllable_tone and tone to find and parse properly the tones for each syllable
				$wordEditDiscoverySubQuery = "SELECT toneRepresentation, toneSequenceNumber FROM tone, syllable_tone WHERE tone.toneID=syllable_tone.toneID AND syllable_tone.syllableID=".$discoveryRow['syllableID']. " ORDER BY toneSequenceNumber";
				$discoverySubResult = mysql_query($wordEditDiscoverySubQuery) or die('Query failed: ' . mysql_error() . "QUERY STRING: " . $wordEditDiscoverySubQuery);
				while($discoverySubRow = mysql_fetch_array($discoverySubResult, MYSQL_BOTH)){
					if(strcmp("", $_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Tone']) != 0) {$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Tone'] .= ',';}
					$_POST['wordS'.$discoveryRow['syllableSequenceNumber'].'Tone'] .= $discoverySubRow['toneRepresentation'];
				}
		}
}

function initializeEditSentenceForm(){//INCOMPLETE!!!!!
	$sentenceEditDiscoveryQuery = "SELECT spokenForm, closeGloss, sentenceDescription, freeTranslation, analyzedForm, enteredBy, spokenBy, session, toDoNotes, sentenceTypeID FROM sentence WHERE sentenceID=".mysql_real_escape_string($_REQUEST['sentenceID']); 
	$discoveryResult = mysql_query($sentenceEditDiscoveryQuery) or die('Query failed: ' . mysql_error());
	$discoveryRow = mysql_fetch_array($discoveryResult, MYSQL_BOTH);
	$_POST['sentenceSpokenForm'] = $discoveryRow['spokenForm'];
	$_POST['sentenceCloseGloss'] = $discoveryRow['closeGloss'];
	$_POST['sentenceDescription'] = $discoveryRow['sentenceDescription'];
	$_POST['sentenceFreeTranslation'] = $discoveryRow['freeTranslation'];
	$_POST['sentenceType'] = $discoveryRow['sentenceTypeID'];
	$_POST['sentenceAnalyzedForm'] = $discoveryRow['analyzedForm'];
	$_POST['sentenceSession'] = $discoveryRow['session'];
	$_POST['sentenceToDo'] = $discoveryRow['toDoNotes'];
	$_POST['sentenceAnalyzedTone'] = generateToneString($_REQUEST['sentenceID']);
	$_POST['sentencePitch'] = generatePitchString($_REQUEST['sentenceID']);
	$_POST['sentenceEnteredBy'] = getPersonHandle($discoveryRow['enteredBy']);
	$_POST['sentenceSpokenBy'] = getPersonHandle($discoveryRow['spokenBy']);
}

function show_manageWordSemanticField_form($wordSemanticFields){ 
?>
<BR>
<form method="POST" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>">

<table>
<tr><td>Semantic Fields:</td><td></td><td>Fields For This Word:</td></tr>
<tr><td><?php input_select('semanticField', $_POST['semanticField'], $GLOBALS['semanticFields'], 20 ) ?></td>
<td valign="top"></td>
<td><?php input_select('wordSemanticField', $_POST['wordSemanticField'], $wordSemanticFields, 20) ?></td></tr>
<tr>
<td align="center"><?php input_submit('assocExisting','Add'); ?>
</td><td></td>
<td align="center"><?php input_submit('removeSelected','Remove'); ?>
</td>
<td><?php echo "<a href=\"/viewword.php?wordID=" . $_REQUEST['wordID'] . "\">Back To Word</a>"; ?>
</td></tr>
</table>

<?php 	input_hidden("_submit_check", 1);
		input_hidden("wordID", $_REQUEST['wordID']);?>

</form>

<?php
}


function show_manageSimpleData_form($dataSetToManage){
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">

<table>
<tr><td>Current Values:</td></tr>
<tr><td><?php input_select('dataSelection', $_POST['dataSelection'], $dataSetToManage, 20) ?></td></tr>
<tr><td><?php input_text('dataEntry', '') ?></td></tr>
<tr><td>Note: Enter text above, THEN use Create or Modify buttons!  Box will eventually populate with selection to make modification easier. </td></tr>
<tr>
<td align="center"><?php input_submit('addNew','Create New'); ?>
</td>
<td align="center"><?php input_submit('editExisting','Modify Selected'); ?>
</td>
<td align="center"><?php input_submit('deleteExisting','Delete Selected'); ?>
</td>
</tr>
</table>

<?php 	input_hidden("_submit_check", 1); ?>

</form>
<?php
}

function show_manageSeeAlso_form($seeAlsos){
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">

<table>
<tr><td>Current Values:</td></tr>
<tr><td><?php input_select('seeAlsoList', $_POST['seeAlsoList'], $seeAlsos, 20) ?></td></tr>
<tr>
<td align="center"><?php input_submit('addNew','Add New'); ?>
</td>
<td align="center"><?php input_submit('deleteExisting','Delete Selected'); ?>
</td>
<td align="center"><?php input_submit('refresh','Refresh List'); ?>
</td>
</tr>
<td><?php echo "<a href=\"/viewword.php?wordID=" . $_REQUEST['wordID'] . "\">Back To Word</a>"; ?>
</td>
</table>

<?php 	input_hidden("_submit_check", 1); ?>
<?php 	input_hidden("wordID", $_REQUEST['wordID']); ?>

</form>
<?php
}

function printWordSyllableData($syllableData){
	echo "<table>\n";
	echo "\t<tr><td></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr>\n";
	echo "\t<tr><td><b>Syllable:</b></td>";
	$i = 0;
	while($i < 5){
	echo "<td align=\"center\">".$syllableData[$i]['Description']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Type:</b></td>";
	$i = 0;
	while($i < 5){
	echo "<td align=\"center\">".$syllableData[$i]['Type']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Spoken Form:</b></td>";
	$i = 0;
	while($i < 5){
	echo "<td align=\"center\">".$syllableData[$i]['SpokenForm']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Pitches:</b></td>";
	$i = 0;
	while($i < 5){
	echo "<td align=\"center\">".$syllableData[$i]['Tone']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	/////////////////////////////////////
	
		echo "\t<tr><td></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr>\n";
	echo "\t<tr><td><b>Syllable:</b></td>";
	$i = 5;
	while($i < 10){
	echo "<td align=\"center\">".$syllableData[$i]['Description']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Type:</b></td>";
	$i = 5;
	while($i < 10){
	echo "<td align=\"center\">".$syllableData[$i]['Type']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Spoken Form:</b></td>";
	$i = 5;
	while($i < 10){
	echo "<td align=\"center\">".$syllableData[$i]['SpokenForm']."</td>";
	$i++;
	}
	echo "</tr>\n";
	
	echo "\t<tr><td><b>Pitches:</b></td>";
	$i = 5;
	while($i < 10){
	echo "<td align=\"center\">".$syllableData[$i]['Tone']."</td>";
	$i++;
	}
	echo "</tr>\n";
	echo "</table>\n";
}

?>