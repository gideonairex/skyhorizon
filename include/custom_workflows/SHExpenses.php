<?php
function createAP($entity){

	require_once ("modules/AccountsPayable/AccountsPayable.php");
	$ap_obj = new AccountsPayable();
	$ap_obj->setColumns('AccountsPayable');

		
	$assigned_user_id = explode('x',$entity->data['assigned_user_id']);
	$id = explode('x',$entity->data['id']);
	
	
	$ap_obj->column_fields['assigned_user_id'] = $assigned_user_id[1];
	$ap_obj->column_fields['payable_no'] = $id[1];
	
	$ap_obj->column_fields['ap_status'] = 'Pending'; 
	$ap_obj->column_fields['payable'] = $entity->data['cost']; 
	
	$ap_obj->save('AccountsPayable');
	
}
?>