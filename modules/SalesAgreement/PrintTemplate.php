<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->assign('MODULE', $currentModule);

$id = $_REQUEST['record'];

$query = "select * from vtiger_salesagreement
		  inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_salesagreement.salesagreementid
		  inner join vtiger_shcontacts on vtiger_shcontacts.shcontactsid = vtiger_salesagreement.customer
			inner join vtiger_shaccounts on vtiger_shaccounts.shaccountsid = vtiger_shcontacts.company
		  where deleted =0 and salesagreementid =".$id;
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();
if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data['sa_no'] = $adb->query_result($result, 0, "sa_no");
	$data['account_name'] = $adb->query_result($result, 0, "account_name");
	$data['details'] = nl2br( $adb->query_result($result, 0, "details") );
	$data['quantity'] = $adb->query_result($result, 0, "quantity");
	$data['pax'] = nl2br ( $adb->query_result($result, 0, "pax") );
	$data['contact'] =  $adb->query_result($result, 0, "firstname").' '. $adb->query_result($result, 0, "lastname");
	$data['af'] = $data['quantity'] * ( $adb->query_result($result, 0, "fee") + $adb->query_result($result, 0, "mark_up") );
	$data['sf'] = $adb->query_result($result, 0, "service_fee");
	$data['vat'] = $data['quantity'] * $adb->query_result($result, 0, "vat");
	$data['vatsale'] = $data['quantity'] * $adb->query_result($result, 0, "vatable_sale");
	$data['gt'] = $adb->query_result($result, 0, "grand_total");
	$data['conversion'] = $adb->query_result($result, 0, "conversion");
	$data['rate_per_pax'] = $adb->query_result($result, 0, "rate_per_pax");
	$data['date'] = date("F j, Y", strtotime( $adb->query_result($result, 0, "createdtime") ) );
	$data['main'] = $adb->query_result($result,0,"main");
	$data['branch'] = '';
}

$query = "select * from vtiger_shaccounts
					inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_shaccounts.shaccountsid
					where deleted = 0 and shaccountsid = ?";
$result = $adb->pquery($query,array($data['main']));
$main_branch = "";
$num_rows = $adb->num_rows($result);
if($num_rows > 0){
	$data['branch'] = $data['account_name'];
	$data['account_name'] = $adb->query_result($result,0,"account_name");
}

$smarty->assign('DATA', $data);
$smarty->display('ReportTemplates/salesagreement/template'.$_REQUEST["template"].'.tpl');

?>