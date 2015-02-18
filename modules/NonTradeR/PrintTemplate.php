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

$query = "select * from vtiger_nontrader
		  inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_nontrader.nontraderid
		  where deleted =0 and nontraderid =".$id;
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();

if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data['ntr_no'] = $adb->query_result($result, 0, "ntr_no");
	$data['ntr_type'] = $adb->query_result($result, 0, "ntr_type");
	$data['other'] = $adb->query_result($result, 0, "other");
	$data['ntr_currency'] = $adb->query_result($result, 0, "ntr_currency");
	$data['supplier'] = $adb->query_result($result, 0, "supplier");
	$data['ntr_status'] = $adb->query_result($result, 0, "ntr_status");
	$data['receivable'] = $adb->query_result($result, 0, "receivable");
	$data['particulars'] = $adb->query_result($result, 0, "particulars");
	$data['user'] =  $users[$adb->query_result($result, 0, "smownerid")];
	$data['total'] = $data['receivable'] + $data['other'];
	$data['date'] = date("F j, Y", strtotime( $adb->query_result($result, 0, "createdtime") ) );
}


$query = 'select * from vtiger_shsupplier where shsupplierid = ' . $data[ 'supplier' ];
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data[ 'supplier' ] = $adb->query_result( $result, 0, "supplier_name" );

$smarty->assign('DATA', $data);
$smarty->display('ReportTemplates/nontrader/template'.$_REQUEST["template"].'.tpl');

?>
