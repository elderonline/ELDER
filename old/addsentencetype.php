<script type='text/javascript'>
function addSentenceTypeValidator(){
	return true;
}
</script>

<?php
//Page for Entry of a Sentence Type
$link = connectToDB();
echo "<h1>Enter a new sentence type</h1>";
require_once ('navheader.php');


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

<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return addSentenceTypeValidator()'>

<table>
<tr><td>Description:</td>
<td><?php input_text('sentenceTypeDescription', $defaults) ?></td></tr>
<tr><td colspan="2" align="center"><?php input_submit('sentTypeAdd','Add Sentence Type'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php 
}

function process_form(){
	$functionalCategoryInsertQuery = "INSERT INTO sentenceType (sentenceTypeDescription) VALUES('" . 
		mysql_real_escape_string($_POST['sentenceTypeDescription']) . "')";
	$result = mysql_query($functionalCategoryInsertQuery) or die('Query failed: ' . mysql_error());
}
//print a submit button
function input_submit($element_name, $label) {
    print '<input type="submit" name="' . $element_name .'"id="'.$element_name.'" value="';
    print htmlentities($label) .'"/>';
}
//print a text field
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print htmlentities($values[$element_name]) . '">';
}
?>