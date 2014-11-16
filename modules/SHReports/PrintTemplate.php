<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->assign('MODULE', $currentModule);

$_REQUEST['mode'] = 'print';
require('modules/SHReports/Reports/'.$_REQUEST['report_name'].'.php');
require('modules/SHReports/TemplateMaker/'.$_REQUEST['report_name'].'.php');

if ( $_REQUEST['accounts'] != 0  &&  ( $_REQUEST['report_name'] == 'sales' || $_REQUEST['report_name'] == 'ar')  ){
	$query = 'select * from vtiger_shaccounts
			  inner join vtiger_crmentity on vtiger_shaccounts.shaccountsid = vtiger_crmentity.crmid
			  where deleted = 0 and ( shaccountsid = '.$_REQUEST['accounts'].' || main = '.$_REQUEST['accounts'].' )';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$account = array();
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		$account['account_name'] = $adb->query_result($result, 0, "account_name");
	}
	$smarty->assign('ACCOUNT', $account);
	$smarty->assign('SHOWLOGO', 'true');
}

$smarty->assign('DATA', $newData);

if( $_REQUEST['report_name'] == 'sales' ) {
	$smarty->display('ReportTemplates/'.$_REQUEST['salestemplate'].'.tpl');
} else {
	$smarty->display('ReportTemplates/'.$_REQUEST['artemplate'].'.tpl');
}

?>