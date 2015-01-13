<?php
	global $adb;
	$ext = ' and conversion_po= "'.$_REQUEST['conversion'].'"';
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
	$query = 'select * from vtiger_po
			  inner join vtiger_crmentity on vtiger_po.poid = vtiger_crmentity.crmid
			  inner join vtiger_shsupplier on  ( vtiger_po.suplier = vtiger_shsupplier.shsupplierid )
			  where deleted = 0 and po_status IN ("Approved") '.$ext;
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['id'] = $adb->query_result($result, $i, "poid");
			$data[$i]['sa_no'] = $adb->query_result($result, $i, "sa_no");
			$data[$i]['pax'] = $adb->query_result($result, $i, "pax");
			$data[$i]['po_status'] = $adb->query_result($result, $i, "po_status");
			$data[$i]['po_no'] = $adb->query_result($result, $i, "po_no");
			$data[$i]['no_of_pax'] = $adb->query_result($result, $i, "no_of_pax");
			$data[$i]['link'] = "index.php?action=DetailView&module=PO&record=".$adb->query_result($result, $i, "poid");
			$data[$i]['purchase_type'] = "po";
			$data[$i]['supplier_name'] = $adb->query_result($result, $i, "supplier_name");
			$data[$i]['cost'] = $adb->query_result($result, $i, "cost");
			$data[$i]['service_fee'] = $adb->query_result($result, $i, "service_fee");
			$data[$i]['grand_total'] = $adb->query_result($result, $i, "grand_total");
			$data[$i]['createdtime'] =  date("F j, Y", strtotime( $adb->query_result($result, $i, "createdtime") ) );
			$gt += $data[$i]['grand_total'];
		}

		if ( $_REQUEST['mode'] != "print" ) {
			echo json_encode($data);
		}
	}

?>