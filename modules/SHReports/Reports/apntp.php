<?php
	global $adb;
	$ext = ' and conversion_ap = "'.$_REQUEST['conversion'].'"';
	if( $_REQUEST['user'] != 0)
		$ext = ' and smownerid ='.$_REQUEST['user'];
	if( $_REQUEST['suppliers'] != 0 )
		$ext .= ' and  shsupplierid ='.$_REQUEST['suppliers'].' ';
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
	$query = 'select * from vtiger_accountspayable
			  inner join vtiger_crmentity on vtiger_accountspayable.accountspayableid = vtiger_crmentity.crmid
			  left join vtiger_shexpenses on vtiger_accountspayable.payable_no = vtiger_shexpenses.shexpensesid
			  inner join vtiger_shsupplier on  ( vtiger_shexpenses.expense_name = vtiger_shsupplier.shsupplierid )
			  where deleted = 0 and ap_status IN ("Unpaid", "Partial", "Pending for clearance") '.$ext;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['id'] = $adb->query_result($result, $i, "accountspayableid");
			$data[$i]['ap_no'] = $adb->query_result($result, $i, "ap_no");
			//get per service type
			$data[$i]['expense_no'] = $adb->query_result($result, $i, "expense_no");
			$data[$i]['expense_name'] = $adb->query_result($result, $i, "expense_name");
			$data[$i]['po_no'] = $adb->query_result($result, $i, "po_no");

			$data[$i]['payable_no'] = $data[$i]['expense_no'];
			$data[$i]['link'] = "index.php?action=DetailView&module=SHExpenses&record=".$adb->query_result($result, $i, "payable_no");
			$data[$i]['purchase_type'] = "expense";

			$data[$i]['supplier_name'] = $adb->query_result($result, $i, "supplier_name");
			$data[$i]['payable'] = $adb->query_result($result, $i, "payable");
			$data[$i]['payment'] = $adb->query_result($result, $i, "payment");
			$data[$i]['ewt'] =  $adb->query_result($result, $i, "ewt");
			$data[$i]['ap_status'] = $adb->query_result($result, $i, "ap_status");
			$data[$i]['balance'] =  $data[$i]['payable'] - $data[$i]['payment'] - $data[$i]['ewt'];
			$data[$i]['createdtime'] =  $adb->query_result($result, $i, "createdtime");
		}
		echo json_encode($data);
	}

?>