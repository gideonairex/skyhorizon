<?php /* Smarty version 2.6.18, created on 2014-05-08 18:32:21
         compiled from modules/ModTracker/ShowDiffNotExist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/ModTracker/ShowDiffNotExist.tpl', 15, false),array('modifier', 'vtiger_imageurl', 'modules/ModTracker/ShowDiffNotExist.tpl', 18, false),)), $this); ?>

<div id="orgLay" class="layerPopup">

<table class="layerHeadingULine" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td class="layerPopupHeading" align="left" nowrap="nowrap" width="70%">
		<?php echo getTranslatedString('LBL_NO'); ?>
 <?php echo getTranslatedString('LBL_HISTORY'); ?>

	</td>
	<td align="right" width="2%">
		<a href='javascript:void(0);'><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" onclick="ModTrackerCommon.hide();" align="right" border="0"></a>
	</td>
</tr>
</table>

<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
<tr>
	<td>
		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tr class='lvtColData'>
			<td rowspan='2' width='11%'><img src="<?php echo vtiger_imageurl('set-IcoLoginHistory.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
				<span class='genHeaderSmall'><?php echo getTranslatedString('LBL_THERE_IS_NO_HISTORY_AVAILABLE', $this->_tpl_vars['MODULE']); ?>
</span>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</div>