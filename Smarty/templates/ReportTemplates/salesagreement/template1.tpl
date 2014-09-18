<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
		
			<div class="col-xs-3">
			</div>
			
			<div class="col-xs-6">
				<h2 class="text-center"> Sales Agreement </h2>
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
				{assign var=sa_no value=$DATA.sa_no}
				{assign var=contact value=$DATA.contact}
				
				{assign var=pax value=$DATA.pax}
				{assign var=quantity value=$DATA.quantity}
				{assign var=details value=$DATA.details}
				
				{assign var=af value=$DATA.af}
				{assign var=sf value=$DATA.sf}
				{assign var=vat value=$DATA.vat}
				{assign var=vatsale value=$DATA.vatsale}
				{assign var=gt value=$DATA.gt}
				{assign var=date value=$DATA.date}
				{assign var=account_name value=$DATA.account_name}
				{assign var=conversion value=$DATA.conversion}
				{assign var=branch value=$DATA.branch}
				<table class="table">
					<tr>
						<td> SA No </td>
						<td> {$sa_no} </td>
					</tr>
					<tr>
						<td> Account Name </td>
						<td> {$account_name} </td>
					</tr>
					{if $branch != ''}
					<tr>
						<td>
							Branch
						</td>
						<td>
							{$branch}
						</td>
					</tr>
					{/if}
					<tr>
						<td> Contact </td>
						<td> {$contact} </td>
					</tr>
					<tr>
						<td> Date </td>
						<td> {$date} </td>
					</tr>
				</table>
			</div>
			
			<div class="col-xs-8">
				<h3>Particulars</h3>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Name of Passengers</strong></div>
				  <div class="panel-body">
					{$pax}
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Details</strong></div>
				  <div class="panel-body">
					{$details}
				  </div>
				</div>
				
			</div>
			<div class="col-xs-4">
			
				<h3>Total Amount</h3>
				<table class="table table-striped">
					<tr>
						<th>Quantity</th>
						<td>{$quantity}</td>
					</tr>
					<tr>
						<th>Amount Fee</th>
						<td>{$conversion} {$af}</td>
					</tr>
					<tr>
						<th>Service Fee</th>
						<td>{$sf}</td>
					</tr>
					
					<tr>
						<th>VAT Sales</th>
						<td>{$vatsale}</td>
					</tr>
					
					<tr>
						<th>VAT</th>
						<td>{$vat}</td>
					</tr>
					
					<tr>
						<th>Grand Total</th>
						<td>{$conversion} <strong>{$gt}</strong></td>
					</tr>
				</table>
			</div>
			
			<div class="col-xs-8">
				<p>
					<strong> Important Notice: </strong> After issuance of Tickets & Hotel Voucher. In case of voluntary cancellations or revisions of airline tickets & voucher. I hereby agree to pay all the penalties that applies. Thank you
				</p>
			</div>
			<div class="col-xs-4">
				<p> Name of Flight Details Verfified Correct: </p>
				<br>
				<p style="border-top:1px solid black" class="text-center"> Signed over Printed Name Date</p>
			</div>
		</div>
	</div>
