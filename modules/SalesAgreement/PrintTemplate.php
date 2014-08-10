<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->assign('MODULE', $currentModule);

$id = $_REQUEST['record'];

$query = "select * from vtiger_salesagreement
		  inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_salesagreement.salesagreementid
		  inner join vtiger_shcontacts on vtiger_shcontacts.shcontactsid = vtiger_salesagreement.customer
		  where deleted =0 and salesagreementid =".$id;
		  
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();
if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data['sa_no'] = $adb->query_result($result, 0, "sa_no");
	$data['details'] = $adb->query_result($result, 0, "details");
	$data['quantity'] = $adb->query_result($result, 0, "quantity");
	$data['pax'] = $adb->query_result($result, 0, "pax");
	$data['contact'] =  $adb->query_result($result, 0, "firstname").' '. $adb->query_result($result, 0, "lastname");
	$data['af'] = $adb->query_result($result, 0, "fee") + $adb->query_result($result, 0, "mark_up");
	$data['sf'] = $adb->query_result($result, 0, "service_fee");
	$data['vat'] = $adb->query_result($result, 0, "vat");
	$data['vatsale'] = $adb->query_result($result, 0, "vatable_sale");
	$data['gt'] = $adb->query_result($result, 0, "grand_total");
	$data['rate_per_pax'] = $adb->query_result($result, 0, "rate_per_pax");
	$data['date'] = date("F j, Y", strtotime( $adb->query_result($result, $i, "modifiedtime") ) );
}


$smarty->assign('DATA', $data);
$smarty->display('ReportTemplates/salesagreement/template'.$_REQUEST["template"].'.tpl');

?>