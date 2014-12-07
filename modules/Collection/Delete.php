<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $currentModule;
$focus = CRMEntity::getInstance($currentModule);

$record = vtlib_purify($_REQUEST['record']);
$module = vtlib_purify($_REQUEST['module']);
$return_module = vtlib_purify($_REQUEST['return_module']);
$return_action = vtlib_purify($_REQUEST['return_action']);
$return_id = vtlib_purify($_REQUEST['return_id']);
$parenttab = getParentTab();

//Added to fix 4600
$url = getBasic_Advance_SearchURL();

$query = "SELECT vtiger_crmentity.*, vtiger_accountsreceivable.*, CASE WHEN (vtiger_users.user_name NOT LIKE '') THEN CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name) ELSE vtiger_groups.groupname END AS user_name, vtiger_accountsreceivablecf.* FROM vtiger_accountsreceivable INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_accountsreceivable.accountsreceivableid INNER JOIN vtiger_crmentityrel ON (vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid OR vtiger_crmentityrel.crmid = vtiger_crmentity.crmid) LEFT JOIN vtiger_accountsreceivablecf ON vtiger_accountsreceivablecf.accountsreceivableid = vtiger_accountsreceivable.accountsreceivableid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND (vtiger_crmentityrel.crmid = ? OR vtiger_crmentityrel.relcrmid = ?)";

$accounts_receivable = $adb->pquery( $query, array( $record, $record ) );
$numOfRecords = $adb->num_rows($accounts_receivable);


$arIds = array();
for ($i = 0; $i < $numOfRecords; $i++) {
	$id = $adb->query_result( $accounts_receivable, $i, 'accountsreceivableid' );
	$arIds[$i] = $id;
}

$clQuery = "select * from vtiger_collectionlogs
	inner join vtiger_crmentity on vtiger_collectionlogs.collectionlogsid = vtiger_crmentity.crmid
	where deleted = 0 and collection_no =".$record." and ar_no in (".implode(',',$arIds).")";

$ar = CRMEntity::getInstance('AccountsReceivable');
$cl = CRMEntity::getInstance('CollectionLogs');

$collection_logs = $adb->pquery( $clQuery, array() );
$numOfRecords = $adb->num_rows($collection_logs);
for ($i = 0; $i < $numOfRecords; $i++) {

	$id = $adb->query_result( $collection_logs, $i, 'collectionlogsid' );
	$arId = $adb->query_result( $collection_logs, $i, 'ar_no' );

	$cl->setColumns( 'CollectionLogs' );
	$cl->retrieve_entity_info($id, 'CollectionLogs' );
	$cl->id = $id;
	$amount = $cl->column_fields['amount'];
	$ewt = $cl->column_fields['ewt'];
	$bc = $cl->column_fields['bc'];

	$ar->setColumns( 'AccountsReceivable' );
	$ar->retrieve_entity_info($arId, 'AccountsReceivable' );
	$ar->id = $arId;
	$ar->mode = 'edit';
	$ar->column_fields['payment'] = $ar->column_fields['payment'] - $amount;
	$ar->column_fields['awt'] = $ar->column_fields['awt'] - $ewt;
	$ar->column_fields['bc'] = $ar->column_fields['bc'] - $bc;

	$ar->save('AccountsReceivable');
	DeleteEntity('CollectionLogs', '', $cl, $id, '');
}

$focus = CRMEntity::getInstance($currentModule);
$focus->retrieve_entity_info($record, $currentModule);
$focus->id = $record;
$focus->delete_related_module($currentModule, $record, 'AccountsReceivable', $arIds);

$arCheckQuery = "select * from vtiger_archecks
	inner join vtiger_crmentity on vtiger_archecks.archecksid = vtiger_crmentity.crmid
	where deleted = 0 and collection_no = ".$record." ";

$arChecks = $adb->pquery( $arCheckQuery, array() );
$numOfRecords = $adb->num_rows($arChecks);

$arc = CRMEntity::getInstance('ARChecks');
$arc->setColumns( 'ARChecks' );

for ($i = 0; $i < $numOfRecords; $i++) {
	$id = $adb->query_result( $arChecks, $i, 'archecksid' );
	$arc->retrieve_entity_info($id,'ARChecks');
	DeleteEntity('ARChecks','',$arc,$id,'');
}

DeleteEntity($currentModule, $return_module, $focus, $record, $return_id);

header("Location: index.php?module=$return_module&action=$return_action&record=$return_id&parenttab=$parenttab&relmodule=$module".$url);

?>