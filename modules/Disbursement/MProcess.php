<?php
header('Content-Type: application/json');
global $adb;

if( $_REQUEST['func'] == 'searchAP'){
	switch ( $_REQUEST['filter'] ) {
		case 'ap_no':
			$filter = " vtiger_accountspayable.ap_no = '".$_REQUEST['searchString']."'";
			break;
		case 'supplier':
			$filter = " vtiger_shsupplier.supplier_name like '%".$_REQUEST['searchString']."%'";
			break;
		case 'payable_no':
			$filter = " ( vtiger_shexpenses.expense_no = '".$_REQUEST['searchString']."' ||  vtiger_po.po_no  = '".$_REQUEST['searchString']."' ) ";
			break;
		case 'amount':
			$preNumber = explode(",",$_REQUEST['searchString']);
			$amount = implode("",$preNumber);
			$number = explode(".",$amount);
			if( count($number) == 1){
				$amount = $amount.".00";
			}
			$filter = " vtiger_accountspayable.payable = '".$amount."'";
			break;
	}
	$query = 'select * from vtiger_accountspayable
			  inner join vtiger_crmentity on vtiger_accountspayable.accountspayableid = vtiger_crmentity.crmid
			  left join vtiger_shexpenses on vtiger_accountspayable.payable_no = vtiger_shexpenses.shexpensesid
			  left join vtiger_po on vtiger_accountspayable.payable_no = vtiger_po.poid
			  left join vtiger_shsupplier on  ( vtiger_po.suplier = vtiger_shsupplier.shsupplierid || vtiger_shexpenses.expense_name = vtiger_shsupplier.shsupplierid )
			  where vtiger_crmentity.deleted = 0 and '.$filter.' and ap_status in ("Unpaid","Partial") and conversion_ap="'.$_REQUEST['conversion'].'"';

	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['result'] = 1;
			$data[$i]['id'] = $adb->query_result($result, $i, "accountspayableid");
			$data[$i]['ap_no'] = $adb->query_result($result, $i, "ap_no");
			$data[$i]['payable_no'] = $adb->query_result($result, $i, "payable_no");
			$data[$i]['payable'] = $adb->query_result($result, $i, "payable");
			$data[$i]['payment'] = ( $adb->query_result($result, $i, "payment") ? $adb->query_result($result, $i, "payment") : 0 );
			$data[$i]['ewt'] = ( $adb->query_result($result, $i, "ewt")  ? $adb->query_result($result, $i, "ewt") : 0 );
			$data[$i]['balance'] = $data[$i]['payable'] - $data[$i]['payment'] - $data[$i]['ewt'];
			$data[$i]['ap_status'] = $adb->query_result($result, $i, "ap_status");
			//get per service type
			$data[$i]['conversion_ap'] = $adb->query_result($result, $i, "conversion_ap");
			$data[$i]['expense_no'] = $adb->query_result($result, $i, "expense_no");
			$data[$i]['po_no'] = $adb->query_result($result, $i, "po_no");
			$data[$i]['supplier_name'] = $adb->query_result($result, $i, "supplier_name");
			$data[$i]['supplier_id'] = $adb->query_result($result, $i, "shsupplierid");
			if( $data[$i]['expense_no'] == "") {
				$data[$i]['payable_no'] = $data[$i]['po_no'];
				$data[$i]['link'] = "index.php?action=DetailView&module=PO&record=".$adb->query_result($result, $i, "payable_no");
			} else {
				$data[$i]['payable_no'] = $data[$i]['expense_no'];
				$data[$i]['link'] = "index.php?action=DetailView&module=SHExpenses&record=".$adb->query_result($result, $i, "payable_no");
			}
		}
		echo json_encode($data);
	}

} else if( $_REQUEST['func'] == 'updateRelations' ){
	require_once ("modules/Disbursement/Disbursement.php");
	require_once ("modules/AccountsPayable/AccountsPayable.php");
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	require_once ("modules/APChecks/APChecks.php");


	$entityBody = file_get_contents('php://input');
	$data = json_decode($entityBody,true);
	$payment = 0;
	$ewt = 0;
	$apIds = array();
	$i = 0;
	foreach ( $data as $ap ){
		if ( $i == 0 ){
			$conversion = $ap['conversion_ap'];
			$i++;
		} else {
			if ( $ap['conversion_ap'] == $conversion ) {
				continue;
			} else {
				echo json_encode( array( 'error' => 'Should have the same conversions') );
				die();
			}
		}
	}

	// If offsets are available
	$os = 0;
	$dos = 0;
	if ( $_REQUEST['offsets'] ) {
		$offsets = json_decode( $_REQUEST['offsets'] );
		$ar = new AccountsReceivable();
		$ar->setColumns('AccountsReceivable');
		$ar->mode = 'edit';
		for( $i = 0; $i < count ($offsets) ; $i++ ) {
			$ar->id = $offsets[$i];
			$ar->retrieve_entity_info( $offsets[$i], 'AccountsReceivable' );
			$balance = $ar->column_fields['sales']
								- $ar->column_fields['payment']
								- $ar->column_fields['awt']
								- $ar->column_fields['bc'];
			$os += $balance;
		}
	}

	$dos = $os;

	$ap_obj = new AccountsPayable();
	$ap_obj->setColumns('AccountsPayable');
	$ap_obj->mode = 'edit';
	foreach ( $data as $ap ){

		$payment += $ap['current_payment'];
		$ewt += $ap['current_ewt'];
		$apIds[] = $ap['id'];
		$id = $ap['id'];
		$ap_obj->id = $id;
		$ap_obj->retrieve_entity_info($id, 'AccountsPayable');
		$ap_obj->column_fields['payment'] +=  $ap['current_payment'];
		$ap_obj->column_fields['ewt'] +=  $ap['current_ewt'];
		$ap_balance = $ap_obj->column_fields['payable'] - $ap_obj->column_fields['payment'] - $ap_obj->column_fields['ewt'];

		if( $os >= $ap_balance ) {
			$ap_obj->column_fields['payment'] += $ap_balance;
			$os -= $ap_balance;
		} else {
			$ap_obj->column_fields['payment'] += floatval($os);
			$os = 0;
		}

		$ap_obj->save('AccountsPayable');

	}
	// This is to add Offset in payments
	$payment += $dos;
	$focus = new Disbursement();
	$focus->column_fields = Array
							(
								"CreatedTime" => "",
								"ModifiedTime" => "",
								"assigned_user_id" => $_SESSION['authenticated_user_id'],
								"d_payment_method" => "Check",
								"payment" => $payment,
								"ewt" => $ewt,
								"conversion_d" => $conversion
							);
	$focus->save( 'Disbursement' );
	$return_id = $focus->id;
	$totalPayment = $payment + $ewt;
	$archeck_obj = new APChecks();
	$archeck_obj->setColumns('APChecks');
	$archeck_obj->column_fields = Array
								(
									"CreatedTime" => "",
									"ModifiedTime" => "",
									"assigned_user_id" => $_SESSION['authenticated_user_id'],
									"disbursement_no" => $focus->id,
									"check_no" => $_REQUEST['check_no'],
									"bank" => $_REQUEST['bank'],
									"date_of_check" =>  $_REQUEST['date_of_check'],
									"apchk_status" => "Released",
									"amount" => $totalPayment,
									"conversion_pc" => $conversion
								);
	$archeck_obj->save( 'APChecks' );

	$ar = new AccountsReceivable();
	$ar->setColumns('AccountsReceivable');
	$ar->mode = 'edit';
	for( $i = 0; $i < count ($offsets) ; $i++ ) {
		$ar->id = $offsets[$i];
		$ar->retrieve_entity_info( $offsets[$i], 'AccountsReceivable' );
		$balance = $ar->column_fields['sales']
							- $ar->column_fields['payment']
							- $ar->column_fields['awt']
							- $ar->column_fields['bc'];
		$ar->column_fields['payment'] += $balance;
		$ar->column_fields['disbursement'] = $focus->id;
		$ar->save( 'AccountsReceivable' );
	}

	if(!empty($data)) {
		$focus->save_related_module('Disbursement', $return_id, 'AccountsPayable', $apIds);
	}
	//echo json_encode($HTTP_RAW_POST_DATA);
	echo json_encode( array( 'id' => $focus->id ) );
} else if ($_REQUEST['func'] == 'addOffsets' ) {
	$entityBody = file_get_contents('php://input');
	$data = json_decode($entityBody,true);
	$aps = $data[0]['models'];

	$i = 0;
	foreach( $aps as $ap ) {
		if( $i > 0 ) {
			if( $supplier == $ap['supplier_id'] ) {
				$supplier = $ap['supplier_id'];
			} else {
				echo json_encode( array( 'error' => 'Should have the same Suppliers' ) );
				die();
			}
		} else {
			$supplier = $ap['supplier_id'];
		}
		$i++;
	}

	$query = "select * from vtiger_accountsreceivable
						inner join vtiger_crmentity on vtiger_accountsreceivable.accountsreceivableid = vtiger_crmentity.crmid
						inner join vtiger_nontrader on vtiger_nontrader.nontraderid = vtiger_accountsreceivable.sales_no
						where deleted = 0 and supploer =".$supplier;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$offsets = array();
	if( $num_rows > 0){
		for ( $i = 0; $i < $num_rows; $i++) {
			$offsets[$i]['ar_no'] = $adb->query_result($result,$i,'ar_no');
			$offsets[$i]['accountsreceivableid'] = $adb->query_result($result,$i,'accountsreceivableid');
			$offsets[$i]['id'] = $adb->query_result($result,$i,'accountsreceivableid');
			$offsets[$i]['ntr_no'] = $adb->query_result($result,$i,'ntr_no');
			$offsets[$i]['sales_no'] = $adb->query_result($result,$i,'sales_no');
			$offsets[$i]['offset'] = $adb->query_result($result,$i,'sales')
														- $adb->query_result($result,$i,'payment')
														- $adb->query_result($result,$i,'awt')
														- $adb->query_result($result,$i,'bc');
		}
	}
	echo json_encode($offsets);
}else{
	echo json_encode(array('error'=>'invalid action'));
}

exit();
?>
