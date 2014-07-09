<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');

$products = Vtiger_Module::getInstance('Collection');
//$products->setRelatedList(Vtiger_Module::getInstance('ED'),'ED',Array('add','select'));
$products->setRelatedList(Vtiger_Module::getInstance('ARChecks'), 'ARChecks',Array('ADD'));


?>