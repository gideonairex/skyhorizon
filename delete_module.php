<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Module.php');
$mod_name = 'PO';
// foreach($mod_names as $mod_name){
	// echo "deleting ".$mod_name;
$module = Vtiger_Module::getInstance($mod_name);
echo "12123";
if($module) {
	echo "awdawd";
	$module->delete();
}
// }

?>