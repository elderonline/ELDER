<script type='text/javascript'>
function viewSentenceValidator(){
	return true;
}
</script>

<?php 
//Page for Viewing of Sentences
require_once ('formdisplayhelperfunctions.php');
require_once ('navheader.php');
$link = connectToDB();
echo "<h1>View details about a sentence</h1>";

//###########################MAIN LOGIC###################
	$viewSentenceQuery = "SELECT sentence.sentenceTypeID AS sentenceTypeID, sentenceTypeDescription, spokenForm, analyzedForm, audioFileID, freeTranslation, sentenceDescription, closeGloss, enteredBy, spokenBy, session, toDoNotes FROM sentence, sentencetype 
		WHERE sentenceID = " . $_GET['sentenceID'] .
		" AND sentence.sentenceTypeID = sentencetype.sentenceTypeID";
	
		//query is ready; now perform it
	$result = mysql_query($viewSentenceQuery) or die('Query failed: ' . mysql_error());
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	 //Print results in HTML
	echo "<table>\n";
			//PRINT TONES
			echo "\t<tr>\n";
			echo "\t\t<td><b>Pitch:</b></td>\n";
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
	echo "<BR />";
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
	echo "<BR />";
	echo "<table>\n";
			//PRINT FREE TRANSLATION
			echo "\t<tr>\n";
			echo "\t\t<td><b>Free Translation: </b>".$row['freeTranslation']."</td>\n";
			echo "\t</tr>\n";
			//PRINT ADDITIONAL NOTES
			echo "\t<tr>\n";
			echo "\t\t<td><b>Additional Notes: </b>".escapeDubQuotes($row['sentenceDescription'])."</td>\n";
			echo "\t</tr>\n";
			//PRINT TO-DO NOTES
			echo "\t<tr>\n";
			echo "\t\t<td><b>To-Do Notes: </b>".escapeDubQuotes($row['toDoNotes'])."</td>\n";
			echo "\t</tr>\n";
			//PRINT ENTERER
			echo "\t<tr>\n";
			echo "\t\t<td><b>Entered By: </b>".escapeDubQuotes(getPersonHandle($row['enteredBy']))."</td>\n";
			echo "\t</tr>\n";
			//PRINT SPEAKER
			echo "\t<tr>\n";
			echo "\t\t<td><b>Spoken By: </b>".escapeDubQuotes(getPersonHandle($row['spokenBy']))."</td>\n";
			echo "\t</tr>\n";			
			//PRINT SESSION
			echo "\t<tr>\n";
			echo "\t\t<td><b>Session: </b>".escapeDubQuotes($row['session'])."</td>\n";
			echo "\t</tr>\n";
			//PRINT SENTENCE TYPE
			echo "\t<tr>\n";
			echo "\t\t<td><b>Sentence Type: </b>".$row['sentenceTypeDescription']." <a href=\"".$GLOBALS['baseurl']."/searchsentence.php?sentenceType=".$row['sentenceTypeID']."&_submit_check=1\">Sentences With This Type</a></td>\n";
			echo "\t</tr>\n";
			//PRINT EDIT SENTENCE LINK
			echo "\t<tr>\n";
			echo "\t\t<td><a href=\"".$GLOBALS['baseurl']."/editsentence.php?sentenceID=".$_GET['sentenceID']."\">Edit This Sentence</a></td>\n";
			echo "\t</tr>\n";
			//PRINT SENTENCE DELETION LINK
			echo "\t<tr>\n";
			echo "\t\t<td></td><td><a href=\"".$GLOBALS['baseurl']."/removesentence.php?sentenceID=".$_GET['sentenceID']."\">Delete This Sentence (PERMANENT)</a></td>\n";
			echo "\t</tr>\n";
	echo "</table>\n";
	print "<BR />";
	printWordsInSentence($_GET['sentenceID']);
	printAudioFiles($_REQUEST['sentenceID'], "sentence");
//###################################END MAIN LOGIC####################################

// Free resultset
	mysql_free_result($result);