<?php 
//globals
header("Content-type: text/html; charset=utf-8");
$baseurl = "";
//additional includes
require_once('showformfunctions.php');
require_once('processformfunctions.php');

//print a text box
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print html_entity_decode($values, ENT_NOQUOTES) . '" style="width:600px">';
}
function input_text_short($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print html_entity_decode($values, ENT_NOQUOTES) . '">';
}
//print a text box that isn't modifiable by the user
function input_readonly_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print html_entity_decode($values[$element_name], ENT_NOQUOTES) . '" readonly>';
}
//print a submit button
function input_submit($element_name, $label) {
    print '<input type="submit" name="' . $element_name .'"id="'.$element_name.'" value="';
    print htmlentities($label, ENT_NOQUOTES, 'UTF-8') .'"/>';
}
//print a textarea
function input_textarea($element_name, $values) {
    print '<textarea name="' . $element_name .'"id="'.$element_name.'">';
    print html_entity_decode($values[$element_name], ENT_NOQUOTES) . '</textarea>';
}
function input_file($element_name, $values){
    print '<input type="file" name="'.$element_name.'"id="'.$element_name.'" value="';
    print html_entity_decode($values, ENT_NOQUOTES) . '">';
}
//print a hidden value
function input_hidden($element_name, $value){
	print '<input type="hidden" name="'.$element_name.'" value="'.htmlentities($value, ENT_NOQUOTES, 'UTF-8').'">';
}
	
//print a radio button or checkbox
function input_radiocheck($type, $element_name, $values, $element_value) {
    print '<input type="' . $type . '" name="' . $element_name .'"id="'.$element_name.'" value="' . $element_value . '" ';
    if ($element_value == $values[$element_name]) {
        print ' checked="checked"';
    }
    print '/>';
}
//print a <select> menu
function input_select($element_name, $selected, $options, $size=1, $multiple = false) {
    // print out the <select> tag
    print '<select size=' .$size. ' name="' . $element_name.'"id="'.$element_name;
    // if multiple choices are permitted, add the multiple attribute
    // and add a [  ] to the end of the tag name
    if ($multiple) { print '[  ]" multiple="multiple'; }
    print '">';
    // set up the list of things to be selected
    $selected_options = array( );
    if ($multiple) {
        foreach ($selected[$element_name] as $val) {
            $selected_options[$val] = true;
        }
    } else {
        $selected_options[ $selected[$element_name] ] = true;
    }
    // print out the <option> tags
    foreach ($options as $option => $label){
        print '<option value="' . htmlentities($option, ENT_NOQUOTES, 'UTF-8') . '"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . html_entity_decode($label, ENT_NOQUOTES) . '</option>';
    }
    print '</select>';
}
function input_select_reversed($element_name, $selected, $options, $size=1, $multiple = false) {
    // print out the <select> tag
    print '<select name="' . $element_name.'"id="'.$element_name;
    // if multiple choices are permitted, add the multiple attribute
    // and add a [  ] to the end of the tag name
    if ($multiple) { print '[  ]" multiple="multiple'; }
    print '">';
    // set up the list of things to be selected
    $selected_options = array( );
    if ($multiple) {
        foreach ($selected[$element_name] as $val) {
            $selected_options[$val] = true;
        }
    } else {
        $selected_options[ $selected[$element_name] ] = true;
    }
    // print out the <option> tags
    foreach ($options as $label => $option) {
        print '<option value="' . htmlentities($option, ENT_NOQUOTES, 'UTF-8') . '" label="'.htmlentities($label, ENT_NOQUOTES, 'UTF-8') .'"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . html_entity_decode($label, ENT_NOQUOTES) . '</option>';
    }
    print '</select>';
}
function escapeDubQuotes($string){
	return preg_replace('#"#', '&quot;', $string);
}

//get existing words so root selection is possible
function getExistingWords(){
	$words = array();
	$result=mysql_query("SELECT wordID, wordWrittenForm FROM word") 
		or die('Query failed: ' . mysql_error());
	while($word = mysql_fetch_array($result, MYSQL_NUM)){
		$words[$word[1]] = $word[0];
	}
	$words["None"] = -1;
	$words["Any"] = -2;
	mysql_free_result($result);
return $words;
}
//get list of existing lexical categories
function getExistingLexCats(){
$result=mysql_query("SELECT lexicalCategoryID, lexicalCategoryDescription FROM lexicalCategory") 
	or die('Query failed: ' . mysql_error());
while($lexcat = mysql_fetch_array($result, MYSQL_NUM)){
	$lexCats[$lexcat[1]] = $lexcat[0];
}
	$lexCats["None"] = -1;
	$lexCats["Any"] = -2;
mysql_free_result($result);
return $lexCats;
}
//get list of existing functional categories
function getExistingFuncCats(){
$result=mysql_query("SELECT functionalCategoryDescription, functionalCategoryID FROM functionalCategory") 
	or die('Query failed: ' . mysql_error());
while($funccat = mysql_fetch_array($result, MYSQL_NUM)){
	$funcCats[$funccat[0]] = $funccat[1];
}
	$funcCats['None'] = -1;
	$funcCats['Any'] = -2;
mysql_free_result($result);
return $funcCats;
}
function getExistingPhones(){
	$result=mysql_query("SELECT decimalCode, phoneID FROM phone") 
		or die('Query failed: ' . mysql_error());
	while($phone = mysql_fetch_array($result, MYSQL_NUM)){
		$phones["&#".$phone[0].";"] = $phone[1];
	}
	$phones['Any'] = -2;
	mysql_free_result($result);
	return $phones;
}
function getExistingSentenceTypes(){
	$types=array();
	$result=mysql_query("SELECT sentenceTypeID, sentenceTypeDescription FROM sentenceType") 
		or die('Query failed: ' . mysql_error());
	while($type = mysql_fetch_array($result, MYSQL_NUM)){
		$types[$type[1]] = $type[0];
	}
	$types["None"] = -1;
	$types["Any"] = -2;
	mysql_free_result($result);
	return $types;
}

function getExistingMorphoTypes(){
	$types=array();
	$result=mysql_query("SELECT morphologicalTypeID, morphologicalTypeDescription FROM morphologicaltype") 
		or die('Query failed: ' . mysql_error());
	while($type = mysql_fetch_array($result, MYSQL_NUM)){
		$types[$type[1]] = $type[0];
	}
	$types["None"] = -1;
	$types["Any"] = -2;
	mysql_free_result($result);
	return $types;
}

function getExistingSemanticFields(){
	$types=array();
	$result=mysql_query("SELECT semanticFieldID, semanticFieldDescription FROM semanticField") 
		or die('Query failed: ' . mysql_error());
	while($type = mysql_fetch_array($result, MYSQL_NUM)){
		$types[$type[1]] = $type[0];
	}
	$types["None"] = -1;
	$types["Any"] = -2;
	mysql_free_result($result);
	return $types;
}

function getExistingTones(){
	$tones=array();
	$result=mysql_query("SELECT toneID, toneRepresentation FROM tone") 
		or die('Query failed: ' . mysql_error());
	while($tone = mysql_fetch_array($result, MYSQL_NUM)){
		$tones[$tone[1]] = $tone[0];
	}
	mysql_free_result($result);
	return $tones;
}

function addNewSyllable($syllableNo, $toneReps){
	$i = 0;
	
	$syllableInsertQuery = "INSERT INTO syllable (syllableDescription, syllableSpokenForm, syllableTypeID) VALUES('" . 
		mysql_real_escape_string($_POST['wordS'.$syllableNo.'Description']) . "', '" . 
		mysql_real_escape_string($_POST['wordS'.$syllableNo.'SpokenForm']) . "', " .
		getSyllableTypeID(mysql_real_escape_string($_POST['wordS'.$syllableNo.'Type'])) . ")";
	if(!$syllableInsertResult = mysql_query($syllableInsertQuery)){echo ('Query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();}
	$newSyllableID =  array_shift(mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()")));
	while(isSet($toneReps[$syllableNo][$i])){
		if(strcmp($toneReps[$syllableNo][$i], "") != 0){
			$toneInsertQuery = "INSERT INTO syllable_tone (syllableID, toneID, toneSequenceNumber) VALUES(" . 
				$newSyllableID . ", " . 
				getToneID($toneReps[$syllableNo][$i]) . ", " . 
				$i . ")";
			if(!$toneInsertResult = mysql_query($toneInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $toneInsertQuery); mysql_query("ROLLBACK"); die();}
		}
		$i++;
	}
	return $newSyllableID;
}

function addNewSyllableType($syllableTypeDescription){
	$syllableTypeInsertQuery = "INSERT INTO syllableType (syllableTypeDescription) VALUES('" . 
		$syllableTypeDescription . "')";
	if(!$syllableTypeInsertResult = mysql_query($syllableTypeInsertQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $syllableTypeInsertQuery; mysql_query("ROLLBACK"); die();}
	return array_shift(mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()")));
}

function getSyllableTypeID($syllableTypeDescription){
	$syllableTypeDiscoveryQuery = "SELECT syllableTypeID FROM syllableType WHERE syllableTypeDescription LIKE '" . 
		$syllableTypeDescription . "'";
	if(!$syllableTypeDiscoveryResult = mysql_query($syllableTypeDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $syllableTypeDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	if(mysql_num_rows($syllableTypeDiscoveryResult) < 1){
		return addNewSyllableType($syllableTypeDescription);
	}
	else{
		return array_shift(mysql_fetch_array($syllableTypeDiscoveryResult));
	}
}

function printRelatedPhrases($wordID){
	$sentenceSpokenFormDiscoveryQuery = "SELECT spokenForm, sentence.sentenceID FROM sentence, sentence_word WHERE sentence_word.sentenceID = sentence.sentenceID AND sentence_word.wordID = " .
		$wordID;
	if(!$sentenceSpokenFormDiscoveryResult = mysql_query($sentenceSpokenFormDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $sentenceSpokenFormDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	print "RELATED PHRASES:";
	print '<HR>';
	while($sentenceSpokenFormDiscoveryRow = mysql_fetch_array($sentenceSpokenFormDiscoveryResult)){
		print "<a href=\"".$GLOBALS['baseurl']."/viewsentence.php?sentenceID=".$sentenceSpokenFormDiscoveryRow['sentenceID']."\">".$sentenceSpokenFormDiscoveryRow['spokenForm']."</a>";
		print '<BR>';
	}
	print '<HR>';
}

function printAudioFiles($audioFileID){
	if($audioFileID > 0){
	$audioFileDiscoveryQuery = "SELECT audioFile.audioFilePath, audioFile.audioFileName, audioFileFormat.audioFileFormatExtension FROM audioFile, audioFileFormat WHERE audioFileFormat.audioFileFormatID = audioFile.audioFileFormatID AND audioFileID = " .
		$audioFileID;
	if(!$audioFileDiscoveryResult = mysql_query($audioFileDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $audioFileDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	print "AUDIO FILES:";
	print '<HR>';
	while($audioFileDiscoveryRow = mysql_fetch_array($audioFileDiscoveryResult)){
		print "<a href=\"".$GLOBALS['baseurl']."/".$audioFileDiscoveryRow['audioFilePath'].$audioFileDiscoveryRow['audioFileName'].".".$audioFileDiscoveryRow['audioFileFormatExtension']."\">Audio</a>";
		print '<BR>';
	}
	print '<HR>';
	}
}

function printWordsInClass($headWordID){
	if($headWordID < 0){
		return;
	}
	$wordWrittenFormDiscoveryQuery = "SELECT wordWrittenForm, wordID FROM word WHERE rootID = " . 
		$headWordID . " OR wordID = " . 
		$headWordID;
	if(!$wordWrittenFormDiscoveryResult = mysql_query($wordWrittenFormDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $wordWrittenFormDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	print "WORDS WITH SAME HEADWORD:";
	print '<HR>';
	while($wordWrittenFormDiscoveryRow = mysql_fetch_array($wordWrittenFormDiscoveryResult)){
		print "<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$wordWrittenFormDiscoveryRow['wordID']."\">".$wordWrittenFormDiscoveryRow['wordWrittenForm']."</a>";
		print '<BR>';
	}
	print '<HR>';
}

function printLinkToWord($wordID){
	$wordWrittenFormDiscoveryQuery = "SELECT wordWrittenForm FROM word WHERE wordID = " . mysql_real_escape_string($wordID);
	if(!$wordWrittenFormDiscoveryResult = mysql_query($wordWrittenFormDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $wordWrittenFormDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	$wordWrittenFormDiscoveryRow = mysql_fetch_array($wordWrittenFormDiscoveryResult);
	return "<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=" . $wordID . "\">" . $wordWrittenFormDiscoveryRow['wordWrittenForm'] . "</a>";
}

function printWordsInSentenceSkipBlanks($sentenceID){
//primarily for use with sentence_word association
	$sentenceWordDiscoveryQuery = "SELECT word.wordID, wordWrittenForm, wordSequenceNumber FROM sentence_word, word WHERE sentenceID = " . $sentenceID .
		" AND sentence_word.wordID = word.wordID ORDER BY wordSequenceNumber";
	if(!$sentenceWordDiscoveryResult = mysql_query($sentenceWordDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $sentenceWordDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	$wordSeqNoCounter = 0;
	while($sentenceWordDiscoveryRow = mysql_fetch_array($sentenceWordDiscoveryResult)){
		while($wordSeqNoCounter != $sentenceWordDiscoveryRow['wordSequenceNumber']){
			print '<BR>';
			$wordSeqNoCounter++;
		}
		print "<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$sentenceWordDiscoveryRow['wordID']."\">".$sentenceWordDiscoveryRow['wordWrittenForm']."</a>";
		print '<BR>';
		$wordSeqNoCounter++;
	}
}

function printWordsInSentence($sentenceID){
//print all words associated with a sentence in a nice human-readable format
	$sentenceWordDiscoveryQuery = "SELECT word.wordID, wordWrittenForm FROM sentence_word, word WHERE sentenceID = " . $sentenceID .
		" AND sentence_word.wordID = word.wordID ORDER BY wordSequenceNumber";
	if(!$sentenceWordDiscoveryResult = mysql_query($sentenceWordDiscoveryQuery)){echo ('Query failed: ' . mysql_error()) . "QUERY TEXT: " . $sentenceWordDiscoveryQuery; mysql_query("ROLLBACK"); die();}
	print "DICTIONARY ENTRIES APPEARING IN THIS SENTENCE:";
	print '<HR>';
	while($sentenceWordDiscoveryRow = mysql_fetch_array($sentenceWordDiscoveryResult)){
		print "<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$sentenceWordDiscoveryRow['wordID']."\">".$sentenceWordDiscoveryRow['wordWrittenForm']."</a>";
		print '<BR>';
	}
	print '<HR>';
}

function redirectToPage($target){
	print "<script language=\"javascript\">location.href='".$target."'</script>";
}
function redirectInNewWindow($target){
	print "<script language=\"javascript\">window.open('".$target."');</script>";
}

function insertAutoGenWord(){
if(isset($_POST['keyWord'])){	//we could probably do better than this for validation
			//we must insert an autogen word (bare minimum info) since this word appears not to exist yet
			$wordInsertQuery = "INSERT INTO word (wordWrittenForm, rootID, lexicalCategoryID) VALUES('".
			mysql_real_escape_string($_POST['keyWords'][$_POST['keyWord']])."',-1,-1)";
			if(!$result = mysql_query($wordInsertQuery)){ echo ('Query failed: ' . mysql_error()) . "Query Text: " . $wordInsertQuery; mysql_query("ROLLBACK");die();}
			$idToInsert = mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()"));
			$sentence_wordInsertQuery = "INSERT INTO sentence_word (sentenceID, wordID, wordSequenceNumber) VALUES (".
				$_POST['sentenceInsertID'].",".
				$idToInsert[0].",".
				mysql_real_escape_string($_POST['keyWord']).")";
			if(!$result = mysql_query($sentence_wordInsertQuery)){echo ('Query failed: ' . mysql_error()); mysql_query("ROLLBACK");die();} 

		}
return $idToInsert[0];
}

function insertAutoGenAudioFile(){
	$audioFileDiscoveryQuery = "SELECT audioFileID FROM audioFile WHERE audioFileName LIKE '' AND audioFilePath LIKE ''";
	if(!$discoveryResult = mysql_query($audioFileDiscoveryQuery)){ echo ('Query failed: ' . mysql_error()) . "Query Text: " . $audioFileDiscoveryQuery; mysql_query("ROLLBACK");die();}
	if(mysql_num_rows($discoveryResult) > 0){
		$preExistingAudioFile = mysql_fetch_array($discoveryResult);
		return $preExistingAudioFile['audioFileID'];
	}

	//we must insert an autogen audio file (bare minimum info) since none appears to exist yet
	$audioFileInsertQuery = "INSERT INTO audioFile (audioFileName, audioFilePath, audioFileFormatID) VALUES('', '', default)";
	if(!$result = mysql_query($audioFileInsertQuery)){ echo ('Query failed: ' . mysql_error()) . "Query Text: " . $audioFileInsertQuery; mysql_query("ROLLBACK");die();}
	$idInserted = mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()"));
	return $idInserted[0];
}

function updateAudioFile($audioFileID, $fileName = '', $fileExt = 'mp3', $filePath = 'audio/'){
	//first we must discover whether this audio file is a new format
	$audioFileFormatDiscoveryQuery = "SELECT audioFileFormatID FROM audioFileFormat WHERE audioFileFormatExtension = '" . $fileExt . "'";
	if(!$audioFileFormatDiscoveryResult = mysql_query($audioFileFormatDiscoveryQuery)){ echo ('Query failed: ' . mysql_error()) . "Query Text: " . $audioFileFormatDiscoveryQuery; mysql_query("ROLLBACK");die();}
	if(mysql_num_rows($audioFileFormatDiscoveryResult) > 0){
		$audioFileFormatDiscoveryRow = mysql_fetch_array($audioFileFormatDiscoveryResult);
		$audioFileFormatID = $audioFileFormatDiscoveryRow['audioFileFormatID'];
	}
	else{
		$audioFileFormatID = insertIntoTable("audioFileFormat", array("audioFileFormatExtension" => "'".$fileExt."'"));
	}
	//Now, we see whether or not this audio file is already extant in the table somewhere
	$audioFileDiscoveryQuery = "SELECT audioFileID FROM audioFile WHERE audioFileName = '" . 
		$fileName . "' AND audioFilePath = '" . 
		$filePath . "' AND audioFileFormatID = " . 
		$audioFileFormatID;
	if(!$audioFileDiscoveryResult = mysql_query($audioFileDiscoveryQuery)){ echo ('Query failed: ' . mysql_error()) . "Query Text: " . $audioFileDiscoveryQuery; mysql_query("ROLLBACK");die();}
	if(mysql_num_rows($audioFileDiscoveryResult) > 0){
	//If it is extant, we must delete it! Otherwise we'll get a uniqueness constraint failure when we update our autogen.
		$audioFileDiscoveryRow = mysql_fetch_array($audioFileDiscoveryResult);
		deleteFromTable("audioFile", $audioFileDiscoveryRow['audioFileID'], "audioFileID");
	}
	//Next, update the audio file with the new info
	$audioFileUpdateQuery = "UPDATE audioFile SET audioFileName = '" .
		mysql_real_escape_string($fileName) . "', audioFilePath = '" .
		mysql_real_escape_string($filePath) . "', audioFileFormatID = " .
		$audioFileFormatID . " WHERE audioFileID = " . 
		mysql_real_escape_string($audioFileID);
	if(!$audioFileUpdateResult = mysql_query($audioFileUpdateQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $audioFileUpdateQuery); mysql_query("ROLLBACK");die();} 
}

function updateSelectBoxes(){
	//this means the first form must already be submitted, so we have some work that it's best to do now regardless of which other button was pressed.
		$wordString = trim(preg_replace('#[\.,\?/!]#u', '', $_POST['sentenceAnalyzedForm']));
		if(strlen($wordString) > 0){
			$wordString = trim($wordString, " ");
			$wordDescs = explode(" ", $wordString);
			$_POST['keyWords'] = $wordDescs;
		}
		foreach($wordDescs as $key => $desc){
			$wordExistsResult = mysql_query("SELECT wordID, wordWrittenForm, wordDescription FROM word WHERE wordWrittenForm LIKE '" . $desc ."'");
				while($wordRow = mysql_fetch_array($wordExistsResult)){
					$relatedWords[$wordRow[0]] = $wordRow[1] . " - " . $wordRow[2];
				}
		}
		$_POST['possibleMatches'] = $relatedWords;
}

function removeExistingAssociation($sentenceID, $wordSequenceNumber){
	//remove any existing association for current sentence and SequenceNumber
		$sentence_wordDeleteQuery = "DELETE FROM sentence_word WHERE sentenceID = " .
			$sentenceID . " AND wordSequenceNumber = " . 
			mysql_real_escape_string($wordSequenceNumber);
		if(!$sentence_wordDeleteResult = mysql_query($sentence_wordDeleteQuery)){echo ('Query failed: ' . mysql_error()) . " QUERY TEXT: " . $sentence_wordDeleteQuery; mysql_query("ROLLBACK");die();} 
}

function associateWordWithSentence($sentenceID, $wordID, $wordSequenceNumber, $message=""){
	//first, clear out existing association, if any
	removeExistingAssociation($sentenceID, $wordSequenceNumber);
	//given a sentenceID, wordID, and wordSequenceNumber, populate sentence_word
	$sentence_wordInsertQuery = "INSERT INTO sentence_word (sentenceID, wordID, wordSequenceNumber) VALUES (".
				mysql_real_escape_string($sentenceID).",".
				mysql_real_escape_string($wordID).",".
				mysql_real_escape_string($wordSequenceNumber).")";
			if(!$result = mysql_query($sentence_wordInsertQuery)){echo ('Query failed: ' . mysql_error()); mysql_query("ROLLBACK");die();} 
	print $message;
}

function doSyllableMaintenanceOperations($wordID){
	//For each syllable the user has filled in data for...
	//prepare needed variables for the below loop
	$syllableNo = 0;
	$syllableIDs = array(); 
	$toneReps = array();
	while(strcmp($_POST['wordS'.$syllableNo.'Description'], "") != 0 || strcmp($_POST['wordS'.$syllableNo.'SpokenForm'], "") != 0){
		//populate its tone reps for later use
		$toneReps[$syllableNo] = explode(",", preg_replace('/\s*/', '', $_POST['wordS'.$syllableNo.'Tone']));
		//determine whether it exists
		$findSyllableQuery = "SELECT syllable.syllableID FROM syllable WHERE " .
			"syllableDescription = '" . mysql_real_escape_string($_POST['wordS'.$syllableNo.'Description']) . "' AND " .
			"syllableSpokenForm = '" . mysql_real_escape_string($_POST['wordS'.$syllableNo.'SpokenForm']) . "' AND " . 
			"syllableTypeID = '" . getSyllableTypeID(mysql_real_escape_string($_POST['wordS'.$syllableNo.'Type'])) . "'"; 

		if(!$findSyllableResult = mysql_query($findSyllableQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $findSyllableQuery); mysql_query("ROLLBACK"); die();}
		if(mysql_num_rows($findSyllableResult) < 1){	//No such syllable exists.  We must insert it.
			$syllableIDs[$syllableNo] = addNewSyllable($syllableNo, $toneReps);
		}
		else{	//Some such syllable may exist.  We need to determine whether or not its tones are the same.
			while($possibleSyllableID = mysql_fetch_array($findSyllableResult, MYSQL_BOTH)){
				$findTonesQuery = "SELECT toneID, toneSequenceNumber from syllable_tone where syllableID = " . $possibleSyllableID[0];
				if(!$findTonesResult = mysql_query($findTonesQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $findTonesQuery); mysql_query("ROLLBACK"); die();}
				$isCorrect=1;	//flag that will be unset if tones don't match
				//We'll now do a quick check to make sure it's even possible the tones are correct
				if(mysql_num_rows($findTonesResult) != count($toneReps[$syllableNo])){
					$isCorrect = 0;
				}
				else{
					while($findTonesRow = mysql_fetch_array($findTonesResult, MYSQL_BOTH)){
						if(strcmp($findTonesRow[0], $GLOBALS['tones'][$toneReps[$syllableNo][$findTonesRow[1]]]) != 0){
							$isCorrect=0;
						}
					}
				}
				if($isCorrect){
					$syllableIDs[$syllableNo] = $possibleSyllableID[0];
				}
			}
			//None of the possible syllables had matching tones, so we add a new one
			if(!isSet($syllableIDs[$syllableNo])){
					$syllableIDs[$syllableNo] = addNewSyllable($syllableNo, $toneReps);
			}
		}
		if(!$word_syllableDeleteResult = mysql_query("DELETE FROM word_syllable where wordID = " . $wordID . " AND syllableSequenceNumber = " . mysql_real_escape_string($syllableNo))){echo ('Deletion query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();}
		$word_syllableInsertQuery = "INSERT INTO word_syllable (wordID, syllableID, syllableSequenceNumber) VALUES(" . 
			mysql_real_escape_string($wordID) . ", " . 
			mysql_real_escape_string($syllableIDs[$syllableNo]) . ", " . 
			mysql_real_escape_string($syllableNo) . ")";
		if(!mysql_query($word_syllableInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $word_syllableInsertQuery); mysql_query("ROLLBACK"); die();}
		
		$syllableNo++;
	}
}

function deleteExistingMorphologicalCategory($idToDelete){
	$morphoCatDeleteQuery = "DELETE FROM morphologicaltype WHERE morphologicaltypeID = " . $idToDelete;
	if(!$morphoCatDeleteResult = mysql_query($morphoCatDeleteQuery)){echo ('Deletion query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();} 
}

function editExistingMorphologicalCategory($idToEdit, $newValue){
	$morphoCatUpdateQuery = "UPDATE morphologicaltype SET morphologicaltypedescription = '" .
		$newValue . "' WHERE morphologicaltypeID = " . 
		$idToEdit;
	if(!$morphoCatUpdateResult = mysql_query($morphoCatUpdateQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $morphoCatUpdateQuery); mysql_query("ROLLBACK"); die();} 
}

function addNewMorphologicalCategory($newValue){
	$morphoCatInsertQuery = "INSERT INTO morphologicaltype (morphologicaltypedescription) VALUES('" .
		$newValue . "')";
	if(!$morphoCatInsertResult = mysql_query($morphoCatInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $morphoCatInsertQuery); mysql_query("ROLLBACK"); die();} 
}

function deleteExistingLexicalCategory($idToDelete){
	$lexCatDeleteQuery = "DELETE FROM lexicalcategory WHERE lexicalcategoryID = " . $idToDelete;
	if(!$lexCatDeleteResult = mysql_query($lexCatDeleteQuery)){echo ('Deletion query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();} 
}

function editExistingLexicalCategory($idToEdit, $newValue){
	$lexCatUpdateQuery = "UPDATE lexicalcategory SET lexicalcategorydescription = '" .
		$newValue . "' WHERE lexicalcategoryID = " . 
		$idToEdit;
	if(!$lexCatUpdateResult = mysql_query($lexCatUpdateQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $lexCatUpdateQuery); mysql_query("ROLLBACK"); die();} 
}

function addNewLexicalCategory($newValue){
	$lexCatInsertQuery = "INSERT INTO lexicalcategory (lexicalcategorydescription) VALUES('" .
		$newValue . "')";
	if(!$lexCatInsertResult = mysql_query($lexCatInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $lexCatInsertQuery); mysql_query("ROLLBACK"); die();} 
}

function deleteExistingSentenceType($idToDelete){
	$sentenceTypeDeleteQuery = "DELETE FROM sentencetype WHERE sentencetypeID = " . $idToDelete;
	if(!$sentenceTypeDeleteResult = mysql_query($sentenceTypeDeleteQuery)){echo ('Deletion query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();} 
}

function editExistingSentenceType($idToEdit, $newValue){
	$sentenceTypeUpdateQuery = "UPDATE sentencetype SET sentencetypedescription = '" .
		$newValue . "' WHERE sentencetypeID = " . 
		$idToEdit;
	if(!$sentenceTypeUpdateResult = mysql_query($sentenceTypeUpdateQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $sentenceTypeUpdateQuery); mysql_query("ROLLBACK"); die();} 
}

function addNewSentenceType($newValue){
	$sentenceTypeInsertQuery = "INSERT INTO sentencetype (sentencetypedescription) VALUES('" .
		$newValue . "')";
	if(!$sentenceTypeInsertResult = mysql_query($sentenceTypeInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $sentenceTypeInsertQuery); mysql_query("ROLLBACK"); die();} 
}

function deleteExistingSemanticField($idToDelete){
	$semanticFieldDeleteQuery = "DELETE FROM semanticfield WHERE semanticfieldID = " . $idToDelete;
	if(!$semanticFieldDeleteResult = mysql_query($semanticFieldDeleteQuery)){echo ('Deletion query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();} 
}

function editExistingSemanticField($idToEdit, $newValue){
	$semanticfieldUpdateQuery = "UPDATE semanticfield SET semanticfielddescription = '" .
		$newValue . "' WHERE semanticfieldID = " . 
		$idToEdit;
	if(!$semanticFieldUpdateResult = mysql_query($semanticFieldUpdateQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $semanticFieldUpdateQuery); mysql_query("ROLLBACK"); die();} 
}

function addNewSemanticField($newValue){
	$semanticFieldInsertQuery = "INSERT INTO semanticfield (semanticfielddescription) VALUES('" .
		$newValue . "')";
	if(!$semanticFieldInsertResult = mysql_query($semanticFieldInsertQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $semanticFieldInsertQuery); mysql_query("ROLLBACK"); die();} 
}

function setInitialDropdownValue($valueToTest){
		if(isset($_REQUEST[$valueToTest])){
			return $_REQUEST[$valueToTest];
		}
		else{
			return "-2";
		}
}

function deleteFromTable($tableName, $identifyingFieldValue, $identifyingFieldName){
	$deletionQuery = "DELETE FROM " .
		mysql_real_escape_string($tableName) . " WHERE " . 
		mysql_real_escape_string($identifyingFieldName) . " = '" . 
		mysql_real_escape_string($identifyingFieldValue) . "'";
	if(!$deletionResult = mysql_query($deletionQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $deletionQuery); mysql_query("ROLLBACK"); die();} 
}

function insertIntoTable($tableName, $valuesToInsert){
//IMPORTANT: The $valuesToInsert passed to this function must have single quotes around strings at the time they're passed in!
	$insertionQuery = "INSERT INTO " . 
		mysql_real_escape_string($tableName) . " (";
	foreach ($valuesToInsert as $fieldName => $value){
		$insertionQuery .= $fieldName . ", ";
	}
	$insertionQuery = rtrim($insertionQuery, ", ");	//compensate for the loop not knowing when it's almost over
	$insertionQuery .= ") VALUES(";	//End field specification and begin value specification
	
	foreach ($valuesToInsert as $fieldName => $value){
		$insertionQuery .= $value . ", ";
	}
	$insertionQuery = rtrim($insertionQuery, ", ");	//compensate for the loop not knowing when it's almost over
	$insertionQuery .= ")";	
	//Done with query creation.  Now, execute.
	if(!$insertionResult = mysql_query($insertionQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $insertionQuery); mysql_query("ROLLBACK"); die();} 
	$returnRow = mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()"));
	return $returnRow[0];
}

function parseToneString($stringToParse){
	$tonesPerWord = explode(";", $stringToParse);
	foreach($tonesPerWord as $key => $value){
		$tonesPerWord[$key] = explode(",", $value);
	}
	return $tonesPerWord;
}

function getToneID($toneRepresentation){
	$toneDiscoveryQuery = "SELECT toneID FROM tone WHERE toneRepresentation = '" .
		$toneRepresentation . "'";
	if(!$toneDiscoveryResult = mysql_query($toneDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $toneDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
	if(mysql_num_rows($toneDiscoveryResult) > 0){
		$toneDiscoveryRow = mysql_fetch_array($toneDiscoveryResult);
		return $toneDiscoveryRow['toneID'];
	}
	else{
		return insertIntoTable("tone", array("toneRepresentation" => "'".$toneRepresentation."'"));
	}
}

function getToneRepresentation($toneID){
	if($toneID > 0){
		$toneDiscoveryQuery = "SELECT toneRepresentation FROM tone WHERE toneID = " .
			$toneID;
		if(!$toneDiscoveryResult = mysql_query($toneDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $toneDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
		$toneDiscoveryRow = mysql_fetch_array($toneDiscoveryResult);
		return $toneDiscoveryRow['toneRepresentation'];
	}
	else return '';	
}

function updateSentenceTone($sentenceID, $toneString){
	//We must clear out any old data regarding this sentence
	deleteFromTable("sentence_tone", $sentenceID, "sentenceID");
	
	//make sure we even need to bother making updates
		//we do this after the deletion in case the user wishes to clear the sentence's tones
	if(strcmp($toneString, '') == 0){
		return;
	}
	//Now we re-insert new values based on $toneString.  First step, get an array of arrays of tones.
	$toneStringParsed = parseToneString($toneString);
	//Next step, run insertions for each one.
	foreach($toneStringParsed as $wordNo => $wordArray){
		foreach($wordArray as $toneNo => $toneValue){
			$toneID = getToneID($toneValue);
			insertIntoTable("sentence_tone", array('sentenceID' => $sentenceID, 'toneID' => $toneID, 'toneSequenceNumber' => $wordNo, 'toneSubSequenceNumber' => $toneNo));
		}
	}
}

function generateToneString($sentenceID){
	$sentenceToneDiscoveryQuery = "SELECT * FROM sentence_tone WHERE sentenceID = " . 
		mysql_real_escape_string($sentenceID) . " ORDER BY toneSequenceNumber, toneSubSequenceNumber";
	if(!$sentenceToneDiscoveryResult = mysql_query($sentenceToneDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $sentenceToneDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
	//now we will construct an array of arrays to represent the tones in this sentence
	$toneArray = array();
	while($sentenceToneDiscoveryRow = mysql_fetch_array($sentenceToneDiscoveryResult)){
		$toneArray[$sentenceToneDiscoveryRow['toneSequenceNumber']][$sentenceToneDiscoveryRow['toneSubSequenceNumber']] = $sentenceToneDiscoveryRow['toneID'];
	}
	//with toneArray created, we can now iterate through it to produce toneString
	$toneString = "";
	foreach ($toneArray as $wordNo => $wordArray){
		foreach($wordArray as $toneNo => $toneID){
			$toneString .= getToneRepresentation($toneID);
			$toneString .= ",";
		}
		$toneString = rtrim($toneString, ", ");	//remove the last comma added by the inner loop
		$toneString .= ";";
	}
	return rtrim($toneString, "; ");	//ensure no trailing semicolons or spaces remain
}

function wordLinkIfAvailable($sentenceID, $wordSequenceNumber, $linkLabel){
	$sentenceWordDiscoveryQuery = "SELECT wordID FROM sentence_word WHERE sentenceID = " . 
		$sentenceID . " AND wordSequenceNumber = " .
		$wordSequenceNumber;
	if(!$sentenceWordDiscoveryResult = mysql_query($sentenceWordDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $sentenceWordDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
	if(mysql_num_rows($sentenceWordDiscoveryResult) > 0){
		$row = mysql_fetch_array($sentenceWordDiscoveryResult);
		return "<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$row['wordID']."\">" . $linkLabel . "</a>";
	}
	else return $linkLabel;
}

function setAudioFileInsertID($dataType){
	if(isset($_FILES[$dataType . 'AudioFile']['tmp_name']) && strcmp($_FILES[$dataType . 'AudioFile']['tmp_name'], '' != 0)){
			return insertAutoGenAudioFile();
	}
	else{
		return -1;
	}
}

function uploadAudioFile($fileOldNameKey, $fileNewName, $fileNewPath, $audioFileInsertID){
			//temporary filename is set, so we must deal with a new audio file
		$fileOldName = basename($_FILES[$fileOldNameKey]['name']);
		$fileExt = substr(strrchr($fileOldName, '.'), 1);
		$targetAudioPath = $fileNewPath . $fileNewName . "." . $fileExt;
	
		if(move_uploaded_file($_FILES[$fileOldNameKey]['tmp_name'], $targetAudioPath)) {
			echo "The file ".  $fileOldName . " has been uploaded.";
			//Now we must update the audioFile table to reflect our new file
			updateAudioFile($audioFileInsertID, $fileNewName, $fileExt, $fileNewPath);
		} 
		else{
			echo "There was a non-fatal error uploading the audio.";
		}
}

function getPersonIDOrCreateNew($handleString){
	if((strcmp($handleString, '') != 0) && (isset($handleString))){
		if($personID = getPersonID($handleString)){
			return $personID;
		}
		else{
			return insertIntoTable("person", array("userHandle" => "'".$handleString."'"));
		}
	}
	else return -1;
}

function getPersonID($handleString){
	$personDiscoveryQuery = "SELECT personID FROM person WHERE userHandle = '" . 
		mysql_real_escape_string($handleString) . "'";
	if(!$personDiscoveryResult = mysql_query($personDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $personDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
	if(mysql_num_rows($personDiscoveryResult) > 0){
		$personDiscoveryRow = mysql_fetch_array($personDiscoveryResult);
		return $personDiscoveryRow['personID'];
	}
	else return 0;
}

function getPersonHandle($personID){
	$personDiscoveryQuery = "SELECT userHandle FROM person WHERE personID = " . 
		mysql_real_escape_string($personID);
	if(!$personDiscoveryResult = mysql_query($personDiscoveryQuery)){echo ('Query failed: ' . mysql_error() . "QUERY TEXT: " . $personDiscoveryQuery); mysql_query("ROLLBACK"); die();} 
	if(mysql_num_rows($personDiscoveryResult) > 0){
		$personDiscoveryRow = mysql_fetch_array($personDiscoveryResult);
		return $personDiscoveryRow['userHandle'];
	}
	else return '';
}

function connectToDB(){
$link = mysql_connect('elder-online.org', 'elderonl_root', 'HSD22715')
    or die('Could not connect: ' . mysql_error());
	mysql_select_db('elderonl_annadb') or die('Could not select database');
	return $link;
}
?>

