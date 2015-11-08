<?php
ini_set('memory_limit', '-1');
global $adb;

	$ext = ' and conversion_po= "'.$_REQUEST['conversion'].'"';
	if( $_REQUEST['user'] != 0)
		$ext = ' and smownerid ='.$_REQUEST['user'];

	// Get report type
	$report_type = $_REQUEST[ 'purchase_report_type' ];

	if( $report_type == 'supplier' ) {
		if( $_REQUEST['suppliers'] != 0 ) {
			$ext .= ' and  shsupplierid ='.$_REQUEST['suppliers'].' ';
		}
	} elseif ( $report_type == 'service_type' ) {
		$service_type_arr = explode('_',$_REQUEST[ 'service_type' ]);

		// If all from a certain service
		if( count( $service_type_arr ) == 1 ) {
			$service_type = $service_type_arr[ 0 ];

			$service_name = 'name';
			if( $service_type == 'iat' || $service_type == 'dat' ) {
				$service_name = 'airlines';
			}

			$query = 'select * from vtiger_'.$service_type.'
						inner join vtiger_crmentity on vtiger_'.$service_type.'.'.$service_type.'id = vtiger_crmentity.crmid
						where deleted = 0';
			$result = $adb->pquery($query,array());
			$num_rows = $adb->num_rows($result);
			if($num_rows > 0){
				for( $i = 0 ; $i < $num_rows; $i++){
					$serviceIds[ $i ] = $adb->query_result( $result, $i, $service_type."id" );
					$serviceGroups[ $adb->query_result( $result, $i, $service_type."id" ) ] = $adb->query_result( $result, $i, $service_name );
				}
				$ext .= ' and po_servicetype in ('. implode( $serviceIds,',' ) . ')';
			}
		} elseif ( count( $service_type_arr ) == 2 ) {
			$service_type_id = $service_type_arr[ 1 ];
			$ext .= ' and po_servicetype ='. $service_type_id;
		}

	}

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
	$query = 'select * from (
    	select
    		vtiger_po.poid,
    		vtiger_po.po_no,
    		vtiger_po.sa_no,
    		vtiger_po.po_servicetype,
    		vtiger_po.cost,
    		vtiger_po.service_fee,
    		vtiger_po.grand_total,
    		vtiger_po.po_status,
    		vtiger_po.description,
    		vtiger_po.suplier,
    		vtiger_po.pax,
    		vtiger_po.no_of_pax,
    		vtiger_po.vat,
    		vtiger_po.vatable_sale,
    		vtiger_po.access,
    		vtiger_po.conversion_po,
    		vtiger_po.rate_per_pax,
    		vtiger_po.discount,
    		crmid from vtiger_po
			  inner join vtiger_crmentity on vtiger_po.poid = vtiger_crmentity.crmid
              where deleted = 0 and po_status IN ("Approved") '.$ext.') as `cut`
				inner join vtiger_shsupplier on  ( cut.suplier = vtiger_shsupplier.shsupplierid )
				left join vtiger_accountspayable on vtiger_accountspayable.payable_no = cut.poid';

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
			$data[$i]['po_servicetype'] = $adb->query_result($result, $i, "po_servicetype");
			$data[$i]['servicetype'] = $serviceGroups[ $adb->query_result($result, $i, "po_servicetype") ];
			$data[$i]['cost'] = $adb->query_result($result, $i, "cost");
			$data[$i]['service_fee'] = $adb->query_result($result, $i, "service_fee");
			$data[$i]['grand_total'] = $adb->query_result($result, $i, "grand_total");
			$data[$i]['ap_no'] = $adb->query_result($result, $i, "ap_no");
			$data[$i]['createdtime'] =  date("F j, Y", strtotime( $adb->query_result($result, $i, "createdtime") ) );
			$gt += $data[$i]['grand_total'];
		}

		if ( $_REQUEST['mode'] != "print" ) {
			echo json_encode($data);
		}
	}

?>