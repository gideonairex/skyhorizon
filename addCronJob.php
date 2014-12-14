<?php
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Cron.php');

Vtiger_Cron::register( 'UpdateChecks', 'cron/modules/APChecks/APChecks.service',60,'APChecks');

?>
