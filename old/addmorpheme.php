<script type='text/javascript'>
function addMorphemeValidator(){
	if (document.getElementById('morphemeMeaning').value.length < 1){
	alert("A morpheme must have a meaning!");
	document.getElementById('morphemeMeaning').focus();
	return false;
	}
	else{
	return true;
	}
}
</script>

<?php
/* Page for Entry of a Morpheme
Pseudocode:
populate lists of funccats and lexcats
get data (meaning, description, phone list, lexcat, func cat) from user form
select phoneID's from phone matching the ones input by the user
perform SQL update
go to page showing result
*/
$link = connectToDB();
echo "<h1>Enter a new morpheme</h1>";


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
//make the page immune to reloads - is this necessary or useful?
//    if ($_POST['_submit_check']){
//
//        $defaults = $_POST;
//
// Jump out of PHP mode to make displaying all the HTML tags easier
?>

<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return addMorphemeValidator()'>

<table>
<tr><td>Meaning:</td>
<td><?php input_text('morphemeMeaning', $defaults) ?></td></tr>

<tr><td>Description:</td>
<td><?php input_text('morphemeDescription', $defaults) ?></td></tr>

<tr><td>Phones:</td>
<td><?php input_text('morphemePhones', $defaults) ?></td></tr>

<tr><td>Lexical category:</td>
<td><?php input_select('morphemeLexicalCategory', $defaults, $GLOBALS['lexCats']); ?>
</td>
<td>Functional category:</td>
<td><?php input_select('morphemeFunctionalCategory', $defaults, $GLOBALS['funcCats']); ?>
</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('morphemeAdd','Add Morpheme'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php }

//Do the work of the SQL inserts using submitted data
function process_form(){
//First we will do an insert to the morpheme table; then we will take that ID and our phones, and do inserts into the morpheme_phone table
//Time to construct a SQL query for morpheme
	mysql_query("BEGIN");
	$morphemeInsertQuery = "INSERT INTO morpheme (morphemeDescription, alliphoneID, lexicalCategoryID, functionalCategoryID, morphemeMeaning) VALUES('"
		.mysql_real_escape_string($_POST['morphemeDescription']).
		"',NULL,".
		mysql_real_escape_string($_POST['morphemeLexicalCategory']).",".
		mysql_real_escape_string($_POST['morphemeFunctionalCategory']).",'".
		mysql_real_escape_string($_POST['morphemeMeaning'])."')";
	if(!$result = mysql_query($morphemeInsertQuery)){echo ('Query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();}
	$morphemeInsertID = mysql_fetch_array(mysql_query("SELECT LAST_INSERT_ID()"));

//Now we will look up the ID's for these phones...
	$phoneList = phonesToInts($_POST['morphemePhones']);
	foreach ($phoneList as $index => $phoneCode){
		$phoneIDQuery = "SELECT phoneID FROM phone WHERE decimalCode = " . $phoneCode;
		$result = mysql_query($phoneIDQuery) or die('Query failed: ' . mysql_error());
		//if no rows returned, there is no phone corresponding to the user-entered character
		if(mysql_num_rows($result) < 1){ die('You have entered a phone that does not exist in the database!');}
		$phoneID = mysql_fetch_row($result);
		$morpheme_phoneInsertQuery = "INSERT INTO morpheme_phone (morphemeID, phoneID, phoneSequenceNumber) VALUES(" . 
		$morphemeInsertID[0] . "," .
		$phoneID[0] . "," .
		$index . ")";
		//...and insert them into morpheme_phone in the correct order
		if(!$result = mysql_query($morpheme_phoneInsertQuery)){echo ('Query failed: ' . mysql_error()); mysql_query("ROLLBACK"); die();}
	}
	mysql_query("COMMIT");
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
//print a textarea
function input_textarea($element_name, $values) {
    print '<textarea name="' . $element_name .'"id="'.$element_name.'">';
    print htmlentities($values[$element_name]) . '</textarea>';
}
//print a radio button or checkbox
function input_radiocheck($type, $element_name, $values, $element_value){
    print '<input type="' . $type . '" name="' . $element_name .'" id="'.$element_name.'" value="' . $element_value . '"';
    if ($element_value == $values[$element_name]) {
        print ' checked="checked"';
    }
    print '/>';
}
//print a <select> menu
function input_select($element_name, $selected, $options, $multiple = false) {
    // print out the <select> tag
    print '<select name="' . $element_name.'"id="'.$element_name;
    // if multiple choices are permitted, add the multiple attribute
    // and add a [  ] to the end of the tag name
    if ($multiple) { print '[  ]" multiple="multiple'; }
    print '">';
    // set up the list of things to be selected
    $selected_options = array();
    if ($multiple) {
        foreach ($selected[$element_name] as $val) {
            $selected_options[$val] = true;
        }
    } else {
        $selected_options[ $selected[$element_name] ] = true;
    }
    // print out the <option> tags
    foreach ($options as $label => $option) {
        print '<option value="' . htmlentities($option) . '"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . htmlentities($label) . '</option>';
    }
    print '</select>';
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
	$ascee = array();
	for($i =65; $i < 128; $i++){
		$ascee[chr($i)] = "&#$i;";
	}
	return strtr($stringToEncode, $ascee);
}
//get list of existing lexical categories
function getExistingLexCats(){
$result=mysql_query("SELECT lexicalCategoryID, lexicalCategoryDescription FROM lexicalCategory") 
	or die('Query failed: ' . mysql_error());
while($lexcat = mysql_fetch_array($result, MYSQL_NUM)){
	$lexCats[$lexcat[1]] = $lexcat[0];
}
	$lexCats["None"] = -1;
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
mysql_free_result($result);
return $funcCats;
}

mysql_close($link);
?>
