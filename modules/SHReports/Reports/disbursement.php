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
		$ext .= "and conversion_d = '".$_REQUEST['conversion']."' ";
	}

	$query = "select * from vtiger_disbursement
		inner join vtiger_crmentity on vtiger_disbursement.disbursementid = vtiger_crmentity.crmid
						where deleted = 0 ".$ext;

	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$method = explode( ' ',$adb->query_result($result, $i, "d_payment_method"));
			$method = implode( '_', $method);
			$data['summary'][$method]['payment'] += $adb->query_result($result, $i, "payment");
			$data['summary'][$method]['awt'] += $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['total'] += $adb->query_result($result, $i, "amount") + $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['d_payment_method'] = $method;
			$data['summary'][$method]['details'][$i]['id'] = $adb->query_result($result, $i, "disbursementid");
			$data['summary'][$method]['details'][$i]['payment'] = $adb->query_result($result, $i, "payment");
			$data['summary'][$method]['details'][$i]['d_payment_method'] = $adb->query_result($result, $i, "d_payment_method");
			$data['summary'][$method]['details'][$i]['awt'] = $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['details'][$i]['total'] =  $adb->query_result($result, $i, "amount") + $adb->query_result($result, $i, "ewt");
			$data['summary'][$method]['details'][$i]['disbursement_no'] = "<a href='index.php?module=Disbursement&action=DetailView&record=".$adb->query_result($result, $i, "disbursementid")."' target=_blank >".$adb->query_result($result, $i, "disbursement_no")."</a>";
			$data['summary']['Summary']['payment'] += $adb->query_result($result, $i, "payment");
			$data['summary']['Summary']['awt'] += $adb->query_result($result, $i, "ewt");
		}
	}
	echo json_encode($data);

?>