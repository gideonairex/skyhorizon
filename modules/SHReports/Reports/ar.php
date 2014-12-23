<?php
	global $adb;
	$query = 'select * from vtiger_users where status= "Active"';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$users = array();
	for( $i = 0 ; $i < $num_rows; $i++){
		$users[$adb->query_result($result, $i, "id")] = $adb->query_result($result, $i, "first_name").' '.$adb->query_result($result, $i, "last_name");
	}

	$ext = ' and conversion_ar = "'.$_REQUEST['conversion'].'"';
	if( $_REQUEST['user'] != 0)
		$ext = ' and smownerid ='.$_REQUEST['user'];

	if( $_REQUEST['accounts'] != 0 )
		$ext .= ' and ( main = '. $_REQUEST['accounts'] .' || shaccountsid ='.$_REQUEST['accounts'].' )';

	if( $_REQUEST['date'] != "" ) {
		$date = explode(",",$_REQUEST['date']);

		if(count($date) == 1){
			$start = $date[0]." 00:00:00";
			$end = $date[0]." 23:59:59";
		}else{
			function sortFunction( $a, $b ) {
				return strtotime($a) - strtotime($b);
			}
			usort($date, "sortFunction");
			$start = $date[0]." 00:00:00";
			$end = $date[ count($date) - 1]." 23:59:59";
		}
		$ext .= " and createdtime between '".$start."' and '".$end."' ";
	}
	$query = 'select * from vtiger_salesagreement
			  inner join vtiger_crmentity on vtiger_salesagreement.salesagreementid = vtiger_crmentity.crmid
			  inner join vtiger_accountsreceivable on vtiger_accountsreceivable.sales_no = vtiger_salesagreement.salesagreementid
			  inner join vtiger_shcontacts on vtiger_shcontacts.shcontactsid = vtiger_salesagreement.customer
			  inner join vtiger_shaccounts on vtiger_shaccounts.shaccountsid = vtiger_shcontacts.company
			  where deleted = 0 and sa_status="Approved" and ar_status IN ("Unpaid","Partial") '.$ext;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	$gt = 0;
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['id'] = $adb->query_result($result, $i, "salesagreementid");
			$data[$i]['account_name'] = $adb->query_result($result, $i, "account_name");
			$data[$i]['link'] = "index.php?action=DetailView&module=SalesAgreement&record=".$adb->query_result($result, $i, "salesagreementid");
			$data[$i]['sa_no'] = $adb->query_result($result, $i, "sa_no");
			$data[$i]['ar_no'] = $adb->query_result($result, $i, "ar_no");
			$data[$i]['ar_status'] = $adb->query_result($result, $i, "ar_status");
			$data[$i]['quantity'] = $adb->query_result($result, $i, "quantity");
			$quantity = $data[$i]['quantity'];
			$data[$i]['details'] = $adb->query_result($result, $i, "details");
			$data[$i]['pax'] = $adb->query_result($result, $i, "pax");
			$data[$i]['fee'] = $quantity * $adb->query_result($result, $i, "fee");
			$data[$i]['mark_up'] = $quantity * $adb->query_result($result, $i, "mark_up");
			$data[$i]['service_fee'] = $quantity *$adb->query_result($result, $i, "service_fee");
			$data[$i]['vat'] =  number_format( $quantity * $adb->query_result($result, $i, "vat"), 2);
			$data[$i]['vatable_sale'] =  number_format( $quantity * $adb->query_result($result, $i, "vatable_sale"), 2);
		 	$data[$i]['grand_total'] =  $adb->query_result($result, $i, "grand_total");
			$data[$i]['profit'] =  $data[$i]['grand_total'] - $data[$i]['fee'];
			$data[$i]['balance'] =   $adb->query_result($result, $i, "sales") - $adb->query_result($result, $i, "payment") - $adb->query_result($result, $i, "awt");
			$data[$i]['createdtime'] =  date("F j, Y", strtotime( $adb->query_result($result, $i, "createdtime") ) );
			$data[$i]['total_sales_print'] =  $data[$i]['fee'] + $data[$i]['mark_up'];
			$data[$i]['user'] =  $users[$adb->query_result($result, $i, "smownerid")];
			$data[$i]['aging'] =intval ( ( strtotime("now") - strtotime($data[$i]['createdtime']) ) / (60 * 60 * 24) ) ;
			$gt += $data[$i]['grand_total'];
		}
		if ( $_REQUEST['mode'] != "print" ) {
			echo json_encode($data);
		}
	}

?>