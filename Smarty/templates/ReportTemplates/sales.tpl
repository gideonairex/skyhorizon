<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
{include file='ReportTemplates/header.tpl'}
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
						<tr>
							<td> Preparer </td>
							<td> {$PREPAREDBY} </td>
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
					<th class="col-md-4">Pax</th>
					<th class="col-md-4">Route</th>
					<th class="col-md-1">Grand Total</th>
				</tr>
			{foreach key=ID item=AR from=$ARS}
				{assign var=account_name value=$AR.account_name}
				{assign var=sa_no value=$AR.sa_no}
				{assign var=details value=$AR.details}
				{assign var=pax value=$AR.pax}

				{assign var=total_sales_print value=$AR.total_sales_print}
				{assign var=service_fee value=$AR.service_fee}
				{assign var=vat value=$AR.vat}
				{assign var=vatable_sale value=$AR.vatable_sale}

				{assign var=grand_total value=$AR.grand_total}
				<tr>
					<td class="col-md-1">{$sa_no}</td>
					<td class="col-md-2">{$account_name}</td>
					<td class="col-md-4">{$pax}</td>
					<td class="col-md-4">{$details}</td>
					<td class="col-md-1">{$grand_total}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}
		<div class="col-xs-12">
			<p>Note: If transmittal has recently been made please accept our thanks and disregard billing.</p>
		</div>
			{include file='ReportTemplates/footer.tpl'}
	</div>
