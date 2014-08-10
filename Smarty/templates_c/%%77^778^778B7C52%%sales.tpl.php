<?php /* Smarty version 2.6.18, created on 2014-08-03 20:43:24
         compiled from ReportTemplates/sales.tpl */ ?>
<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
			<div class="row">
				<div class="col-xs-3">
				</div>
				
				<div class="col-xs-6">
					<h2 class="text-center"> Statement of Account </h2>
				</div>
				
				<div class="col-xs-3">
				</div>
			</div>
			
			
			<?php if ($this->_tpl_vars['SHOWLOGO'] == 'true'): ?>
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
					<?php $this->assign('account_name', $this->_tpl_vars['ACCOUNT']['account_name']); ?>

					<table class="table">
						<tr>
							<td> Account Name </td>
							<td> <?php echo $this->_tpl_vars['account_name']; ?>
 </td>
						</tr>
					</table>
				</div>
			</div>
			<?php endif; ?>
			
			
<?php $_from = $this->_tpl_vars['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['DATE'] => $this->_tpl_vars['ARS']):
?>
			
			<h3><?php echo $this->_tpl_vars['DATE']; ?>
</h3>
			<table class="table table-striped">
				<tr>
					<th>SA No</th>
					<th>Account</th>
					<th>Pax</th>
					<th>Route</th>
					<th>Amount Fee</th>
					<th>Service Fee</th>
					<th>VAT</th>
					<th>Vatable Sale</th>
					<th>Grand Total</th>
				</tr>
			<?php $_from = $this->_tpl_vars['ARS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ID'] => $this->_tpl_vars['AR']):
?>
				<?php $this->assign('account_name', $this->_tpl_vars['AR']['account_name']); ?>
				<?php $this->assign('sa_no', $this->_tpl_vars['AR']['sa_no']); ?>
				<?php $this->assign('total_sales_print', $this->_tpl_vars['AR']['total_sales_print']); ?>
				<?php $this->assign('service_fee', $this->_tpl_vars['AR']['service_fee']); ?>
				<?php $this->assign('vat', $this->_tpl_vars['AR']['vat']); ?>
				<?php $this->assign('vatable_sale', $this->_tpl_vars['AR']['vatable_sale']); ?>
				<?php $this->assign('pax', $this->_tpl_vars['AR']['pax']); ?>
				<?php $this->assign('details', $this->_tpl_vars['AR']['details']); ?>
				<?php $this->assign('grand_total', $this->_tpl_vars['AR']['grand_total']); ?>
				
				<tr>
					<td><?php echo $this->_tpl_vars['sa_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['account_name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['pax']; ?>
</td>
					<td><?php echo $this->_tpl_vars['details']; ?>
</td>
					<td><?php echo $this->_tpl_vars['total_sales_print']; ?>
</td>
					<td><?php echo $this->_tpl_vars['service_fee']; ?>
</td>
					<td><?php echo $this->_tpl_vars['vat']; ?>
</td>
					<td><?php echo $this->_tpl_vars['vatable_sale']; ?>
</td>
					<td><?php echo $this->_tpl_vars['grand_total']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
			
<?php endforeach; endif; unset($_from); ?>

	</div>