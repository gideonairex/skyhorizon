<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-6">
					<h2 class="text-center"> Outstanding Accounts Receivable </h2>
				</div>
				<div class="col-xs-3">
				</div>
			</div>
			{if $SHOWLOGO eq 'true'}
			<div class="row">
				<div class="col-xs-6">
					{include file='ReportTemplates/logo.tpl'}
				</div>
				<div class="col-xs-6">
				<h3> Details </h3>
					{assign var=account_name value=$ACCOUNT.account_name}

					<table class="table">
						<tr>
							<td> Account Name </td>
							<td> {$account_name} </td>
						</tr>
					</table>
				</div>
			</div>
			{/if}
{foreach key=DATE item=ARS from=$DATA}
			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
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
					<td>{$sa_no}</td>
					<td>{$account_name}</td>
					<td>{$pax}</td>
					<td>{$details}</td>
					<td>{$total_sales_print}</td>
					<td>{$service_fee}</td>
					<td>{$vat}</td>
					<td>{$vatable_sale}</td>
					<td>{$grand_total}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}

	</div>
