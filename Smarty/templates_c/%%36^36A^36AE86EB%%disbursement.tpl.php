<?php /* Smarty version 2.6.18, created on 2014-08-03 19:48:29
         compiled from ReportTemplates/disbursement.tpl */ ?>
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
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'ReportTemplates/logo.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div class="col-xs-6">
			<h3> Check Details </h3>
				<?php $this->assign('disbursement_no', $this->_tpl_vars['CHECKDETAILS']['disbursement_no']); ?>
				<?php $this->assign('bank', $this->_tpl_vars['CHECKDETAILS']['bank']); ?>
				<?php $this->assign('apchk_no', $this->_tpl_vars['CHECKDETAILS']['apchk_no']); ?>
				<?php $this->assign('check_no', $this->_tpl_vars['CHECKDETAILS']['check_no']); ?>
				<?php $this->assign('date_of_check', $this->_tpl_vars['CHECKDETAILS']['date_of_check']); ?>
				<?php $this->assign('amount', $this->_tpl_vars['CHECKDETAILS']['amount']); ?>
				<table class="table">
					<tr>
						<td> Voucher No </td>
						<td> <?php echo $this->_tpl_vars['disbursement_no']; ?>
 </td>
					</tr>
					<tr>
						<td> Check No </td>
						<td> <?php echo $this->_tpl_vars['check_no']; ?>
 </td>
					</tr>
					<tr>
						<td> Bank </td>
						<td> <?php echo $this->_tpl_vars['bank']; ?>
 </td>
					</tr>
					<tr>
						<td> APCHECK </td>
						<td> <?php echo $this->_tpl_vars['apchk_no']; ?>
 </td>
					</tr>
					<tr>
						<td> Date of Check </td>
						<td> <?php echo $this->_tpl_vars['date_of_check']; ?>
 </td>
					</tr>
					<tr>
						<td> Amount </td>
						<td> <?php echo $this->_tpl_vars['amount']; ?>
 </td>
					</tr>
				</table>
			</div>
			<div class="col-xs-12">
			
<?php $_from = $this->_tpl_vars['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['DATE'] => $this->_tpl_vars['ARS']):
?>

			<h3><?php echo $this->_tpl_vars['DATE']; ?>
</h3>
			<table class="table table-striped">
				<tr>
					<th>AP No</th>
					<th>Payable No</th>
					<th>Payable</th>
					<th>Balance</th>
					<th>Status</th>
					<th>Supplier</th>
				</tr>
			<?php $_from = $this->_tpl_vars['ARS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ID'] => $this->_tpl_vars['AR']):
?>
				<?php $this->assign('ap_no', $this->_tpl_vars['AR']['ap_no']); ?>
				<?php $this->assign('payable_no', $this->_tpl_vars['AR']['payable_no']); ?>
				<?php $this->assign('payable', $this->_tpl_vars['AR']['payable']); ?>
				<?php $this->assign('balance', $this->_tpl_vars['AR']['balance']); ?>
				<?php $this->assign('ap_status', $this->_tpl_vars['AR']['ap_status']); ?>
				<?php $this->assign('supplier_name', $this->_tpl_vars['AR']['supplier_name']); ?>

				<tr>
					<td><?php echo $this->_tpl_vars['ap_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['payable_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['payable']; ?>
</td>
					<td><?php echo $this->_tpl_vars['balance']; ?>
</td>
					<td><?php echo $this->_tpl_vars['ap_status']; ?>
</td>
					<td><?php echo $this->_tpl_vars['supplier_name']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
			
<?php endforeach; endif; unset($_from); ?>

			</div>
		</div>
	</div>