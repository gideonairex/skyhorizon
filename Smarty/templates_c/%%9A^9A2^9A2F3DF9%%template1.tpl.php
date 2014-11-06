<?php /* Smarty version 2.6.18, created on 2014-11-03 12:07:52
         compiled from ReportTemplates/salesagreement/template1.tpl */ ?>
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
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ReportTemplates/logo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div class="col-xs-6">
			<h3> Details </h3>
				<?php $this->assign('sa_no', $this->_tpl_vars['DATA']['sa_no']); ?>
				<?php $this->assign('contact', $this->_tpl_vars['DATA']['contact']); ?>
				
				<?php $this->assign('pax', $this->_tpl_vars['DATA']['pax']); ?>
				<?php $this->assign('quantity', $this->_tpl_vars['DATA']['quantity']); ?>
				<?php $this->assign('details', $this->_tpl_vars['DATA']['details']); ?>
				
				<?php $this->assign('af', $this->_tpl_vars['DATA']['af']); ?>
				<?php $this->assign('sf', $this->_tpl_vars['DATA']['sf']); ?>
				<?php $this->assign('vat', $this->_tpl_vars['DATA']['vat']); ?>
				<?php $this->assign('vatsale', $this->_tpl_vars['DATA']['vatsale']); ?>
				<?php $this->assign('gt', $this->_tpl_vars['DATA']['gt']); ?>
				<?php $this->assign('date', $this->_tpl_vars['DATA']['date']); ?>
				<?php $this->assign('account_name', $this->_tpl_vars['DATA']['account_name']); ?>
				<?php $this->assign('conversion', $this->_tpl_vars['DATA']['conversion']); ?>
				<?php $this->assign('branch', $this->_tpl_vars['DATA']['branch']); ?>
				<table class="table">
					<tr>
						<td> SA No </td>
						<td> <?php echo $this->_tpl_vars['sa_no']; ?>
 </td>
					</tr>
					<tr>
						<td> Account Name </td>
						<td> <?php echo $this->_tpl_vars['account_name']; ?>
 </td>
					</tr>
					<?php if ($this->_tpl_vars['branch'] != ''): ?>
					<tr>
						<td>
							Branch
						</td>
						<td>
							<?php echo $this->_tpl_vars['branch']; ?>

						</td>
					</tr>
					<?php endif; ?>
					<tr>
						<td> Contact </td>
						<td> <?php echo $this->_tpl_vars['contact']; ?>
 </td>
					</tr>
					<tr>
						<td> Date </td>
						<td> <?php echo $this->_tpl_vars['date']; ?>
 </td>
					</tr>
				</table>
			</div>
			
			<div class="col-xs-8">
				<h3>Particulars</h3>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Name of Passengers</strong></div>
				  <div class="panel-body">
					<?php echo $this->_tpl_vars['pax']; ?>

				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-heading"><strong>Details</strong></div>
				  <div class="panel-body">
					<?php echo $this->_tpl_vars['details']; ?>

				  </div>
				</div>
				
			</div>
			<div class="col-xs-4">
			
				<h3>Total Amount</h3>
				<table class="table table-striped">
					<tr>
						<th>Quantity</th>
						<td><?php echo $this->_tpl_vars['quantity']; ?>
</td>
					</tr>
					<tr>
						<th>Amount Fee</th>
						<td><?php echo $this->_tpl_vars['conversion']; ?>
 <?php echo $this->_tpl_vars['af']; ?>
</td>
					</tr>
					<tr>
						<th>Service Fee</th>
						<td><?php echo $this->_tpl_vars['sf']; ?>
</td>
					</tr>
					
					<tr>
						<th>VAT Sales</th>
						<td><?php echo $this->_tpl_vars['vatsale']; ?>
</td>
					</tr>
					
					<tr>
						<th>VAT</th>
						<td><?php echo $this->_tpl_vars['vat']; ?>
</td>
					</tr>
					
					<tr>
						<th>Grand Total</th>
						<td><?php echo $this->_tpl_vars['conversion']; ?>
 <strong><?php echo $this->_tpl_vars['gt']; ?>
</strong></td>
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