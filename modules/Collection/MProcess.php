<?php
header('Content-Type: application/json');
global $adb;

if( $_REQUEST['func'] == 'searchAR'){
	
	switch ($_REQUEST['filter']) {
		case 'arno':
			$filter = " vtiger_accountsreceivable.ar_no = '".$_REQUEST['searchString']."'";
			break;
		case 'amount':
			$preNumber = explode(",",$_REQUEST['searchString']);
			$amount = implode("",$preNumber);
			$number = explode(".",$amount);
			
			if( count($number) == 1){
				$amount = $amount.".00";
			}
			$filter = " vtiger_accountsreceivable.sales = '".$amount."'";
			break;
		case 'accountname':
			$filter = " vtiger_shaccounts.account_name like '%".$_REQUEST['searchString']."%'";
			break;
		case 'name':
			$filter = " pax like '%".$_REQUEST['searchString']."%'";
			break;
		case 'contact':
			$filter = " vtiger_shcontacts.firstname like '%".$_REQUEST['searchString']."%' || vtiger_shcontacts.lastname like '%".$_REQUEST['searchString']."%' ";
			break;
	}
	
	$query = 'select * from vtiger_accountsreceivable 
			  inner join vtiger_crmentity on vtiger_accountsreceivable.accountsreceivableid = vtiger_crmentity.crmid
			  inner join vtiger_salesagreement on vtiger_accountsreceivable.sales_no = vtiger_salesagreement.salesagreementid
			  inner join vtiger_shcontacts on vtiger_salesagreement.customer = vtiger_shcontacts.shcontactsid
			  left join vtiger_shaccounts on vtiger_shaccounts.shaccountsid = vtiger_shcontacts.company
			  where vtiger_crmentity.deleted = 0 and '.$filter.' and ar_status in ("Unpaid","Partial") and conversion_ar="'.$_REQUEST['conversion'].'"';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['result'] = 1;
			$data[$i]['id'] = $adb->query_result($result, $i, "accountsreceivableid");
			$data[$i]['conversion_ar'] = $adb->query_result($result, $i, "conversion_ar");
			$data[$i]['ar_no'] = $adb->query_result($result, $i, "ar_no");
			$data[$i]['sales'] = $adb->query_result($result, $i, "sales");
			$data[$i]['link'] = "index.php?action=DetailView&module=SalesAgreement&record=".$adb->query_result($result, $i, "salesagreementid");
			$data[$i]['sales_no'] = $adb->query_result($result, $i, "sa_no");
			$data[$i]['ar_status'] = $adb->query_result($result, $i, "ar_status");
			$data[$i]['payment'] = $adb->query_result($result, $i, "payment");
			$data[$i]['balance'] = $adb->query_result($result, $i, "sales") - ( $adb->query_result($result, $i, "payment") + $adb->query_result($result, $i, "awt") );
			$data[$i]['account_name'] = $adb->query_result($result, $i, "account_name");
			$data[$i]['contact'] = $adb->query_result($result, $i, "firstname").' '.$adb->query_result($result, $i, "lastname");
			$data[$i]['pax'] = $adb->query_result($result, $i, "pax");
			$data[$i]['awt'] = $adb->query_result($result, $i, "awt");
			
		}
		
		echo json_encode($data);
	}

} else if( $_REQUEST['func'] == 'updateRelations' ){

	require_once ("modules/Collection/Collection.php");
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	require_once ("modules/ARChecks/ARChecks.php");
	
	$focus = new Collection();
	$payment_type = $_REQUEST['payment_type'];
	$receipt_type = $_REQUEST['receipt_type'];
	
	$entityBody = file_get_contents('php://input');
	$data = json_decode($entityBody,true);
	
	$payment = 0;
	$awt = 0;
	
	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');
	
	$arIds = array();
	
	$i = 0;
	foreach ( $data as $ar ){
		if ( $i == 0 ){
			$conversion = $ar['conversion_ar'];
			$i++;
		} else {
			if ( $ar['conversion_ar'] == $conversion ) {
				continue;
			} else {
				echo json_encode( array( 'error' => 'Should have the same conversions') );
				die();
			}
		}
	}
	
	foreach ( $data as $ar ){

		$payment += $ar['payment'];
		$awt += $ar['ewt'];
		
		$arIds[] = $ar['id'];
		$id = $ar['id'];
		$ar_obj->mode = 'edit';
		$ar_obj->id = $id;
		$ar_obj->retrieve_entity_info($id, 'AccountsReceivable');
		
		$ar_obj->column_fields['payment'] +=  $ar['payment'];
		$ar_obj->column_fields['awt'] +=  $ar['ewt'];
		$ar_obj->save('AccountsReceivable');
		
	}
	
	$focus->column_fields = Array
							(
								"CreatedTime" => "",
								"ModifiedTime" => "",
								"assigned_user_id" => $_SESSION['authenticated_user_id'],
								"c_payment_method" => $payment_type,
								"payment" => $payment,
								"awt" => $awt,
								"receipt_type" => $receipt_type,
								"conversion_c" => $conversion
							);
							
	$focus->save( 'Collection' );
	$return_id = $focus->id;
	
	if ( $payment_type == 'Check') {
		$archeck_obj = new ARChecks();
		$archeck_obj->setColumns('ARChecks');
		$archeck_obj->column_fields = Array
								(
									"CreatedTime" => "",
									"ModifiedTime" => "",
									"assigned_user_id" => $_SESSION['authenticated_user_id'],
									"collection_no" => $focus->id,
									"chk_no" => $_REQUEST['check_no'],
									"bank" => $_REQUEST['bank'],
									"date_of_chk" =>  $_REQUEST['date_of_check'],
									"arhk_status" => "Released",
									"amount" => $payment,
									"conversion_rc" => $conversion
								);
		
		$archeck_obj->save( 'ARChecks' );
	}

	
	if(!empty($data)) {
	
		$focus->save_related_module('Collection', $return_id, 'AccountsReceivable', $arIds);
		
	}

	//echo json_encode($HTTP_RAW_POST_DATA);
	echo json_encode( array( 'id' => $focus->id ) );
	
}else{
	echo json_encode(array('error'=>'invalid action'));
}

exit();
?>