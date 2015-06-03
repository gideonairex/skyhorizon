<?php
require_once ("modules/AccountsPayable/AccountsPayable.php");
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

$query = 'select * from vtiger_accountspayable
			inner join vtiger_crmentity on vtiger_accountspayable.accountspayableid = vtiger_crmentity.crmid
			where deleted = 0 and ap_status ="Pending for clearance"';
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);

if($num_rows > 0){

	for( $i = 0 ; $i < $num_rows; $i++){
		$data[$i] = $adb->query_result($result, $i, "accountspayableid");
	}

	$ap_obj = new AccountsPayable();
	$ap_obj->setColumns('AccountsPayable');
	$ap_obj->mode = 'edit';

	for ($i = 0; $i < count($data); $i++) {

		$id = $data[ $i ];
		$ap_obj->id = $id;
		$ap_obj->retrieve_entity_info($id, 'AccountsPayable');

		$payment = $ap_obj->column_fields['payment'] + $ap_obj->column_fields['ewt'];
		if( $payment == 0 ){
			$status = 'Unpaid';
		}else{
			$status = 'Paid';
			if( $payment < $ap_obj->column_fields['payable'] ){
				$status = 'Partial';
			}
		}

		$ap_obj->column_fields['ap_status'] = $status;
		$ap_obj->save('AccountsPayable');
	}
}

?>
