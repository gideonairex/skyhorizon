<?php /* Smarty version 2.6.18, created on 2014-05-10 14:54:44
         compiled from ReportColumns.tpl */ ?>
<script>
var moveupLinkObj,moveupDisabledObj,movedownLinkObj,movedownDisabledObj;
</script>
<table class="small" bgcolor="#ffffff" border="0" cellpadding="5" cellspacing="0"  valign="top" height="500" width="100%">
	<tbody><tr>
	<td colspan="4">
	<span class="genHeaderGray"><?php echo $this->_tpl_vars['MOD']['LBL_SELECT_COLUMNS']; ?>
</span><br>
	<?php echo $this->_tpl_vars['MOD']['LBL_SELECT_COLUMNS_TO_GENERATE_REPORTS']; ?>
 
	<hr>
	</td>
	</tr>
	<tr>
	<td colspan="2" height="26"><b><?php echo $this->_tpl_vars['MOD']['LBL_AVAILABLE_FIELDS']; ?>
</b></td>
	<td colspan="2"><b><?php echo $this->_tpl_vars['MOD']['LBL_SELECTED_FIELDS']; ?>
</b></td>
	</tr>
	<tr  valign="top">
	<td style="padding-right: 5px;" align="right" width="40%">
	<select id="availList" multiple size="16" name="availList" class="txtBox">
	<?php echo $this->_tpl_vars['BLOCK1']; ?>

	</select>
	</td>
	<td style="padding: 5px;" align="center" width="10%">
	<input name="add" value=" <?php echo $this->_tpl_vars['APP']['LBL_ADD_ITEM']; ?>
 &gt " class="classBtn" type="button" onClick="addColumn()">
	</td>
	<input type="hidden" name="selectedColumnsString"/>
	<td style="padding-left: 5px;" align="left" width="40%">
	<select id="selectedColumns" size="16" name="selectedColumns" onchange="selectedColumnClick(this);" multiple class="txtBox">
	<?php echo $this->_tpl_vars['BLOCK2']; ?>

	</select>
	</td>
	<td style="padding-left: 5px;" align="left" width="10%">
	<table border="0" cellpadding="0" cellspacing="0">
		<tbody><tr> 
		<td>
		<img src="themes/images/movecol_up.gif" onmouseover="this.src='themes/images/movecol_up.gif'" onmouseout="this.src='themes/images/movecol_up.gif'" onclick="moveUp()" onmousedown="this.src='themes/images/movecol_up.gif'" align="absmiddle" border="0"> 
		</td>
		</tr>
		<tr> 
		<td> 
		<img src="themes/images/movecol_down.gif" onmouseover="this.src='themes/images/movecol_down.gif'" onmouseout="this.src='themes/images/movecol_down.gif'" onclick="moveDown()" onmousedown="this.src='themes/images/movecol_down.gif'" align="absmiddle" border="0"> 
		</td>
		</tr>
		<tr> 
		<td>
		<img src="themes/images/movecol_del.gif" onmouseover="this.src='themes/images/movecol_del.gif'" onmouseout="this.src='themes/images/movecol_del.gif'" onclick="delColumn()" onmousedown="this.src='themes/images/movecol_del.gif'" align="absmiddle" border="0">
		</td>
		</tr>
		</tbody>
	</table> 
	</td>
	</tr> 
	<tr><td colspan="4" height="215"></td></tr>
	</tbody>
</table>