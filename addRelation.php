<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');

$products = Vtiger_Module::getInstance('SHAccounts');
//$products->setRelatedList(Vtiger_Module::getInstance('ED'),'ED',Array('add','select'));
$products->setRelatedList(Vtiger_Module::getInstance('SHContacts'), 'SHContacts',Array('ADD'));


?>