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

$query = "select * from vtiger_po
		  inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_po.poid
		  inner join vtiger_shsupplier on vtiger_po.suplier = vtiger_shsupplier.shsupplierid
		  inner join vtiger_accountspayable on vtiger_po.poid = vtiger_accountspayable.payable_no
		  where deleted =0 and poid =".$id;
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();

if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data['po_no'] = $adb->query_result($result, 0, "po_no");
	$data['pax'] = $adb->query_result($result, 0, "pax");
	$data['no_of_pax'] = $adb->query_result($result, 0, "no_of_pax");
	$data['description'] = $adb->query_result($result, 0, "description");
	$data['supplier'] =  $adb->query_result($result, 0, "supplier_name");
	$data['discount'] =  $adb->query_result($result, 0, "discount");
	$data['cost'] =  $adb->query_result($result, 0, "cost");
	$data['discount'] =  $adb->query_result($result, 0, "discount");
	$data['service_fee'] =  $adb->query_result($result, 0, "service_fee");
	$data['rate_per_pax'] =  $adb->query_result($result, 0, "rate_per_pax");
	$data['grand_total'] =  $adb->query_result($result, 0, "grand_total");
	$data['date'] = date("F j, Y", strtotime( $adb->query_result($result, 0, "modifiedtime") ) );
	$data['conversion_po'] =  $adb->query_result($result, 0, "conversion_po");
	$data['confirmation'] = $adb->query_result($result, 0, "confirmation");
	$data['user'] =  $users[$adb->query_result($result, 0, "smownerid")];
	if ( $data['confirmation'] == ''){
		$data['confirmation'] = 'Not Confirmed';
	}
}


$smarty->assign('DATA', $data);
$smarty->display('ReportTemplates/po/template'.$_REQUEST["template"].'.tpl');

?>