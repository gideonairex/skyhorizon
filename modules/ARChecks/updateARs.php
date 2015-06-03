<?php
require_once ("modules/AccountsReceivable/AccountsReceivable.php");
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

$query = 'select * from vtiger_accountsreceivable
			inner join vtiger_crmentity on vtiger_accountsreceivable.accountsreceivableid = vtiger_crmentity.crmid
			where deleted = 0 and ar_status ="Pending for clearance"';
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);

if($num_rows > 0){

	for( $i = 0 ; $i < $num_rows; $i++){
		$data[$i] = $adb->query_result($result, $i, "accountsreceivableid");
	}

	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');
	$ar_obj->mode = 'edit';

	for ($i = 0; $i < count($data); $i++) {

		$id = $data[ $i ];
		$ar_obj->id = $id;
		$ar_obj->retrieve_entity_info($id, 'AccountsReceivable');

		$payment = $ar_obj->column_fields['payment'] + $ar_obj->column_fields['awt'];
		if( $payment == 0 ){
			$status = 'Unpaid';
		}else{
			$status = 'Paid';
			if( $payment < $ar_obj->column_fields['sales'] ){
				$status = 'Partial';
			}
		}

		$ar_obj->column_fields['ap_status'] = $status;
		$ar_obj->save('AccountsReceivable');
	}
}

?>
