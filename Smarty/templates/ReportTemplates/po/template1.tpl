<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
		
			<div class="col-xs-3">
			</div>
			
			<div class="col-xs-6">
				<h2 class="text-center"> Purchase Order </h2>
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
				{assign var=po_no value=$DATA.po_no}
				{assign var=supplier value=$DATA.supplier}
				
				{assign var=pax value=$DATA.pax}
				{assign var=no_of_pax value=$DATA.no_of_pax}
				{assign var=description value=$DATA.description}
				

				{assign var=cost value=$DATA.cost}
				{assign var=discount value=$DATA.discount}
				
				{assign var=service_fee value=$DATA.service_fee}
				{assign var=rate_per_pax value=$DATA.rate_per_pax}
				{assign var=grand_total value=$DATA.grand_total}
				{assign var=date value=$DATA.date}
				{assign var=confirmation value=$DATA.confirmation}
				
				
				
				
				<table class="table">
					<tr>
						<td> Purchase Number </td>
						<td> {$po_no} </td>
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
						<td> Confirmation No </td>
						<td> {$confirmation} </td>
					</tr>
				</table>
			</div>
			
			<div class="col-xs-8">
				<h3>Particulars</h3>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>PAX</strong></div>
				  <div class="panel-body">
					{$pax}
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Details</strong></div>
				  <div class="panel-body">
					{$description}
				  </div>
				</div>
				
			</div>
			<div class="col-xs-4">
			
				<h3>Total Amount</h3>
				<table class="table table-striped">

					<tr>
						<th>Cost</th>
						<td>{$cost}</td>
					</tr>
					
					<tr>
						<th>Discount</th>
						<td>{$discount}</td>
					</tr>
					
					<tr>
						<th>Service Fee</th>
						<td>{$service_fee}</td>
					</tr>
					
					<tr>
						<th>Quantity</th>
						<td>{$no_of_pax}</td>
					</tr>
					<tr>
						<th>Rate per Pax</th>
						<td>{$rate_per_pax}</td>
					</tr>
					<tr>
						<th>Grand Total</th>
						<td>{$grand_total}</td>
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
