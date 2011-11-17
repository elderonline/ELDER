<script type='text/javascript'>
function viewWordValidator(){
	return true;
}
</script>

<?php
//Page for Viewing of Words
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
echo "<html>";
require_once ('titletop.php');
require_once ('navheaderside.php');



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
	echo "\n";
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	echo "<div class=\"content\">";
		echo "<p class=\"ReadListenEdit\">";
		echo tagForCSS($row['wordWrittenForm'], "WordWrittenFormLabel");
		printAudioFilesHorizontal($_REQUEST['wordID'], "word");
		echo tagForCSS("<a href=\"".$GLOBALS['baseurl']."/editword.php?wordID=".$_GET['wordID']."\">Edit This Word</a>", "EditWord") . "<br /><br />";
		echo tagForCSS($row['wordDescription'], "Gloss") . "\n";
		echo "</p>";
		
		echo "<p class=\"Transcriptions\">";
		echo tagForCSSLabel("IPA: ") . tagForCSS("<a href=\"".$GLOBALS['baseurl']."/viewword.php?wordID=".$_GET['wordID']."\">".$row['wordWrittenForm']."</a>", "IPA") . "<BR />";;
		echo tagForCSSLabel("CEPOM Orthography: ") . tagForCSS($row['etymology'], "CEPOMOrthography")."\n";
		echo "</p>";
		
		echo"<p class=\"Lists\">";
		printRelatedPhrasesHorizontal($_REQUEST['wordID']);
		printSeeAlsoWordsHorizontal($_REQUEST['wordID']);
		echo "</p>";
		
		echo "<p class=\"GrammarAndSemantics\">";
		echo "<span class=\"Row\">".tagForCSSLabel("Grammar and Semantics") . "</span>";
		echo "<span class=\"Row\">".tagForCSSLabel("Grammatical Category: ") . tagForCSS("<a href=\"".$GLOBALS['baseurl']."/searchword.php?wordLexCat=".$row['lexicalCategoryID']."&_submit_check=1\">".$row['lexicalCategoryDescription']."</a>", "GrammaticalCategory");
		echo tagForCSSLabel("Morphological Category: ") . tagForCSS($row['morphologicalTypeDescription'], "MorphologicalCategory")."</span>";
		echo "<span class=\"Row\">".tagForCSSLabel("Headword: ") . tagForCSS(printLinkToWord($row['rootID']), "Headword");
		echo tagForCSS("<a href=\"/managewordsemanticfield.php?wordID=".$_GET['wordID']."\">Semantic Fields: </a>", "SemanticFieldManagementLink") . tagForCSS(printWordSemanticFieldLinks($_GET['wordID'], "<BR />"), "SemanticFields")."</span>\n";
		echo "</p>";
		
		echo "<p class=\"PhoneticsAndPhonology\">";
		echo tagForCSSLabel("Phonetics and Phonology") . "<br />";
		printWordSyllableData($syllableData);
		echo tagForCSSLabel("Underlying Tone: ") . tagForCSS($row['analyzedTone'], "UnderlyingTone")."\n";
		echo "</p>";
		
		echo "<p class=\"NotesAndMetadata\">";
		echo tagForCSSLabel("Notes and Metadata") . "<br />";
		echo tagForCSSLabel("Entered By: ") . tagForCSS(escapeDubQuotes(getPersonHandle($row['enteredBy'])), "EnteredBy") . "<br />";
		echo tagForCSSLabel("Spoken By: ") . tagForCSS(escapeDubQuotes(getPersonHandle($row['spokenBy'])), "SpokenBy") . "<br />";
		echo tagForCSSLabel("Session: ") . tagForCSS(escapeDubQuotes($row['session']), "Session") . "<br />";
		echo tagForCSSLabel("To Do: ") . tagForCSS(escapeDubQuotes($row['toDoNotes']), "ToDo") . "<br />";
		echo tagForCSSLabel("Additional Notes: ") .tagForCSS(escapeDubQuotes($row['notes']), "AdditionalNotes"). "<br />\n";
		echo "</p>";
		
		echo tagForCSS("<a href=\"".$GLOBALS['baseurl']."/removeword.php?wordID=".$_GET['wordID']."\">Delete This Word (PERMANENT)</a>", "DeleteWord")."\n";
	echo "</div>";
echo "</html>";
// Free resultset
	mysql_free_result($result);

