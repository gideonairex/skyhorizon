<?php
header('Content-Type: application/json');
global $adb;

if( $_REQUEST['func'] == 'getFilters'){
	
	$query = 'select * from vtiger_users where status= "Active"';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$data = array();
	

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['users'][$i]['id'] = $adb->query_result($result, $i, "id");
			$data['users'][$i]['name'] = $adb->query_result($result, $i, "first_name").' '.$adb->query_result($result, $i, "last_name");
		}
		
		//echo json_encode($data);
	}
	
	$query = 'select * from vtiger_shaccounts
			  inner join vtiger_crmentity on vtiger_shaccounts.shaccountsid = vtiger_crmentity.crmid
			  where deleted = 0';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['accounts'][$i]['id'] = $adb->query_result($result, $i, "shaccountsid");
			$data['accounts'][$i]['name'] = $adb->query_result($result, $i, "account_name");
		}
		
		//echo json_encode($data);
	}
	
	
	$query = 'select * from vtiger_shsupplier
			  inner join vtiger_crmentity on vtiger_shsupplier.shsupplierid = vtiger_crmentity.crmid
			  where deleted = 0';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['suppliers'][$i]['id'] = $adb->query_result($result, $i, "shsupplierid");
			$data['suppliers'][$i]['name'] = $adb->query_result($result, $i, "supplier_name");
		}
		
		//echo json_encode($data);
	}
	
	$query = 'select * from vtiger_conversion';
			   
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);

	if($num_rows == 0){
		//echo json_encode(0);
	}else{
	
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['conversion'][$i]['name'] = $adb->query_result($result, $i, "conversion");
		}
		
		//echo json_encode($data);
	}
	
	
	
	
	echo json_encode($data);
	
} else if ( $_REQUEST['func'] == 'generateReport' ) {
	require ("modules/SHReports/Reports/".$_REQUEST['report_name'].".php");
}else{
	echo json_encode(array('error'=>'invalid action'));
}

exit();
?>