<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->display('Marion.tpl');
?>