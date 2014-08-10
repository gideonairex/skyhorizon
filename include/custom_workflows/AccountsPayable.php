<?php
function updateStatus($entity){
	
	$payment = $entity->data['payment'] + $entity->data['ewt'];
	
	
	if( $payment == 0 ){
		$status = 'Unpaid';
	}else{
		$status = 'Paid';
		
		if( $payment < $entity->data['payable'] ){
			$status = 'Partial'; 
		}
	
	}
	
	require_once ("modules/AccountsPayable/AccountsPayable.php");
	$ap_obj = new AccountsPayable();
	$ap_obj->setColumns('AccountsPayable');
	$id = explode('x',$entity->data['id']);
	
	$ap_obj->mode = 'edit';
	$ap_obj->id = $id[1];
	$ap_obj->retrieve_entity_info($id[1], 'AccountsPayable');
	$ap_obj->column_fields['ap_status'] = $status;
	
	$ap_obj->saveentity('AccountsPayable');

}
?>