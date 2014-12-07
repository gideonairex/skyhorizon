<?php
//error_reporting( E_ALL );
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $currentModule;

$record = vtlib_purify($_REQUEST['record']);
$module = vtlib_purify($_REQUEST['module']);
$return_module = vtlib_purify($_REQUEST['return_module']);
$return_action = vtlib_purify($_REQUEST['return_action']);
$return_id = vtlib_purify($_REQUEST['return_id']);
$parenttab = getParentTab();

//Added to fix 4600
$url = getBasic_Advance_SearchURL();

$query = "SELECT vtiger_crmentity.*, vtiger_accountspayable.*, CASE WHEN (vtiger_users.user_name NOT LIKE '') THEN CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name) ELSE vtiger_groups.groupname END AS user_name, vtiger_accountspayablecf.* FROM vtiger_accountspayable INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_accountspayable.accountspayableid INNER JOIN vtiger_crmentityrel ON (vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid OR vtiger_crmentityrel.crmid = vtiger_crmentity.crmid) LEFT JOIN vtiger_accountspayablecf ON vtiger_accountspayablecf.accountspayableid = vtiger_accountspayable.accountspayableid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND (vtiger_crmentityrel.crmid = ? OR vtiger_crmentityrel.relcrmid = ?)";

$accounts_payable = $adb->pquery( $query, array( $record, $record ) );
$numOfRecords = $adb->num_rows($accounts_payable);


$apIds = array();
for ($i = 0; $i < $numOfRecords; $i++) {
	$id = $adb->query_result( $accounts_payable, $i, 'accountspayableid' );
	$apIds[$i] = $id;
}

$dlQuery = "select * from vtiger_disbursementlogs
	inner join vtiger_crmentity on vtiger_disbursementlogs.disbursementlogsid = vtiger_crmentity.crmid
	where deleted = 0 and disbursement =".$record." and ap_no in (".implode(',',$apIds).")";

$ap = CRMEntity::getInstance('AccountsPayable');
$dl = CRMEntity::getInstance('DisbursementLogs');

$disbursement_logs = $adb->pquery( $dlQuery, array() );
$numOfRecords = $adb->num_rows($disbursement_logs);
for ($i = 0; $i < $numOfRecords; $i++) {
	$id = $adb->query_result( $disbursement_logs, $i, 'disbursementlogsid' );
	$apId = $adb->query_result( $disbursement_logs, $i, 'ap_no' );

	$dl->setColumns( 'DisbursementLogs' );
	$dl->retrieve_entity_info($id, 'DisbursementLogs' );
	$dl->id = $id;
	$amount = $dl->column_fields['amount'];
	$ewt = $dl->column_fields['ewt'];

	$ap->setColumns( 'AccountsPayable' );
	$ap->retrieve_entity_info($apId, 'AccountsPayable' );
	$ap->id = $apId;
	$ap->mode = 'edit';
	$ap->column_fields['payment'] = $ap->column_fields['payment'] - $amount;
	$ap->column_fields['ewt'] = $ap->column_fields['ewt'] - $ewt;

	$ap->save('AccountsPayable');
	DeleteEntity('DisbursementLogs', '', $dl, $id, '');
}
$focus = CRMEntity::getInstance($currentModule);
$focus->retrieve_entity_info($record, $currentModule);
$focus->id = $record;
$focus->delete_related_module($currentModule, $record, 'AccountsPayable', $apIds);

$apCheckQuery = "select * from vtiger_apchecks
	inner join vtiger_crmentity on vtiger_apchecks.apchecksid = vtiger_crmentity.crmid
	where deleted = 0 and disbursement_no = ".$record." ";

$apChecks = $adb->pquery( $apCheckQuery, array() );
$numOfRecords = $adb->num_rows($apChecks);

$apc = CRMEntity::getInstance('APChecks');
$apc->setColumns( 'APChecks' );

for ($i = 0; $i < $numOfRecords; $i++) {
	$id = $adb->query_result( $apChecks, $i, 'apchecksid' );
	$apc->retrieve_entity_info($id,'APChecks');
	DeleteEntity('APChecks','',$apc,$id,'');
}

DeleteEntity($currentModule, $return_module, $focus, $record, $return_id);

header("Location: index.php?module=$return_module&action=$return_action&record=$return_id&parenttab=$parenttab&relmodule=$module".$url);

?>