<?php
header('Content-Type: application/json');
global $adb;

if( $_REQUEST['func'] == 'getFilters'){
	$query = 'select * from vtiger_users where status= "Active" order by last_name';
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
			  where deleted = 0 order by account_name';
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
			  where deleted = 0 order by supplier_name';
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
} else if ( $_REQUEST['func'] == 'saveAr' ) {

	require_once ("modules/SalesAgreement/SalesAgreement.php");
	$sa_obj = new SalesAgreement();
	$sa_obj->setColumns('SalesAgreement');
	$sa_obj->mode = 'edit';
	$sa_obj->id = $_REQUEST[ 'id' ];
	$sa_obj->retrieve_entity_info($sa_obj->id, 'SalesAgreement');
	$sa_obj->column_fields[ 'remarks' ] = $_REQUEST[ 'remarks' ];
	$sa_obj->save('SalesAgreement' );
	echo json_encode( array( 'status'=> 'good' ) );

} else{
	echo json_encode(array('error'=>'invalid action'));
}

exit();
?>