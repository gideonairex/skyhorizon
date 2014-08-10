<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
{foreach key=DATE item=ARS from=$DATA}

			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
					<th>SA No</th>
					<th>AR No</th>
					<th>Aging</th>
					<th>AF</th>
					<th>SF</th>
					<th>VAT</th>
					<th>Vatable Sale</th>
					<th>Pax</th>
					<th>Route</th>
				</tr>
			{foreach key=ID item=AR from=$ARS}
				{assign var=sa_no value=$AR.sa_no}
				{assign var=ar_no value=$AR.ar_no}
				{assign var=aging value=$AR.aging}
				{assign var=total_sales_print value=$AR.total_sales_print}
				{assign var=service_fee value=$AR.service_fee}
				{assign var=vat value=$AR.vat}
				{assign var=vatable_sale value=$AR.vatable_sale}
				{assign var=pax value=$AR.pax}
				{assign var=details value=$AR.details}
				

				<tr>
					<td>{$sa_no}</td>
					<td>{$ar_no}</td>
					<td>{$aging} days</td>
					<td>{$total_sales_print}</td>
					<td>{$service_fee}</td>
					<td>{$vat}</td>
					<td>{$vatable_sale}</td>
					<td>{$pax}</td>
					<td>{$details}</td>
				</tr>
			{/foreach}
			</table>
			
{/foreach}
</div>
		</div>
	</div>
