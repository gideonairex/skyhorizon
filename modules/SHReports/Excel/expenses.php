<?php

$type =  $_REQUEST[ 'expenses_report_type' ];

echo "<table>";
echo "<tr rowspan=2>
				<th colspan=9 style='text-align:center'>Purchases</th>
				</tr>";
echo $account_str;
echo "<tr><td colspan='9'>&nbsp;</td></tr>";
echo "<tr>
	<th>AP No</th>";

if( $type == 'supplier' ) {
	echo "<th>Supplier</th>";
} else {
	echo "<th>NTP Type</th>";
}

echo "<th>Payable No.</th>
				<th>Payable</th>
				<th>EWT</th>
				<th>Status</th>
				<th>Balance</th>
			</tr>
				";

foreach( $newData as $key => $value ) {
	echo "<tr><td colspan='9'>&nbsp;</td></tr>";
	echo "<tr><th colspan='9' style='text-align:left'>".$key."</th></tr>";

	foreach( $value as $key2 => $value2 ) {
		echo "<tr>";
			echo "<td>".$value2['ap_no']."</td>";
			if( $type == 'supplier' ) {
						echo "<td>".$value2['supplier_name']."</td>";
			} else {
						echo "<td>".$value2['expense_type']."</td>";
			}
			echo "<td>".$value2['payable_no']."</td>";
			echo "<td>".$value2['payable']."</td>";
			echo "<td>".$value2['ewt']."</td>";
			echo "<td>".$value2['ap_status']."</td>";
			echo "<td>".$value2['balance']."</td>";
		echo "</tr>";
	}
}
//echo "<tr><td colspan='9'>&nbsp;</td></tr>";
//echo "<tr><td colspan='8' style='text-align:right'>Total:</td><td>".$gt."</td></tr>";
echo "</table>";
?>
