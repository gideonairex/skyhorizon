<?php
function updateStatus($entity){
	
	$payment = $entity->data['payment'] + $entity->data['awt']  + $entity->data['bc'];
	
	
	if( $payment == 0 ){
		$status = 'Unpaid';
	}else{
		$status = 'Paid';
		
		if( $payment < $entity->data['sales'] ){
			$status = 'Partial'; 
		}
	
	}
	
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');
	$id = explode('x',$entity->data['id']);
	
	$ar_obj->mode = 'edit';
	$ar_obj->id = $id[1];
	$ar_obj->retrieve_entity_info($id[1], 'AccountsReceivable');
	$ar_obj->column_fields['ar_status'] = $status;
	
	$ar_obj->saveentity('AccountsReceivable');

}
?>