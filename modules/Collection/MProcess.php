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
			  where vtiger_crmentity.deleted = 0 and '.$filter.' and ar_status in ("Pending","Partial")';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['result'] = 1;
			$data[$i]['id'] = $adb->query_result($result, $i, "accountsreceivableid");
			$data[$i]['ar_no'] = $adb->query_result($result, $i, "ar_no");
			$data[$i]['sales'] = $adb->query_result($result, $i, "sales");
			$data[$i]['sales_no'] = $adb->query_result($result, $i, "sales_no");
			$data[$i]['ar_status'] = $adb->query_result($result, $i, "ar_status");
			$data[$i]['payment'] = $adb->query_result($result, $i, "payment");
			$data[$i]['account_name'] = $adb->query_result($result, $i, "account_name");
			$data[$i]['contact'] = $adb->query_result($result, $i, "firstname").' '.$adb->query_result($result, $i, "lastname");
			$data[$i]['pax'] = $adb->query_result($result, $i, "pax");
			$data[$i]['awt'] = $adb->query_result($result, $i, "awt");
			
		}
		
		echo json_encode($data);
	}

}else if( $_REQUEST['func'] == 'updateRelations' ){
	require_once("modules/Collection/Collection.php");
	$focus = new Collection();
	$payment = $_REQUEST['payment'];
	
	
	$entityBody = file_get_contents('php://input');
	$arIds = array();
	$data = json_decode($entityBody,true);
	foreach ( $data as $ar ){
		$arIds[] = $ar['id'];
	}
	
	$focus->column_fields = Array
							(
								"CreatedTime" => "",
								"ModifiedTime" => "",
								"assigned_user_id" => $_SESSION['authenticated_user_id'],
								"c_payment_method" => "cash",
								"payment" => $payment
							);
							
	$focus->save( 'Collection' );
	$return_id = $focus->id;
	
	
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');
	
	if(!empty($arIds)) {
		
		for( $i = 0 ; $i < count($arIds) ; $i++){
			
			if( $payment > 0 ){
				$id = $arIds[$i];
				$ar_obj->mode = 'edit';
				$ar_obj->id = $id;
				$ar_obj->retrieve_entity_info($id, 'AccountsReceivable');
				
				$neededPayment = $ar_obj->column_fields['sales'] - $ar_obj->column_fields['payment'];
				

				if( $payment >= $neededPayment){
					$payment -=  $neededPayment;
					$ar_obj->column_fields['payment'] = $neededPayment + $ar_obj->column_fields['payment'];
				}else{
					$ar_obj->column_fields['payment'] = $payment;
				}

				$ar_obj->save('AccountsReceivable');
			}
			
		}
		
	
		$focus->save_related_module('Collection', $return_id, 'AccountsReceivable', $arIds);
	}
	
	//echo json_encode($HTTP_RAW_POST_DATA);
	echo json_encode( array( 'id' => $focus->id ) );

}else{
	echo json_encode(array('error'=>'invalid action'));
}



exit();
?>