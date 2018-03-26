<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');

$products = Vtiger_Module::getInstance('SHExpenses');
$products->setRelatedList(Vtiger_Module::getInstance('Documents'),'Documents',Array('add'));
//$products->setRelatedList(Vtiger_Module::getInstance('APChecks'), 'APChecks',Array('ADD'));
//$products->setRelatedList(Vtiger_Module::getInstance('CollectionLogs'), 'CollectionLogs',Array('ADD'));
//$products->setRelatedList(Vtiger_Module::getInstance('SHExpenses'), 'SHExpenses',Array('ADD'));
//$products->setRelatedList(Vtiger_Module::getInstance('DisbursementLogs'), 'DisbursementLogs',Array());

?>
