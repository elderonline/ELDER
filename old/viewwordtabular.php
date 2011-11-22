<script type='text/javascript'>
function viewWordValidator(){
	return true;
}
</script>

<?php
//Page for Viewing of Words
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
echo "<PageName><h1>View details about a word</h1></PageName>";
require_once ('navheader.php');



	$viewWordQuery = "SELECT word.lexicalCategoryID AS lexicalCategoryID, word.morphologicalTypeID AS morphologicalTypeID, lexicalCategoryDescription, notes, toDoNotes, spokenBy, enteredBy, session, semanticFieldDescription, morphologicalTypeDescription, wordWrittenForm, audioFileID, wordDescription, etymology, analyzedTone, rootID FROM word, lexicalcategory, semanticfield, morphologicaltype
		WHERE wordID = " . $_GET['wordID'] . 
		" AND word.lexicalCategoryID = lexicalCategory.lexicalCategoryID" . 
		" AND word.morphologicalTypeID = morphologicalType.morphologicalTypeID";
	
		//query is ready; now perform it
	$result = mysql_query($viewWordQuery) or die('Query failed: ' . mysql_error() . " QUERY TEXT: " . $viewWordQuery);
	
	//Now we will deal with the individual syllables.
	$wordSyllableDiscoveryQuery = "SELECT syllableDescription, syllableTypeDescription, syllable.syllableID, syllableSpokenForm, syllableSequenceNumber FROM syllable, word_syllable, syllabletype WHERE word_syllable.syllableID=syllable.syllableID AND syllabletype.syllableTypeID=syllable.syllableTypeID AND word_syllable.wordID=" . $_REQUEST['wordID'];
	$discoveryResult = mysql_query($wordSyllableDiscoveryQuery) or die('Query failed: ' . mysql_error() . "QUERY STRING: " . $wordSyllableDiscoveryQuery);
	while($discoveryRow = mysql_fetch_array($discoveryResult, MYSQL_BOTH)){
		$syllableData[$discoveryRow['syllableSequenceNumber']]['Description'] = $discoveryRow['syllableDescription'];
		$syllableData[$discoveryRow['syllableSequenceNumber']]['SpokenForm'] = $discoveryRow['syllableSpokenForm'];
		$syllableData[$discoveryRow['syllableSequenceNumber']]['Type'] = $discoveryRow['syllableTypeDescription'];
		//Needed?: $_POST['wordSyllableIDs'][$discoveryRow['syllableSequenceNumber']] = $discoveryRow['syllableID'];
		//now we join syllable_tone and tone to find and parse properly the tones for each syllable
			$wordSyllableDiscoverySubQuery = "SELECT toneRepresentation, toneSequenceNumber FROM tone, syllable_tone WHERE tone.toneID=syllable_tone.toneID AND syllable_tone.syllableID=".$discoveryRow['syllableID']. " ORDER BY toneSequenceNumber";
			$discoverySubResult = mysql_query($wordSyllableDiscoverySubQuery) or die('Query failed: ' . mysql_error() . "QUERY STRING: " . $wordSyllableDiscoverySubQuery);
			while($discoverySubRow = mysql_fetch_array($discoverySubResult, MYSQL_BOTH)){
				if(strcmp("", $syllableData[$discoveryRow['syllableSequenceNumber']]['Tone']) != 0) {$syllableData[$discoveryRow['syllableSequenceNumber']]['Tone'] .= ',';}
				$syllableData[$discoveryRow['syllableSequenceNumber']]['Tone'] .= $discoverySubRow['toneRepresentation'];
			}
	}

	 //Print results in HTML
	echo "<table>\n";
	$row = mysql_fetch_array($result, MYSQL_BOTH);
		echo "\t<tr>\n";
		echo "<h2>" . tagForCSS($row['wordWrittenForm'], "WordWrittenFormLabel"). "</h>\n";
		echo "</tr>\n";
		echo "\t<tr>\n"; 
			echo "\t\t<td>".tagForCSSLabel("IPA: ") . tagForCSS("<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$_GET['wordID']."\">".$row['wordWrittenForm']."</a>", "IPA")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("CEPOM Orthography: ") . tagForCSS($row['etymology'], "CEPOMOrthography")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Gloss: ") . tagForCSS($row['wordDescription'], "Gloss") . "</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Additional Notes: ") .tagForCSS(escapeDubQuotes($row['notes']), "Additional Notes")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("To Do: ") . tagForCSS(escapeDubQuotes($row['toDoNotes']), "ToDo")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Underlying Tone: ") . tagForCSS($row['analyzedTone'], "UnderlyingTone")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Headword: ")  . tagForCSS(printLinkToWord($row['rootID']), "Headword") . "</td>\n";
			echo "\t</tr>\n";
			//PRINT ENTERER
			echo "\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Entered By: ") . tagForCSS(escapeDubQuotes(getPersonHandle($row['enteredBy'])), "EnteredBy")."</td>\n";
			echo "\t</tr>\n";
			//PRINT SPEAKER
			echo "\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Spoken By: ") . tagForCSS(escapeDubQuotes(getPersonHandle($row['spokenBy'])), "SpokenBy")."</td>\n";
			echo "\t</tr>\n";			
			//PRINT SESSION
			echo "\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Session: ") . tagForCSS(escapeDubQuotes($row['session']), "Session")."</td>\n";
			echo "\t</tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Grammatical Category: ") . tagForCSS("<a href=\"".$GLOBALS['baseurl']."/searchword.php?wordLexCat=".$row['lexicalCategoryID']."&_submit_check=1\">".$row['lexicalCategoryDescription']."</a>", "GrammaticalCategory")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Morphological Category: ") . tagForCSS($row['morphologicalTypeDescription'], "MorphologicalCategory");
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSSLabel("Semantic Fields: ") . tagForCSS(printWordSemanticFieldLinks($_GET['wordID'], "&nbsp;&nbsp;"), "SemanticFields");
			echo "\t\t<td>".tagForCSS("<a href=\"/managewordsemanticfield.php?wordID=".$_GET['wordID']."\">Manage Word's Semantic Fields</a>", "SemanticFieldManagementLink");
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td>".tagForCSS("<a href=\"".$GLOBALS['baseurl']."/editword.php?wordID=".$_GET['wordID']."\">Edit This Word</a>", "EditWord")."</td>\n";
			echo "\t</tr>\n\t<tr>\n";
			echo "\t\t<td></td><td>".tagForCSS("<a href=\"".$GLOBALS['baseurl']."/removeword.php?wordID=".$_GET['wordID']."\">Delete This Word (PERMANENT)</a>", "DeleteWord")."</td>\n";
		echo "\t</tr>\n";
	echo "</table>\n";
	print "<BR>";
	printWordSyllableData($syllableData);
	print "<BR>";
	printRelatedPhrases($_REQUEST['wordID']);
	if($row['rootID'] < 0){printWordsInClass($_REQUEST['wordID']);}
	else {printWordsInClass($row['rootID']);}
	printSeeAlsoWords($_REQUEST['wordID']);
	printAudioFiles($_REQUEST['wordID'], "word");

// Free resultset
	mysql_free_result($result);
