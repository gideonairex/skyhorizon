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
	/*
	 * Get NTP types
	 *
	 */
	$query = 'select * from vtiger_expense_type';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['expense_type'][ $adb->query_result( $result, $i, "expense_type" ) ] = $adb->query_result($result, $i, "expense_type");
		}
	}

	/*
	 * Get Services
	 *
	 */
	// Others
	$query = 'select * from vtiger_others
			  inner join vtiger_crmentity on vtiger_others.othersid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['others']['name'] = 'Others';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['others']['fields'][ $adb->query_result( $result, $i, "othersid" ) ] = $adb->query_result($result, $i, "name");
		}
	}
	// Admin costs
	$query = 'select * from vtiger_admincost
			  inner join vtiger_crmentity on vtiger_admincost.admincostid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['admincost']['name'] = 'Admin Cost';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['admincost']['fields'][ $adb->query_result( $result, $i, "admincostid" ) ] = $adb->query_result($result, $i, "name");
		}
	}
	// Hotels
	$query = 'select * from vtiger_hotel
			  inner join vtiger_crmentity on vtiger_hotel.hotelid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['hotel']['name'] = 'Hotel';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['hotel']['fields'][ $adb->query_result( $result, $i, "hotelid" ) ] = $adb->query_result($result, $i, "name");
		}
	}
	// Vehicle rentals
	$query = 'select * from vtiger_cbr
			  inner join vtiger_crmentity on vtiger_cbr.cbrid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['cbr']['name'] = 'Vehicle Rentals';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['cbr']['fields'][ $adb->query_result( $result, $i, "cbrid" ) ] = $adb->query_result($result, $i, "name");
		}
	}
	// DAT
	$query = 'select * from vtiger_dat
			  inner join vtiger_crmentity on vtiger_dat.datid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['dat']['name'] = 'Domestic Airline Ticketing';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['dat']['fields'][ $adb->query_result( $result, $i, "datid" ) ] = $adb->query_result($result, $i, "airlines");
		}
	}
	// IAT
	$query = 'select * from vtiger_iat
			  inner join vtiger_crmentity on vtiger_iat.iatid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['iat']['name'] = 'Internation Airline Ticketing';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['iat']['fields'][ $adb->query_result( $result, $i, "iatid" ) ] = $adb->query_result($result, $i, "airlines");
		}
	}
	// Visa
	$query = 'select * from vtiger_visaa
			  inner join vtiger_crmentity on vtiger_visaa.visaaid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['visaa']['name'] = 'VISA Assistance';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['visaa']['fields'][ $adb->query_result( $result, $i, "visaaid" ) ] = $adb->query_result($result, $i, "name");
		}
	}
	// PP
	$query = 'select * from vtiger_pp
			  inner join vtiger_crmentity on vtiger_pp.ppid = vtiger_crmentity.crmid
			  where deleted = 0';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$data['service_type']['pp']['name'] = 'Passport Processing';
		for( $i = 0 ; $i < $num_rows; $i++){
			$data['service_type']['pp']['fields'][ $adb->query_result( $result, $i, "ppid" ) ] = $adb->query_result($result, $i, "name");
		}
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