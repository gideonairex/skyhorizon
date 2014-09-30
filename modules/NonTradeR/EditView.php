<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $adb;
if( $_REQUEST['po_no'] ){
	$query = "select * from vtiger_po
						inner join vtiger_crmentity on vtiger_po.poid = vtiger_crmentity.crmid
						where deleted = 0 and poid=".$_REQUEST['po_no'];
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if( $num_rows >= 1){
		$supplier_id = $adb->query_result($result,0,'suplier');
		$_REQUEST['supplier'] = $supplier_id;
	}
}
require_once 'modules/Vtiger/EditView.php';
if($focus->mode == 'edit') {
	$smarty->display('salesEditView.tpl');
} else {
	$smarty->display('CreateView.tpl');
}

?>