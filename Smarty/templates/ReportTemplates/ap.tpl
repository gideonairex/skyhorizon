<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
{include file='ReportTemplates/header.tpl'}
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				<div class="col-xs-6">
					<h2 class="text-center"> Outstanding Accounts Payable</h2>
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
						<tr>
							<td> Grand Balance Total </td>
							<td> {$GRANDTOTAL} </td>
						</tr>
					</table>
				</div>
			</div>
{foreach key=DATE item=APS from=$DATA}
			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
					<th class="col-md-2">PO No</th>
					<th class="col-md-2">Supplier</th>
					<th class="col-md-2">Status</th>
					<th class="col-md-2">Payable</th>
					<th class="col-md-2">Payment</th>
					<th class="col-md-2">Balance</th>
				</tr>
			{foreach key=ID item=AP from=$APS}
				{assign var=po_no value=$AP.po_no}
				{assign var=supplier_name value=$AP.supplier_name}
				{assign var=ap_status value=$AP.ap_status}
				{assign var=payable value=$AP.payable}
				{assign var=payment value=$AP.payment}
				{assign var=balance value=$AP.balance}
				<tr>
					<td class="col-md-2">{$po_no}</td>
					<td class="col-md-2">{$supplier_name}</td>
					<td class="col-md-2">{$ap_status}</td>
					<td class="col-md-2">{$payable}</td>
					<td class="col-md-2">{$payment}</td>
					<td class="col-md-2">{$balance}</td>
				</tr>
			{/foreach}
			</table>
{/foreach}
	</div>
