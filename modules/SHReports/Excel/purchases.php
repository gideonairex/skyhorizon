<?php

$type =  $_REQUEST[ 'purchase_report_type' ];

echo "<table>";
echo "<tr rowspan=2>
				<th colspan=9 style='text-align:center'>Purchases</th>
				</tr>";
echo $account_str;
echo "<tr><td colspan='9'>&nbsp;</td></tr>";
echo "<tr>
	<th>AP No</th>
	<th>Created time</th>";

if( $type == 'supplier' ) {
	echo "<th>Supplier</th>";
} else {
	echo "<th>Service Type</th>";
}

echo "<th>No. of pax</th>
				<th>Pax</th>
				<th>Cost</th>
				<th>Service fee</th>
				<th>Grand total</th>
			</tr>
				";

foreach( $newData as $key => $value ) {
	echo "<tr><td colspan='9'>&nbsp;</td></tr>";
	echo "<tr><th colspan='9' style='text-align:left'>".$key."</th></tr>";

	foreach( $value as $key2 => $value2 ) {
		echo "<tr>";
			echo "<td>".$value2['ap_no']."</td>";
			echo "<td>".$value2['createdtime']."</td>";
			if( $type == 'supplier' ) {
						echo "<td>".$value2['supplier_name']."</td>";
			} else {
						echo "<td>".$value2['servicetype']."</td>";
			}
			echo "<td>".$value2['no_of_pax']."</td>";
			echo "<td>".$value2['pax']."</td>";
			echo "<td>".$value2['cost']."</td>";
			echo "<td>".$value2['service_fee']."</td>";
			echo "<td>".$value2['grand_total']."</td>";
		echo "</tr>";
	}
}
echo "<tr><td colspan='9'>&nbsp;</td></tr>";
echo "<tr><td colspan='8' style='text-align:right'>Total:</td><td>".$gt."</td></tr>";
echo "</table>";
?>
