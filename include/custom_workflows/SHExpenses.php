<?php
function createAP($entity){

	global $adb;
	
	require_once ("modules/AccountsPayable/AccountsPayable.php");
	$ap_obj = new AccountsPayable();
	$ap_obj->setColumns('AccountsPayable');

		
	$assigned_user_id = explode('x',$entity->data['assigned_user_id']);
	$id = explode('x',$entity->data['id']);
	
	$query = "select * from vtiger_accountspayable
			  inner join vtiger_crmentity on vtiger_accountspayable.accountspayableid = vtiger_crmentity.crmid
			  where deleted = 0 and vtiger_accountspayable.payable_no = ".$id[1];
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	
	if( $num_rows >= 1){
		$ap_obj->mode = 'edit';
		$ap_obj->id = $adb->query_result( $result, 0 , 'accountspayableid');
	}
	
	$supplier_id = explode('x',$entity->data['expense_name']);
	
	$ap_obj->column_fields['assigned_user_id'] = $assigned_user_id[1];
	$ap_obj->column_fields['payable_no'] = $id[1];
	$ap_obj->column_fields['supplier'] = $supplier_id[1];
	$ap_obj->column_fields['payable'] = $entity->data['cost']; 
	$ap_obj->column_fields['conversion_ap'] = 'PHP'; 
	$ap_obj->save('AccountsPayable');
	
}
?>