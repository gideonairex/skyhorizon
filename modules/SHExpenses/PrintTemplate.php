<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->assign('MODULE', $currentModule);


$query = 'select * from vtiger_users where status= "Active"';
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$users = array();

for( $i = 0 ; $i < $num_rows; $i++){
	$users[$adb->query_result($result, $i, "id")] = $adb->query_result($result, $i, "first_name").' '.$adb->query_result($result, $i, "last_name");
}


$id = $_REQUEST['record'];

$query = "select * from vtiger_shexpenses
		  inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_shexpenses.shexpensesid
		  where deleted =0 and shexpensesid =".$id;
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();

if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data['expense_no'] = $adb->query_result($result, 0, "expense_no");
	$data['expense_name'] = $adb->query_result($result, 0, "expense_name");
	$data['cost'] = $adb->query_result($result, 0, "cost");
	$data['expense_status'] = $adb->query_result($result, 0, "expense_status");
	$data['expense_type'] = $adb->query_result($result, 0, "expense_type");
	$data['ntp_currency'] = $adb->query_result($result, 0, "ntp_currency");
	$data['user'] =  $users[$adb->query_result($result, 0, "smownerid")];
	$data['date'] = date("F j, Y", strtotime( $adb->query_result($result, 0, "modifiedtime") ) );
}

$smarty->assign('DATA', $data);
$smarty->display('ReportTemplates/shexpenses/template'.$_REQUEST["template"].'.tpl');

?>