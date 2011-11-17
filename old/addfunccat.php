<script type='text/javascript'>
function addFunctionalCategoryValidator(){
	return true;
}
</script>

<?php
//Page for Entry of a Functional Category
$link = connectToDB();
echo "<h1>Enter a new functional category</h1>";
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

<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return addMorphemeValidator()'>

<table>
<tr><td>Description:</td>
<td><?php input_text('functionalCategoryDescription', $defaults) ?></td></tr>
<tr><td colspan="2" align="center"><?php input_submit('funccatAdd','Add Functional Category'); ?>
</td></tr>
</table>

<input type="hidden" name="_submit_check" value="1"/>

</form>
<?php 
}

function process_form(){
	$functionalCategoryInsertQuery = "INSERT INTO functionalCategory (functionalCategoryDescription) VALUES('" . 
		mysql_real_escape_string($_POST['functionalCategoryDescription']) . "')";
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