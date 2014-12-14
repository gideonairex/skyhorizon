<?php
function updateReceivable($entity){
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

function deleteAR($entity){

	global $adb;

	$sales_no = explode('x',$entity->data['id']);
	$query = "select * from vtiger_crmentity
		inner join vtiger_accountsreceivable on vtiger_crmentity.crmid = vtiger_accountsreceivable.accountsreceivableid
		where sales_no = ".$sales_no[1]." and deleted = 0";

	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		$arid= $adb->query_result($result, 0, "accountsreceivableid");
	}

	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	$ar_obj = new AccountsReceivable();
	DeleteEntity('AccountsReceivable', 'AccountsReceivable', $ar_obj, $arid, '');

}
?>