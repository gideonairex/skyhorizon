<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
{include file='ReportTemplates/header.tpl'}
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-6">
					<h2 class="text-center"> Purchase Journal </h2>
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
{foreach key=DATE item=POS from=$DATA}
			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
					<th class="col-md-1">PO No</th>
					<th class="col-md-2">Suppliers name</th>
					<th class="col-md-2">Pax</th>
					<th class="col-md-1">Grand Total</th>
				</tr>
			{foreach key=ID item=PO from=$POS}
				{assign var=po_no value=$PO.po_no}
				{assign var=createdtime value=$PO.createdtime}
				{assign var=supplier_name value=$PO.supplier_name}
				{assign var=no_of_pax value=$PO.no_of_pax}
				{assign var=pax value=$PO.pax}
				{assign var=cost value=$PO.cost}
				{assign var=service_fee value=$PO.service_fee}
				{assign var=grand_total value=$PO.grand_total}
				<tr>
					<td class="col-md-1">{$po_no}</td>
					<td class="col-md-2">{$supplier_name}</td>
					<td class="col-md-2">{$pax}</td>
					<td class="col-md-1">{$grand_total}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}
			{include file='ReportTemplates/footerpurchase.tpl'}
	</div>
