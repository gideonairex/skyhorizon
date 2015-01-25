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
		$ext .= "and currency_cl = '".$_REQUEST['conversion']."' ";
	}

	$query = "select * from vtiger_collectionlogs
		inner join vtiger_crmentity on vtiger_collectionlogs.collectionlogsid = vtiger_crmentity.crmid
		inner join vtiger_collection on vtiger_collectionlogs.collection_no = vtiger_collection.collectionid
		inner join vtiger_accountsreceivable on vtiger_accountsreceivable.accountsreceivableid = vtiger_collectionlogs.ar_no
		inner join vtiger_salesagreement on vtiger_salesagreement.salesagreementid = vtiger_accountsreceivable.sales_no
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
			$data['summary'][$method]['payment'] += $adb->query_result($result, $i, "amount");
			$data['summary'][$method]['awt'] += $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['bc'] += $adb->query_result($result, $i, "bc");
			$data['summary'][$method]['total'] += $adb->query_result($result, $i, "bc") + $adb->query_result($result, $i, "amount") + $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['c_payment_method'] = $method;
			$collection_no = $adb->query_result($result, $i, "collection_no");
			$data['summary'][$method]['details'][$collection_no][$i]['payment'] = $adb->query_result($result, $i, "amount");
			$data['summary'][$method]['details'][$collection_no][$i]['c_payment_method'] = $adb->query_result($result, $i, "c_payment_method");
			$data['summary'][$method]['details'][$collection_no][$i]['awt'] = $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['details'][$collection_no][$i]['bc'] = $adb->query_result($result, $i, "bc");
			$data['summary'][$method]['details'][$collection_no][$i]['total'] =  $adb->query_result($result, $i, "bc") + $adb->query_result($result, $i, "amount") + $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['details'][$collection_no][$i]['ar_no'] = "<a href='index.php?module=AccountsReceivable&action=DetailView&record=".$adb->query_result($result, $i, "accountsreceivableid")."' target=_blank >".$adb->query_result($result, $i, "ar_no")."</a>";
			$data['summary'][$method]['details'][$collection_no][$i]['sa_no'] = "<a href='index.php?module=SalesAgreement&action=DetailView&record=".$adb->query_result($result, $i, "salesagreementid")."' target=_blank >".$adb->query_result($result, $i, "sa_no")."</a>";
			$data['summary'][$method]['details'][$collection_no][$i]['ar_no_'] = $adb->query_result($result, $i, "ar_no");
			$data['summary'][$method]['details'][$collection_no][$i]['sa_no_'] = $adb->query_result($result, $i, "sa_no");
			$data['summary'][$method]['details'][$collection_no][$i]['cl_no'] = "<a href='index.php?module=CollectionLogs&action=DetailView&record=".$adb->query_result($result, $i, "collectionlogsid")."' target=_blank >".$adb->query_result($result, $i, "collection_log_no")."</a>";
			$data['summary'][$method]['details'][$collection_no][$i]['cl_no_'] = $adb->query_result($result, $i, "collection_log_no");
			$data['summary'][$method]['details'][$collection_no][$i]['sales'] = $adb->query_result($result, $i, "sales");
			$data['summary']['Summary']['payment'] += $adb->query_result($result, $i, "amount");
			$data['summary']['Summary']['awt'] += $adb->query_result($result, $i, "ewt");
			$data['summary']['Summary']['bc'] += $adb->query_result($result, $i, "bc");
		}
	}

	if ( $_REQUEST['mode'] != "print" ) {
		echo json_encode($data);
	}

?>