<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-6">
				<h2 class="text-center"> Non-trade Receivable </h2>
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
				{assign var=ntr_no value=$DATA.ntr_no}
				{assign var=ntr_type value=$DATA.ntr_type}
				{assign var=date value=$DATA.date}
				{assign var=particulars value=$DATA.particulars}
				{assign var=other value=$DATA.other}
				{assign var=ntr_currency value=$DATA.ntr_currency}
				{assign var=supplier value=$DATA.supplier}
				{assign var=ntr_status value=$DATA.ntr_status}
				{assign var=receivable value=$DATA.receivable}
				{assign var=total value=$DATA.total}
				{assign var=user value=$DATA.user}
				<table class="table">
					<tr>
						<td> Non-trade Receivable Number </td>
						<td> <strong> {$ntr_no} </strong> </td>
					</tr>
					<tr>
						<td> Non-trade Receivable Type </td>
						<td> {$ntr_type} </td>
					</tr>
					<tr>
						<td> Status </td>
						<td> {$ntr_status} </td>
					</tr>
					<tr>
						<td> Supplier </td>
						<td> {$supplier} </td>
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
						<th>Receivable</th>
						<td>{$receivable}</td>
					</tr>
					<tr>
						<th>Other</th>
						<td>{$other}</td>
					</tr>
					<tr>
						<th>Total</th>
						<td>{$ntr_currency} {$total}</td>
					</tr>
				</table>
			</div>
			<div class="col-xs-3">
			</div>
		</div>
	</div>
