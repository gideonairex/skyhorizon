<?php
	global $adb;
	$query = 'select * from vtiger_users where status= "Active"';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$users = array();
	for( $i = 0 ; $i < $num_rows; $i++){
		$users[$adb->query_result($result, $i, "id")] = $adb->query_result($result, $i, "first_name").' '.$adb->query_result($result, $i, "last_name");
	}

	$ext = ' and ntr_currency = "'.$_REQUEST['conversion'].'"';
	if( $_REQUEST['user'] != 0)
		$ext = ' and smownerid ='.$_REQUEST['user'];

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
	$query = 'select * from vtiger_nontrader
			  inner join vtiger_crmentity on vtiger_nontrader.nontraderid = vtiger_crmentity.crmid
			  inner join vtiger_accountsreceivable on vtiger_accountsreceivable.sales_no = vtiger_nontrader.nontraderid
			  where deleted = 0 and ar_status IN ("Unpaid","Partial") '.$ext;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['id'] = $adb->query_result($result, $i, "nontraderid");
			$data[$i]['link'] = "index.php?action=DetailView&module=NonTradeR&record=".$adb->query_result($result, $i, "nontraderid");
			$data[$i]['ntr_no'] = $adb->query_result($result, $i, "ntr_no");
			$data[$i]['ar_no'] = $adb->query_result($result, $i, "ar_no");
			$data[$i]['ar_status'] = $adb->query_result($result, $i, "ar_status");
			$data[$i]['receivable'] = $adb->query_result($result, $i, "receivable");
			$data[$i]['balance'] =   $adb->query_result($result, $i, "sales") - $adb->query_result($result, $i, "payment") - $adb->query_result($result, $i, "awt");
			$data[$i]['createdtime'] =  date("F j, Y", strtotime( $adb->query_result($result, $i, "createdtime") ) );
			$data[$i]['user'] =  $users[$adb->query_result($result, $i, "smownerid")];
			$data[$i]['aging'] =intval ( ( strtotime("now") - strtotime($data[$i]['createdtime']) ) / (60 * 60 * 24) ) ;
		}
		if ( $_REQUEST['mode'] != "print" ) {
			echo json_encode($data);
		}
	}

?>