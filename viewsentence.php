<script type='text/javascript'>
function viewSentenceValidator(){
	return true;
}
</script>

<?php 
//Page for Viewing of Sentences
require_once ('formdisplayhelperfunctions.php');
require_once ('titletop.php');
require_once ('navheaderside.php');
$link = connectToDB();

//###########################MAIN LOGIC###################
	$viewSentenceQuery = "SELECT sentence.sentenceTypeID AS sentenceTypeID, sentenceTypeDescription, spokenForm, analyzedForm, audioFileID, freeTranslation, sentenceDescription, closeGloss, enteredBy, spokenBy, session, toDoNotes FROM sentence, sentencetype 
		WHERE sentenceID = " . $_GET['sentenceID'] .
		" AND sentence.sentenceTypeID = sentencetype.sentenceTypeID";
	
		//query is ready; now perform it
	$result = mysql_query($viewSentenceQuery) or die('Query failed: ' . mysql_error());
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	 //Print results in HTML
	echo "<div class=\"content\">";
	echo "<p class=\"ReadListenEdit\">";
	//PRINT FREE TRANSLATION
	echo tagForCSS($row['freeTranslation'], "FreeTranslation")."\n";
	//PRINT AUDIO LINK
	printAudioFilesHorizontal($_REQUEST['sentenceID'], "sentence");
	//PRINT EDIT SENTENCE LINK
	echo tagForCSS("<a href=\"".$GLOBALS['baseurl']."/editsentence.php?sentenceID=".$_GET['sentenceID']."\">Edit This Sentence</a>", "EditSentence");
	echo "</p>";
	
	echo "<p class=\"SurfaceForm\">";
	echo TagForCSSLabel("Surface Form:");
	echo "<table>\n";
			//PRINT TONES
			echo "<tr>\n";
			echo "<td><b>Pitch:</b></td>\n";
			$pitchArray = parsePitchString(generatePitchString($_GET['sentenceID']));
			foreach ($pitchArray as $wordNo => $wordArray){
				echo "\t\t<td align=\"center\">";
				foreach($wordArray as $pitchNo => $pitchRep){
					echo " " . $pitchRep;
				}
				echo "</td>\n";
			}
			echo "\t</tr>\n";
			//PRINT SPOKEN FORM
			echo "\t<tr>\n";
			echo "\t\t<td><b>Spoken Form:</b></td>\n";
			$wordSpokenFormArray = explode(' ', trim(preg_replace('#[\.,\?/!]#u', '', $row['spokenForm']), ' '));
			foreach($wordSpokenFormArray as $iteration => $spokenFormSlice){
				echo "\t\t<td>&nbsp;&nbsp;" . $spokenFormSlice . "&nbsp;&nbsp;</td>\n";
			}
			echo "\t</tr>\n";
	echo "</table>\n";
	echo "</p>";
	echo "<p class=\"UnderlyingForm\">";
	echo TagForCSSLabel("Underlying Form:");
	echo "<table>\n";
				//PRINT TONES
			echo "\t<tr>\n";
			echo "\t\t<td><b>Analyzed Tone:</b></td>\n";
			$toneArray = parseToneString(generateToneString($_GET['sentenceID']));
			foreach ($toneArray as $wordNo => $wordArray){
				echo "\t\t<td align=\"center\">";
				foreach($wordArray as $toneNo => $toneRep){
					echo " " . $toneRep;
				}
				echo "</td>\n";
			}
			//PRINT ANALYZED FORM
			echo "\t<tr>\n";
			echo "\t\t<td><b>Analyzed Form:</b></td>\n";
			$wordAnalyzedFormArray = explode(' ', trim(preg_replace('#[\.,\?/!]#u', '', $row['analyzedForm']), ' '));
			foreach($wordAnalyzedFormArray as $iteration => $analyzedFormSlice){
				echo "\t\t<td align=\"center\">&nbsp;&nbsp;" . wordLinkIfAvailable($_GET['sentenceID'], $iteration, $analyzedFormSlice) . "&nbsp;&nbsp;</td>\n";
			}
			echo "\t</tr>\n";
			//PRINT CLOSE GLOSS
			echo "\t<tr>\n";
			echo "\t\t<td><b>Close Gloss:</b></td>\n";
			$wordCloseGlossArray = preg_split('/[\s]/', trim(preg_replace('#[\.,/\?!]#u', '', $row['closeGloss']), ' '));
			foreach($wordCloseGlossArray as $iteration => $closeGlossSlice){
				echo "\t\t<td align=\"center\">" . $closeGlossSlice . "</td>\n";
			}
			echo "\t</tr>\n";
	echo "</table>\n";
	echo "</p>";
	echo "<p class=\"NotesAndMetadata\">";
	echo tagForCSSLabel("Notes and Metadata:")."<br />";
			//PRINT ADDITIONAL NOTES
			echo "<b>Additional Notes: </b>".escapeDubQuotes($row['sentenceDescription'])."<br />\n";
			//PRINT TO-DO NOTES
			echo "<b>To-Do Notes: </b>".escapeDubQuotes($row['toDoNotes'])."<br />\n";
			//PRINT ENTERER
			echo "<b>Entered By: </b>".escapeDubQuotes(getPersonHandle($row['enteredBy']))."<br />\n";
			//PRINT SPEAKER
			echo "<b>Spoken By: </b>".escapeDubQuotes(getPersonHandle($row['spokenBy']))."<br />\n";
			//PRINT SESSION
			echo "<b>Session: </b>".escapeDubQuotes($row['session'])."<br />\n";
			//PRINT SENTENCE TYPE
			echo "<b>Sentence Type: </b>"." <a href=\"".$GLOBALS['baseurl']."/searchsentence.php?sentenceType=".$row['sentenceTypeID']."&_submit_check=1\">".$row['sentenceTypeDescription']."</a><br />\n";
	echo "</p>";
			//PRINT SENTENCE DELETION LINK
			echo "<a class=\"DeleteSentence\" href=\"".$GLOBALS['baseurl']."/removesentence.php?sentenceID=".$_GET['sentenceID']."\">Delete This Sentence (PERMANENT)</a><br />\n";
	echo "</div>";
//###################################END MAIN LOGIC####################################

// Free resultset
	mysql_free_result($result);
require_once('footer.php');
?>