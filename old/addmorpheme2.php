<script type='text/javascript'>
function addMorphemeValidator(){
	return true;
}
</script>

<?php
/* Page for Entry of a Morpheme
Pseudocode:
populate lists of funccats and lexcats
get data (meaning, description, phone list, lexcat, func cat) from user form
select phoneID's from phone matching the ones input by the user
if func cat entered
	check for func cat:
		if present, get ID
		if not, ask user if addition required
			if so, reject form and go to funccat entrance page in new tab
			if not, warn user that morpheme will have no associated func cat and continue
if lex cat entered
	check for lex cat:
		if present, get ID
		if not, ask user if addition required
			if so, reject form and go to lexcat entrance page in new tab
			if not, warn user that morpheme will have no associated lex cat and continue
perform SQL update
go to page showing result
*/
$link = connectToDB();
echo "Connected successfully\n";

//get list of existing lexical categories
$lexCats = array();
$result=mysql_query("SELECT lexicalCategoryDescription, lexicalCategoryID FROM lexicalCategory") 
	or die('Query failed: ' . mysql_error());
while($lexcat = mysql_fetch_array($result, MYSQL_NUM)){
	$lexCats[$lexcat[0]] = $lexcat[1];
}
	$lexCats['None'] = -1;
mysql_free_result($result);

//get list of existing functional categories
$funcCats = array();
$result=mysql_query("SELECT functionalCategoryDescription, functionalCategoryID FROM functionalCategory");
while($funccat = mysql_fetch_array($result, MYSQL_NUM)){
	$funcCats[$funccat[0]] = $funccat[1];
}
	$funcCats['None'] = -1;
mysql_free_result($result);

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
<td><?php input_select('morphemeLexicalCategory', $defaults, $lexCats); ?>
</td>
<td>Functional category:</td>
<td><?php input_select('morphemeFunctionalCategory', $defaults, $funcCats); ?>
</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('morphemeAdd','Add Morpheme'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php }
//Do the work of the SQL inserts using submitted data
function process_form(){
}
//print a text box
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print htmlentities($values[$element_name]) . '">';
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
    foreach ($options as $option => $label) {
        print '<option value="' . htmlentities($option) . '"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>' . htmlentities($label) . '</option>';
    }
    print '</select>';
}
//print a submit button
function input_submit($element_name, $label) {
    print '<input type="submit" name="' . $element_name .'"id="'.$element_name.'" value="';
    print htmlentities($label) .'"/>';
}
?>
