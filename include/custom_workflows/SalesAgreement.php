<?php
function createAR($entity){

	global $adb;
	
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');

	$assigned_user_id = explode('x',$entity->data['assigned_user_id']);
	$id = explode('x',$entity->data['id']);
	
	$query = "select * from vtiger_accountsreceivable
			  inner join vtiger_crmentity on vtiger_accountsreceivable.accountsreceivableid = vtiger_crmentity.crmid
			  where deleted = 0 and vtiger_accountsreceivable.sales_no = ".$id[1];
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	
	if( $num_rows >= 1){
		$ar_obj->mode = 'edit';
		$ar_obj->id = $adb->query_result( $result, 0 , 'accountsreceivableid');
	}
	
	$ar_obj->column_fields['assigned_user_id'] = $assigned_user_id[1];
	$ar_obj->column_fields['sales_no'] = $id[1];
	$ar_obj->column_fields['ar_status'] = 'Pending'; 
	$ar_obj->column_fields['sales'] = $entity->data['grand_total']; 
	$ar_obj->column_fields['pax'] = $entity->data['pax']; 
	
	$customer = explode('x',$entity->data['customer']);
	$ar_obj->column_fields['contact'] = $customer[1]; 
	
	$query = "select * from vtiger_shcontacts
			  inner join vtiger_crmentity on vtiger_shcontacts.shcontactsid = vtiger_crmentity.crmid
			  where deleted = 0 and vtiger_shcontacts.shcontactsid = ".$customer[1];
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	
	if( $num_rows >= 1){
		$ar_obj->column_fields['account'] = $adb->query_result( $result, 0 , 'company');
	}
	
	$ar_obj->save('AccountsReceivable');
	
}
?>