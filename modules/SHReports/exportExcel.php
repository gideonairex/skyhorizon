<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=statement.xls");
header("Pragma: no-cache");
header("Expires: 0");

$_REQUEST['mode'] = 'print';
require('modules/SHReports/Reports/'.$_REQUEST['report_name'].'.php');
require('modules/SHReports/TemplateMaker/'.$_REQUEST['report_name'].'.php');

$account_str = '';
if ( $_REQUEST['accounts'] != 0  &&  ( $_REQUEST['report_name'] == 'sales' || $_REQUEST['report_name'] == 'ar')  ){
	$query = 'select * from vtiger_shaccounts
			  inner join vtiger_crmentity on vtiger_shaccounts.shaccountsid = vtiger_crmentity.crmid
			  where deleted = 0 and ( shaccountsid = '.$_REQUEST['accounts'].' || main = '.$_REQUEST['accounts'].' )';
	$result = $adb->pquery($query,array());
	$num_rows = $adb->num_rows($result);
	$account = array();
	if($num_rows == 0){
		//echo json_encode(0);
	}else{
		$account_name = $adb->query_result($result, 0, "account_name");
	}
	$account_str =  "<tr> <th colspan=9 style='text-align:center'>".$account_name."</th> </tr>";
}

echo "<table>";
echo "<tr rowspan=2>
				<th colspan=9 style='text-align:center'>Statement of Account</th>
				</tr>";
echo $account_str;
echo "<tr><td colspan='9'>&nbsp;</td></tr>";
echo "<tr>
				<th>SA No</th>
				<th>Account</th>
				<th>Pax</th>
				<th>Route</th>
				<th>Amount Fee</th>
				<th>Service Fee</th>
				<th>VAT</th>
				<th>Vatable Sale</th>
				<th>Grand Total</th>
			</tr>
				";

foreach( $newData as $key => $value ) {
	echo "<tr><td colspan='9'>&nbsp;</td></tr>";
	echo "<tr><th colspan='9' style='text-align:left'>".$key."</th></tr>";

	foreach( $value as $key2 => $value2 ) {
		echo "<tr>";
			echo "<td>".$value2['sa_no']."</td>";
			echo "<td>".$value2['account_name']."</td>";
			echo "<td>".$value2['pax']."</td>";
			echo "<td>".$value2['details']."</td>";
			echo "<td>".$value2['fee']."</td>";
			echo "<td>".$value2['service_fee']."</td>";
			echo "<td>".$value2['vat']."</td>";
			echo "<td>".$value2['vatable_sale']."</td>";
			echo "<td>".$value2['grand_total']."</td>";
		echo "</tr>";
	}
}
echo "<tr><td colspan='9'>&nbsp;</td></tr>";
echo "<tr><td colspan='8' style='text-align:right'>Total:</td><td>".$gt."</td></tr>";
echo "</table>";
die();
?>
