<?php
global $adb;

$tobeCleaned = array(
'SHAccounts',
'SHContacts',
'SalesAgreement',
'PO',
'SHExpenses',
'SHSupplier',
'PP',
'ModComments',
'CBR',
'Hotel',
'EdTour',
'Others',
'AdminCost',
'VisaA',
'IAT',
'DAT',
'AccountsReceivable',
'Collection',
'AccountsPayable',
'Disbursement',
'Documents'
);

$db = PearDatabase::getInstance();

$db->startTransaction();

foreach($tobeCleaned as $key => $modules){
	$query = "delete from vtiger_".strtolower($modules);
	$db->pquery($query,array());
	$query2 = "delete from vtiger_".strtolower($modules)."cf";
	$db->pquery($query2,array());
}

$delete_crmentity = "delete from vtiger_crmentity where setype in('".implode("','",$tobeCleaned)."')";
$db->pquery($delete_crmentity,array());
$delete_crmentityrel = "delete from vtiger_crmentityrel";
$db->pquery($delete_crmentityrel,array());

$db->println("Succesful Clean Up");
?>
