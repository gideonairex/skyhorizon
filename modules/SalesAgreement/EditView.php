<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user;
require_once 'modules/Vtiger/EditView.php';

if($focus->column_fields['sa_status'] == 'Approved' && $current_user->roleid == RESERVATION ) {
	echo "Contact Admin or Supervisor to enable edit";
	die();
}

if($focus->mode == 'edit') {
	$smarty->display('salesEditView.tpl');
} else {
	$smarty->display('CreateView.tpl');
}

?>