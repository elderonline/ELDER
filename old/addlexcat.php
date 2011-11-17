<script type='text/javascript'>
function addLexicalCategoryValidator(){
	return true;
}
</script>

<?php
//Page for Entry of a Lexical Category
$link = connectToDB();
echo "<h1>Enter a new lexical category</h1>";
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

<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return addLexicalCategoryValidator()'>

<table>
<tr><td>Description:</td>
<td><?php input_text('lexicalCategoryDescription', $defaults) ?></td></tr>
<tr><td colspan="2" align="center"><?php input_submit('lexcatAdd','Add Lexical Category'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php 
}

function process_form(){
	$lexicalCategoryInsertQuery = "INSERT INTO lexicalCategory (lexicalCategoryDescription) VALUES('" . 
		mysql_real_escape_string($_POST['lexicalCategoryDescription']) . "')";
	$result = mysql_query($lexicalCategoryInsertQuery) or die('Query failed: ' . mysql_error());
}
//print a submit button
function input_submit($element_name, $label) {
    print '<input type="submit" name="' . $element_name .'"id="'.$element_name.'" value="';
    print htmlentities($label) .'"/>';
}
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'"id="'.$element_name.'" value="';
    print htmlentities($values[$element_name]) . '">';
}
?>