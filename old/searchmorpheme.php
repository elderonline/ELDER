<script type='text/javascript'>
function searchMorphemeValidator(){
	return true;
}
</script>

<?php
####################TO DO: SELECT AND DISPLAY LIST OF PHONES FOR EACH MORPHEME ###########################

// Connecting.  Params are hostname, username, password
require_once('formdisplayhelperfuntions.php');
$link = connectToDB();
echo "<h1>Search for a morpheme</h1>";
require_once ('navheader.php');


$phones = getExistingPhones();
$lexCats = getExistingLexCats();
$funcCats = getExistingFuncCats();

//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
		//process the submitted data
		process_form();
}
else{
	// The form wasn't submitted, so display
	show_form();
}
//###################################END MAIN LOGIC####################################

function show_form(){
	?>
	<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return searchMorphemeValidator()'>

	<table>
	<tr><td>Description (any part):</td>
	<td><?php input_text('morphemeDescription', $defaults) ?></td></tr>
	
		<tr><td>Meaning (any part):</td>
	<td><?php input_text('morphemeMeaning', $defaults) ?></td></tr>

	<tr><td>Contains phone:</td>
	<td><?php input_select('containsPhone', $defaults, $GLOBALS['phones']) ?></td></tr>
	
	<tr><td>Lexical category:</td>
	<td><?php input_select('morphemeLexicalCategory', $defaults, $GLOBALS['lexCats']); ?>
	</td>
	<td>Functional category:</td>
	<td><?php input_select('morphemeFunctionalCategory', $defaults, $GLOBALS['funcCats']); ?>
	</td></tr>

	<tr><td colspan="2" align="center"><?php input_submit('morphemeSearch','Search'); ?>
	</td></tr>
	</table>

	<input type="hidden" name="_submit_check" value="1"/>

	</form>
	<?php
}

function process_form(){

	$searchMorphemeQuery = "SELECT m.morphemeID, m.morphemeDescription, m.morphemeMeaning, lc.lexicalCategoryDescription, fc.functionalCategoryDescription FROM morpheme m, lexicalCategory lc, functionalCategory fc WHERE m.lexicalCategoryID=lc.lexicalCategoryID AND m.functionalCategoryID=fc.functionalCategoryID" . 
		" AND m.morphemeDescription LIKE '%" . mysql_real_escape_string($_POST['morphemeDescription']) . "%'" .
		" AND m.morphemeMeaning LIKE '%" . mysql_real_escape_string($_POST['morphemeMeaning']) . "%'";
	if($_POST['morphemeLexicalCategory'] != -2){ #-2 is the value used for ANY
		$searchMorphemeQuery .=  " AND lc.lexicalCategoryID = " . $_POST['morphemeLexicalCategory'];
	}
	if($_POST['morphemeFunctionalCategory'] != -2){ #-2 is the value used for ANY
		$searchMorphemeQuery .=  " AND fc.functionalCategoryID = " . $_POST['morphemeFunctionalCategory'];
	}
	if($_POST['containsPhone'] != -2){ #-2 is the value used for ANY
		$searchMorphemeQuery .=  " AND EXISTS (SELECT * FROM morpheme_phone mp WHERE mp.morphemeID=" . $_POST['containsPhone'] . ")";
	}
	
		//query is ready; now perform it
	$result = mysql_query($searchMorphemeQuery) or die('Query failed: ' . mysql_error());
	
	 //Print results in HTML
	echo "<table>\n";
	echo "\t<tr>\n\t\t<td>Description</td>\n\t\t<td>Meaning</td>\n\t\t<td>Lex Category</td>\n\t\t<td>Func Category</td>\n\t</tr>\n";
	while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
		echo "\t<tr>\n";
			echo "\t\t<td>".$row['morphemeDescription']."</td>\n";
			echo "\t\t<td>".$row['morphemeMeaning']."</td>\n";
			echo "\t\t<td>".$row['lexicalCategoryDescription']."</td>\n";
			echo "\t\t<td>".$row['functionalCategoryDescription']."</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";

// Free resultset
	mysql_free_result($result);
}
//print a text box
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print htmlentities($values[$element_name]) . '">';
}
//print a submit button
function input_submit($element_name, $label) {
    print '<input type="submit" name="' . $element_name .'"id="'.$element_name.'" value="';
    print htmlentities($label) .'"/>';
}
function phonesToInts($phoneString){
	$htmlCharReplacements = array("&#" => "", ";" => "");
	//turn any normal English characters into numbers
	//$phoneString = encodeUTFInString($phoneString);
	//split string into numbers
	//$phoneString = explode(encodeUTFInString($phoneString), ";&#");
	$phones = explode(";&#", encodeUTFInString($phoneString));
	foreach ($phones as $key => $phone){
		$phones[$key] = strtr($phone, $htmlCharReplacements);
	}
	return $phones;
}
function encodeUTFInString($stringToEncode){
	$ascee = array('a' => '&#97;', 'b' => '&#98;', 't' => '&#116;', 'l' => '&#116;');
	return strtr($stringToEncode, $ascee);
}
function input_select($element_name, $selected, $options, $multiple = false) {
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
        print '<option value="' . htmlentities($option) . '" label="'.htmlentities($label) .'"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . $label . '</option>';
    }
    print '</select>';
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
//cleanup
// Closing connection
mysql_close($link);
?>
