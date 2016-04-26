<?php
require_once('Smarty_setup.php');
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;
$smarty = new vtigerCRM_Smarty();
$smarty->assign('MODULE', $currentModule);

$id = $_REQUEST['record'];

$query = "select * from vtiger_crmentityrel
			  inner join vtiger_crmentity on vtiger_crmentityrel.crmid = vtiger_crmentity.crmid
			  inner join vtiger_disbursement on vtiger_disbursement.disbursementid = vtiger_crmentityrel.crmid
			  inner join vtiger_accountspayable on vtiger_accountspayable.accountspayableid = vtiger_crmentityrel.relcrmid
			  left join vtiger_po on vtiger_accountspayable.payable_no = vtiger_po.poid
			  left join vtiger_shexpenses on vtiger_accountspayable.payable_no = vtiger_shexpenses.shexpensesid
			  inner join vtiger_shsupplier on  ( vtiger_po.suplier = vtiger_shsupplier.shsupplierid || vtiger_shexpenses.expense_name = vtiger_shsupplier.shsupplierid )
			  where vtiger_crmentity.crmid = ".$id." and deleted = 0 and relmodule ='AccountsPayable' ";
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data = array();
$totalPaid = 0;
if($num_rows == 0){
		//echo json_encode(0);
	}else{
		for( $i = 0 ; $i < $num_rows; $i++){
			$data[$i]['result'] = 1;
			$data[$i]['id'] = $adb->query_result($result, $i, "accountspayableid");
			$data[$i]['ap_no'] = $adb->query_result($result, $i, "ap_no");
			$data[$i]['payable_no'] = $adb->query_result($result, $i, "payable_no");
			$data[$i]['payable'] = $adb->query_result($result, $i, "payable");
			$data[$i]['payment'] = ( $adb->query_result($result, $i, "payment") ? $adb->query_result($result, $i, "payment") : 0 );
			$data[$i]['ewt'] = ( $adb->query_result($result, $i, "ewt")  ? $adb->query_result($result, $i, "ewt") : 0 );
			$data[$i]['balance'] = $data[$i]['payable'] - $data[$i]['payment'] - $data[$i]['ewt'];
			$data[$i]['total_paid'] = $data[$i]['payment'] + $data[$i]['ewt'];
			$totalPaid += $data[$i]['payment'] + $data[$i]['ewt'];
			$data[$i]['ap_status'] = $adb->query_result($result, $i, "ap_status");
			//get per service type
			$data[$i]['expense_no'] = $adb->query_result($result, $i, "expense_no");
			$data[$i]['po_no'] = $adb->query_result($result, $i, "po_no");
			$data[$i]['supplier_name'] = $adb->query_result($result, $i, "supplier_name");
			if( $data[$i]['expense_no'] == "") {
				$data[$i]['payable_no'] = $data[$i]['po_no'];
				$data[$i]['link'] = "index.php?action=DetailView&module=PO&record=".$adb->query_result($result, $i, "payable_no");
			} else {
				$data[$i]['payable_no'] = $data[$i]['expense_no'];
				$data[$i]['link'] = "index.php?action=DetailView&module=SHExpenses&record=".$adb->query_result($result, $i, "payable_no");
			}

			$data[$i]['createdtime'] =  date("F j, Y", strtotime( $adb->query_result($result, $i, "createdtime") ) );
			$supplier_name = $data[$i]['supplier_name' ];
		}
	}

$query = "select * from vtiger_apchecks
		  inner join vtiger_crmentity on vtiger_apchecks.apchecksid = vtiger_crmentity.crmid
		  inner join vtiger_disbursement on vtiger_disbursement.disbursementid = vtiger_apchecks.disbursement_no
		  where vtiger_apchecks.disbursement_no = ".$id;
$result = $adb->pquery($query,array());
$num_rows = $adb->num_rows($result);
$data2 = array();
if($num_rows == 0){
	//echo json_encode(0);
}else{
	$data2['disbursement_no'] = $adb->query_result($result, 0, "disbursement_no");
	$data2['bank'] = $adb->query_result($result, 0, "bank");
	$data2['apchk_no'] = $adb->query_result($result, 0, "apchk_no");
	$data2['check_no'] = $adb->query_result($result, 0, "check_no");
	$data2['date_of_check'] = date( "F j, Y", strtotime($adb->query_result($result, 0, "date_of_check") ) );
	$data2['amount'] = $adb->query_result($result, 0, "amount");
	$data2['total_paid'] = $totalPaid;
}
$data2['supplier_name'] = $supplier_name;

$newData = array();

for ( $i = 0; $i < count($data); $i++){
	$newData[$data[$i]['createdtime']][] = $data[$i];
}

$smarty->assign('CHECKDETAILS', $data2);
$smarty->assign('DATA', $newData);
$smarty->assign('PREPAREDBY',$current_user->column_fields['first_name'].' '.$current_user->column_fields['last_name'] );
$smarty->display('ReportTemplates/disbursement.tpl');
?>
