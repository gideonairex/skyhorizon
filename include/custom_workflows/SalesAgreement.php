<?php
function createAR($entity){

	
	require_once ("modules/AccountsReceivable/AccountsReceivable.php");
	$ar_obj = new AccountsReceivable();
	$ar_obj->setColumns('AccountsReceivable');

	$assigned_user_id = explode('x',$entity->data['assigned_user_id']);
	$id = explode('x',$entity->data['id']);
	
	$ar_obj->column_fields['assigned_user_id'] = $assigned_user_id[1];
	$ar_obj->column_fields['sales_no'] = $id[1];
	$ar_obj->column_fields['ar_status'] = 'Pending'; 
	$ar_obj->column_fields['sales'] = $entity->data['grand_total']; 
	$ar_obj->save('AccountsReceivable');
	
	/*
	require_once ("modules/Cars/Cars.php");
	require_once ("modules/HomeOwner/HomeOwner.php");
	$car_arr = explode('x',$entity->id);
	$car_id = $car_arr[1];
	
	$car_obj = new Cars();
	$car_obj->setColumns('Cars');
	$car_obj->id = $car_id;
	$car_obj->retrieve_entity_info($car_id,'Cars');
	
	if(!empty($car_obj->column_fields['homeowner'])){
		$homeowner_obj = new HomeOwner();
		$homeowner_obj->setColumns('HomeOwner');
		$homeowner_obj->id = $car_obj->column_fields['homeowner'];
		$homeowner_obj->retrieve_entity_info($car_obj->column_fields['homeowner'],'HomeOwner');
		
		if($homeowner_obj->column_fields['car'] == $car_obj->id){
			$homeowner_obj->column_fields['plate_no_'] = $car_obj->column_fields['plate_no'];
			$homeowner_obj->column_fields['car_status'] = $car_obj->column_fields['c_status'];
			$homeowner_obj->column_fields['date_of_renewal'] = $car_obj->column_fields['date_of_renewal'];
			$homeowner_obj->mode = 'edit';
			$homeowner_obj->save('HomeOwner');
		}
	}
	*/
}
?>