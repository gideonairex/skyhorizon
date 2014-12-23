<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-6">
					<h2 class="text-center"> Aging of Receivables </h2>
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
					{assign var=account_name value=$ACCOUNT.account_name}

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
					<th class="col-md-2">SA No</th>
					<th class="col-md-3">Account</th>
					<th class="col-md-3">Pax</th>
					<th class="col-md-2">Aging</th>
					<th class="col-md-2">Grand Total</th>
				</tr>
			{foreach key=ID item=AR from=$ARS}
				{assign var=account_name value=$AR.account_name}
				{assign var=sa_no value=$AR.sa_no}
				{assign var=pax value=$AR.pax}
				{assign var=aging value=$AR.aging}
				{assign var=grand_total value=$AR.grand_total}
				<tr>
					<td class="col-md-2">{$sa_no}</td>
					<td class="col-md-3">{$account_name}</td>
					<td class="col-md-3">{$pax}</td>
					<td class="col-md-2">{$aging} days</td>
					<td class="col-md-2">{$grand_total}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}

	</div>
