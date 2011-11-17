<script type='text/javascript'>
function searchPhoneValidator(){
	return true;
}
</script>

<?php
// Connecting.  Params are hostname, username, password
$link = mysql_connect('localhost', 'AKBelew', 'connor')
    or die('Could not connect: ' . mysql_error());
echo "<h1>Search for a phone</h1>";


//#########################MAIN LOOP
if ($_POST['_submit_check']){
		//process the submitted data
		process_form();
}
else{
	// The form wasn't submitted, so display
	show_form();
}
//########################END MAIN LOOP

function show_form(){
	?>
	<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" onsubmit='return searchPhoneValidator()'>

	<table>
	<tr><td>Description (any part):</td>
	<td><?php input_text('phoneDescription', $defaults) ?></td></tr>

	<tr><td>IPA symbol:</td>
	<td><?php input_text('phoneSymbol', $defaults) ?></td><td><?php echo "(If more than one entered, first will be used.)";?></td></tr>

	<tr><td colspan="2" align="center"><?php input_submit('phoneSearch','Search'); ?>
	</td></tr>
	</table>

	<input type="hidden" name="_submit_check" value="1"/>

	</form>
	<?php
}

function process_form(){
	$searchPhoneQuery = "SELECT phoneDescription, decimalCode FROM phone WHERE phoneDescription LIKE '%" . 
	mysql_real_escape_string($_POST['phoneDescription']) . "%'";
	if($_POST['phoneSymbol']){
		$phoneCode = phonesToInts($_POST['phoneSymbol']);
		$searchPhoneQuery .=  " AND decimalCode = " . $phoneCode[0];
	}
	//query is ready; now perform it
	$result = mysql_query($searchPhoneQuery) or die('Query failed: ' . mysql_error());
	
	 //Print results in HTML
	echo "<table>\n";
	while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
		echo "\t<tr>\n";
			echo "\t\t<td>&#".$row['decimalCode'].";</td>\n";
			echo "\t\t<td>".$row['phoneDescription']."</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";

// Free resultset
	mysql_free_result($result);
}

// Closing connection
mysql_close($link);

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
?>
