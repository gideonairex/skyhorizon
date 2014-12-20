<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-6">
				<h2 class="text-center"> Non-trade Payable </h2>
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
				{assign var=expense_no value=$DATA.expense_no}
				{assign var=expense_name value=$DATA.expense_name}
				{assign var=expense_status value=$DATA.expense_status}
				{assign var=date value=$DATA.date}
				{assign var=particulars value=$DATA.particulars}
				{assign var=expense_type value=$DATA.expense_type}
				{assign var=ntp_currency value=$DATA.ntp_currency}
				{assign var=date value=$DATA.date}
				{assign var=cost value=$DATA.cost}
				{assign var=user value=$DATA.user}
				<table class="table">
					<tr>
						<td> Non-trade payable Number </td>
						<td> <strong> {$expense_no} </strong> </td>
					</tr>
					<tr>
						<td> Non-trade payable name </td>
						<td> {$expense_name} </td>
					</tr>
					<tr>
						<td> Expense status </td>
						<td> {$expense_status} </td>
					</tr>
					<tr>
						<td> Expense type </td>
						<td> {$expense_type} </td>
					</tr>
					<tr>
						<td> Date </td>
						<td> {$date} </td>
					</tr>
					<tr>
						<td> Prepared By: </td>
						<td> {$user} </td>
					</tr>
				</table>
			</div>
			</div>

			<div class="col-xs-3">
			</div>
			<div class="col-xs-6">
				<h3>Total Amount</h3>
				<table class="table table-striped">
					<tr>
						<th>Particulars</th>
						<td>{$particulars}</td>
					</tr>
					<tr>
						<th>Cost</th>
						<td>{$ntp_currency} {$cost}</td>
					</tr>
				</table>
			</div>
			<div class="col-xs-3">
			</div>
		</div>
	</div>
