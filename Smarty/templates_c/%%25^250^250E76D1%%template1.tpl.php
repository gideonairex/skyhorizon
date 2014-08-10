<?php /* Smarty version 2.6.18, created on 2014-08-10 10:48:23
         compiled from ReportTemplates/po/template1.tpl */ ?>
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
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ReportTemplates/logo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div class="col-xs-6">
			<h3> Details </h3>
				<?php $this->assign('po_no', $this->_tpl_vars['DATA']['po_no']); ?>
				<?php $this->assign('supplier', $this->_tpl_vars['DATA']['supplier']); ?>
				
				<?php $this->assign('pax', $this->_tpl_vars['DATA']['pax']); ?>
				<?php $this->assign('no_of_pax', $this->_tpl_vars['DATA']['no_of_pax']); ?>
				<?php $this->assign('description', $this->_tpl_vars['DATA']['description']); ?>
				

				<?php $this->assign('cost', $this->_tpl_vars['DATA']['cost']); ?>
				<?php $this->assign('discount', $this->_tpl_vars['DATA']['discount']); ?>
				
				<?php $this->assign('service_fee', $this->_tpl_vars['DATA']['service_fee']); ?>
				<?php $this->assign('rate_per_pax', $this->_tpl_vars['DATA']['rate_per_pax']); ?>
				<?php $this->assign('grand_total', $this->_tpl_vars['DATA']['grand_total']); ?>
				<?php $this->assign('date', $this->_tpl_vars['DATA']['date']); ?>
				<?php $this->assign('confirmation', $this->_tpl_vars['DATA']['confirmation']); ?>
				
				
				
				
				<table class="table">
					<tr>
						<td> Purchase Number </td>
						<td> <?php echo $this->_tpl_vars['po_no']; ?>
 </td>
					</tr>
					<tr>
						<td> Supplier </td>
						<td> <?php echo $this->_tpl_vars['supplier']; ?>
 </td>
					</tr>

					<tr>
						<td> Date </td>
						<td> <?php echo $this->_tpl_vars['date']; ?>
 </td>
					</tr>
					<tr>
						<td> Confirmation No </td>
						<td> <?php echo $this->_tpl_vars['confirmation']; ?>
 </td>
					</tr>
				</table>
			</div>
			
			<div class="col-xs-8">
				<h3>Particulars</h3>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>PAX</strong></div>
				  <div class="panel-body">
					<?php echo $this->_tpl_vars['pax']; ?>

				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Details</strong></div>
				  <div class="panel-body">
					<?php echo $this->_tpl_vars['description']; ?>

				  </div>
				</div>
				
			</div>
			<div class="col-xs-4">
			
				<h3>Total Amount</h3>
				<table class="table table-striped">

					<tr>
						<th>Cost</th>
						<td><?php echo $this->_tpl_vars['cost']; ?>
</td>
					</tr>
					
					<tr>
						<th>Discount</th>
						<td><?php echo $this->_tpl_vars['discount']; ?>
</td>
					</tr>
					
					<tr>
						<th>Service Fee</th>
						<td><?php echo $this->_tpl_vars['service_fee']; ?>
</td>
					</tr>
					
					<tr>
						<th>Quantity</th>
						<td><?php echo $this->_tpl_vars['no_of_pax']; ?>
</td>
					</tr>
					<tr>
						<th>Rate per Pax</th>
						<td><?php echo $this->_tpl_vars['rate_per_pax']; ?>
</td>
					</tr>
					<tr>
						<th>Grand Total</th>
						<td><?php echo $this->_tpl_vars['grand_total']; ?>
</td>
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