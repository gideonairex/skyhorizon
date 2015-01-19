<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-6">
					<h2 class="text-center"> Statement of Account </h2>
				</div>
				<div class="col-xs-3">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					{include file='ReportTemplates/logo.tpl'}
				</div>
				<div class="col-xs-6">
				<h3> Details </h3>

					<table class="table">
					{if $ACCOUNT}
						{assign var=account_name value=$ACCOUNT.account_name}
							<tr>
								<td> Account Name </td>
								<td> {$account_name} </td>
							</tr>
					{/if}
						<tr>
							<td> Grand Total </td>
							<td> {$GRANDTOTAL} </td>
						</tr>
					</table>
				</div>
			</div>
{foreach key=DATE item=ARS from=$DATA}
			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
					<th class="col-md-1">SA No</th>
					<th class="col-md-2">Account</th>
					<th class="col-md-2">Pax</th>
					<th class="col-md-2">Route</th>
					<th class="col-md-1">Amount Fee</th>
					<th class="col-md-1">Service Fee</th>
					<th class="col-md-1">VAT</th>
					<th class="col-md-1">Vatable Sale</th>
					<th class="col-md-1">Grand Total</th>
				</tr>
			{foreach key=ID item=AR from=$ARS}
				{assign var=account_name value=$AR.account_name}
				{assign var=sa_no value=$AR.sa_no}
				{assign var=total_sales_print value=$AR.total_sales_print}
				{assign var=service_fee value=$AR.service_fee}
				{assign var=vat value=$AR.vat}
				{assign var=vatable_sale value=$AR.vatable_sale}
				{assign var=pax value=$AR.pax}
				{assign var=details value=$AR.details}
				{assign var=grand_total value=$AR.grand_total}
				<tr>
					<td class="col-md-1">{$sa_no}</td>
					<td class="col-md-2">{$account_name}</td>
					<td class="col-md-2">{$pax}</td>
					<td class="col-md-2">{$details}</td>
					<td class="col-md-1">{$total_sales_print}</td>
					<td class="col-md-1">{$service_fee}</td>
					<td class="col-md-1">{$vat}</td>
					<td class="col-md-1">{$vatable_sale}</td>
					<td class="col-md-1">{$grand_total}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}
		<div class="col-xs-12">
			<p>note: please disregard statement if already paid.</p>
		</div>
			{include file='ReportTemplates/footer.tpl'}
	</div>
