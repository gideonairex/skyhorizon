<?php /* Smarty version 2.6.18, created on 2014-08-16 10:56:59
         compiled from ReportTemplates/ar.tpl */ ?>
<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
<?php $_from = $this->_tpl_vars['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['DATE'] => $this->_tpl_vars['ARS']):
?>

			<h3><?php echo $this->_tpl_vars['DATE']; ?>
</h3>
			<table class="table table-striped">
				<tr>
					<th>SA No</th>
					<th>AR No</th>
					<th>Aging</th>
					<th>AF</th>
					<th>SF</th>
					<th>VAT</th>
					<th>Vatable Sale</th>
					<th>Pax</th>
					<th>Route</th>
				</tr>
			<?php $_from = $this->_tpl_vars['ARS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ID'] => $this->_tpl_vars['AR']):
?>
				<?php $this->assign('sa_no', $this->_tpl_vars['AR']['sa_no']); ?>
				<?php $this->assign('ar_no', $this->_tpl_vars['AR']['ar_no']); ?>
				<?php $this->assign('aging', $this->_tpl_vars['AR']['aging']); ?>
				<?php $this->assign('total_sales_print', $this->_tpl_vars['AR']['total_sales_print']); ?>
				<?php $this->assign('service_fee', $this->_tpl_vars['AR']['service_fee']); ?>
				<?php $this->assign('vat', $this->_tpl_vars['AR']['vat']); ?>
				<?php $this->assign('vatable_sale', $this->_tpl_vars['AR']['vatable_sale']); ?>
				<?php $this->assign('pax', $this->_tpl_vars['AR']['pax']); ?>
				<?php $this->assign('details', $this->_tpl_vars['AR']['details']); ?>
				

				<tr>
					<td><?php echo $this->_tpl_vars['sa_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['ar_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['aging']; ?>
 days</td>
					<td><?php echo $this->_tpl_vars['total_sales_print']; ?>
</td>
					<td><?php echo $this->_tpl_vars['service_fee']; ?>
</td>
					<td><?php echo $this->_tpl_vars['vat']; ?>
</td>
					<td><?php echo $this->_tpl_vars['vatable_sale']; ?>
</td>
					<td><?php echo $this->_tpl_vars['pax']; ?>
</td>
					<td><?php echo $this->_tpl_vars['details']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
			
<?php endforeach; endif; unset($_from); ?>
</div>
		</div>
	</div>