<script type='text/javascript'>
function manageSimpleDataValidator(){
	return true;
}
</script>
<?php
session_start();
//Page for Managing Semantic Fields
require_once ('formdisplayhelperfunctions.php');
$link = connectToDB();
require_once ('titletop.php');
require_once ('navheaderside.php');

echo "<div class=\"Content\">";
//###########################MAIN LOGIC###################
if ($_POST['_submit_check']){
	//We now validate server-side that the submission is correct before processing; if it is not, we show the user the form again with an error message
	if(true){
		//process the submitted data
		process_manageSemanticField_form();
		$dataSetToManage = array_flip(getExistingSemanticFields());
		show_manageSimpleData_form($dataSetToManage);
	}
	else{
		$_POST['_submit_check'] = 0;
		$errorMessage = "A problem has occurred due to the data in your submission.  Please recheck and resubmit.";
		show_manageSimpleData_form($dataSetToManage);
	}
		
}
else{
	// The form wasn't submitted, so display
	$dataSetToManage = array_flip(getExistingSemanticFields());
	show_manageSimpleData_form($dataSetToManage);
}
//###################################END MAIN LOGIC####################################
echo "</div>";