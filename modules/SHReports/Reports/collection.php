<?php

	$ext = '';
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
	
	if( $_REQUEST['conversion'] != "" ) {
		$ext .= " and conversion_c = '".$_REQUEST['conversion']."' ";
	}
	
	$query = "select *,vtiger_crmentityrel.crmid as `collectionid` from vtiger_crmentityrel 
			  inner join vtiger_crmentity on vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid
			  inner join vtiger_accountsreceivable on vtiger_accountsreceivable.accountsreceivableid = vtiger_crmentityrel.relcrmid
			  inner join vtiger_salesagreement on vtiger_accountsreceivable.sales_no = vtiger_salesagreement.salesagreementid
			  where vtiger_crmentityrel.crmid IN ( select collectionid from vtiger_collection 
			  inner join vtiger_crmentity on vtiger_collection.collectionid = vtiger_crmentity.crmid
			  where deleted = 0 ".$ext." ) and  relmodule = 'AccountsReceivable' ";
	
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$ar = array();
	
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$ar[ $adb->query_result($result, $i, "collectionid") ][ $i ] ['ar_no'] = $adb->query_result($result, $i, "ar_no");
			$ar[ $adb->query_result($result, $i, "collectionid") ][ $i ] ['sa_no'] = $adb->query_result($result, $i, "sa_no");
			$ar[ $adb->query_result($result, $i, "collectionid") ][ $i ] ['sales'] = $adb->query_result($result, $i, "sales");
		}
	}
	
	$query = "select * from vtiger_collection 
			  inner join vtiger_crmentity on vtiger_collection.collectionid = vtiger_crmentity.crmid
			  where deleted = 0 ".$ext;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$method = explode( ' ',$adb->query_result($result, $i, "c_payment_method"));
			$method = implode( '_', $method);
			$data['summary'][$method]['payment'] += $adb->query_result($result, $i, "payment");
			$data['summary'][$method]['awt'] += $adb->query_result($result, $i, "awt");
			$data['summary'][$method]['bc'] += $adb->query_result($result, $i, "bc");
			$data['summary'][$method]['total'] += $adb->query_result($result, $i, "bc") + $adb->query_result($result, $i, "payment") + $adb->query_result($result, $i, "awt");
			$data['summary'][$method]['c_payment_method'] = $method;
			$data['summary'][$method]['details'][$i]['id'] = $adb->query_result($result, $i, "collectionid");
			$data['summary'][$method]['details'][$i]['payment'] = $adb->query_result($result, $i, "payment");
			$data['summary'][$method]['details'][$i]['c_payment_method'] = $adb->query_result($result, $i, "c_payment_method");
			$data['summary'][$method]['details'][$i]['awt'] = $adb->query_result($result, $i, "awt");
			$data['summary'][$method]['details'][$i]['bc'] = $adb->query_result($result, $i, "bc");
			$data['summary'][$method]['details'][$i]['total'] =  $adb->query_result($result, $i, "bc") + $adb->query_result($result, $i, "payment") + $adb->query_result($result, $i, "awt");
			$data['summary'][$method]['details'][$i]['ar'] = $ar[ $adb->query_result($result, $i, "collectionid") ];
			
			$data['summary']['Summary']['payment'] += $adb->query_result($result, $i, "payment");
			$data['summary']['Summary']['awt'] += $adb->query_result($result, $i, "awt");
			$data['summary']['Summary']['bc'] += $adb->query_result($result, $i, "bc");
			
		}
	}
	
	echo json_encode($data);

?>