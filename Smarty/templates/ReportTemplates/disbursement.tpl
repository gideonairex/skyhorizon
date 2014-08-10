<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
		
			<div class="col-xs-3">
			</div>
			
			<div class="col-xs-6">
				<h2 class="text-center"> Voucher </h2>
			</div>
			
			<div class="col-xs-3">
			</div>
			
		</div>
		<div class="row">
			<div class="col-xs-6">
				{include file='ReportTemplates/logo.tpl'}
			</div>
			<div class="col-xs-6">
			<h3> Check Details </h3>
				{assign var=disbursement_no value=$CHECKDETAILS.disbursement_no}
				{assign var=bank value=$CHECKDETAILS.bank}
				{assign var=apchk_no value=$CHECKDETAILS.apchk_no}
				{assign var=check_no value=$CHECKDETAILS.check_no}
				{assign var=date_of_check value=$CHECKDETAILS.date_of_check}
				{assign var=amount value=$CHECKDETAILS.amount}
				<table class="table">
					<tr>
						<td> Voucher No </td>
						<td> {$disbursement_no} </td>
					</tr>
					<tr>
						<td> Check No </td>
						<td> {$check_no} </td>
					</tr>
					<tr>
						<td> Bank </td>
						<td> {$bank} </td>
					</tr>
					<tr>
						<td> APCHECK </td>
						<td> {$apchk_no} </td>
					</tr>
					<tr>
						<td> Date of Check </td>
						<td> {$date_of_check} </td>
					</tr>
					<tr>
						<td> Amount </td>
						<td> {$amount} </td>
					</tr>
				</table>
			</div>
			<div class="col-xs-12">
			
{foreach key=DATE item=ARS from=$DATA}

			<h3>{$DATE}</h3>
			<table class="table table-striped">
				<tr>
					<th>AP No</th>
					<th>Payable No</th>
					<th>Payable</th>
					<th>Balance</th>
					<th>Status</th>
					<th>Supplier</th>
				</tr>
			{foreach key=ID item=AR from=$ARS}
				{assign var=ap_no value=$AR.ap_no}
				{assign var=payable_no value=$AR.payable_no}
				{assign var=payable value=$AR.payable}
				{assign var=balance value=$AR.balance}
				{assign var=ap_status value=$AR.ap_status}
				{assign var=supplier_name value=$AR.supplier_name}

				<tr>
					<td>{$ap_no}</td>
					<td>{$payable_no}</td>
					<td>{$payable}</td>
					<td>{$balance}</td>
					<td>{$ap_status}</td>
					<td>{$supplier_name}</td>
				</tr>
			{/foreach}
			</table>
			
{/foreach}

			</div>
		</div>
	</div>
