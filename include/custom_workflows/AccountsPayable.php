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
	if( $ap_obj->column_fields['ap_status'] != 'Pending for clearance' ) {
		$ap_obj->column_fields['ap_status'] = $status;
		$ap_obj->saveentity('AccountsPayable');
	}

}

function deleteAP($entity){

	global $adb;

	$po_no = explode('x',$entity->data['id']);
	$query = "select * from vtiger_crmentity
		inner join vtiger_accountspayable on vtiger_crmentity.crmid = vtiger_accountspayable.accountspayableid
		where payable_no = ".$po_no[1]." and deleted = 0";

	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		$apid= $adb->query_result($result, 0, "accountspayableid");
	}

	require_once ("modules/AccountsPayable/AccountsPayable.php");
	$ap_obj = new AccountsPayable();
	DeleteEntity('AccountsPayable', 'AccountsPayable', $ap_obj, $apid, '');

}
?>