<?php
/*export dot php
export.php's function is to create a snapshot of the entire ELDER database for a given language in XML format.  It will name this snapshot after the logged-in user and the time it is accessed.

This php file is designed to read from a plain text file, exportspec.txt, a list of aliases.  These aliases are to be of the format one.two->three, where "one.two" is the name provided by MySQL for a table and a column (separated by the period), and "three" is the name that is to be used in the XML file that export.php outputs.  If a table-column pair has no corresponding line in exportspec.txt, the default values are used.  If a table-column pair has two or more corresponding lines, the last one according to the sequence of exportspec.txt will be used.

Connor Shaughnessy August 2010
*/
require_once('formdisplayhelperfunctions.php');
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//Check and make sure there's a logged in user - we don't need to check that the user is valid because we're not concerned with security at the moment; we just want something to name the file!
if(!isset($_SESSION['userName'])){
	//Inform the user of the requirement to be logged in.
	die("You must be <a href=\"/login.php\">logged in</a> to export ELDER to a file.");
}
/*PERFORMING A COMPLETE DUMP - WORK IN PROGRESS
//We will query the database to ask what the names of all its tables are.
$link = connectToDB();
if (!$tableNamesResult = mysql_query ("SHOW TABLES IN annadb")){echo ("Failed to retrieve names of database tables."); die();}
$i=0;
while($row = mysql_fetch_assoc($tableNamesResult)){
	foreach $row as $key => $value{
		$tableNames[
	}
}*/

//PERFORMING A PARTIAL (USABILITY-FOCUSED) DUMP IN CSV FORMAT
$link = connectToDB();
$wordOutPath = "/export/".$_SESSION['userName']."Words.csv";
$sentenceOutPath = "/export/"$_SESSION['userName']."Sentences.csv";
$wordOutFile = fopen($wordOutPath, "w") or die("Cannot open word output file.");
$sentenceOutFile = fopen($sentenceOutPath, "w") or die("Cannot open sentence output file.");

	$viewWordQuery = "SELECT wordWrittenForm, wordDescription, analyzedTone, etymology, lexicalCategoryDescription, morphologicalTypeDescription, notes FROM word, lexicalcategory, morphologicaltype" . 
		" WHERE word.lexicalCategoryID = lexicalCategory.lexicalCategoryID" . 
		" AND word.morphologicalTypeID = morphologicalType.morphologicalTypeID";
	
	$wordResult = mysql_query($viewWordQuery) or die('Query failed: ' . mysql_error() . "QUERY TEXT: " . $viewWordQuery);
	
	//Before we start using the result of the executed query, let's write our column headings to the file
	fwrite($wordOutFile, "IPA\tGloss\tPitch\tCEPOM Orthography\tGrammatical Cat\tMorphological Cat\tNotes\n");
	
	while ($wordRow = mysql_fetch_array($wordResult, MYSQL_ASSOC)){
		$wordString = "";
		foreach ($wordRow as $key => $element){
			$wordString .= $element . "\t";
		}
		$wordString .= "\n";
		fwrite($wordOutFile, $wordString);
		}
		
	$viewSentenceQuery = "SELECT sentenceID, freeTranslation, spokenForm, analyzedForm, closeGloss, sentenceDescription FROM sentence";
	
	$sentenceResult = mysql_query($viewSentenceQuery) or die('Query failed: ' . mysql_error() . "QUERY TEXT: " . $viewSentenceQuery);
	
		//Before we start using the result of the executed query, let's write our column headings to the file
	fwrite($sentenceOutFile, "Gloss\tPitch\tSpoken Form\tAnalyzed Tone\tUnderlying Form\tClose Gloss\tNotes\n");
	
	while ($sentenceRow = mysql_fetch_array($sentenceResult, MYSQL_ASSOC)){
		$sentence = array($sentenceRow["freeTranslation"], generatePitchString($sentenceRow["sentenceID"]), $sentenceRow["spokenForm"], generateToneString($sentenceRow["sentenceID"]), $sentenceRow["analyzedForm"], $sentenceRow["closeGloss"], $sentenceRow["sentenceDescription"]);
		$sentenceString = "";
		foreach($sentence as $key => $element){
			$sentenceString .= $element . "\t";
		}
		$sentenceString .= "\n";
		fwrite($sentenceOutFile, $sentenceString);
	}
	print "Export complete.  Your files are <a href=\"".$wordOutPath."\">here (words)</a> and <a href=\"".$sentenceOutPath."\">here (sentences)</a>.  When importing into Microsoft Excel or equivalent program, make sure to specify Unicode format and Tab-separated values.";

fclose($wordOutFile);
fclose($sentenceOutFile);
?>