<?php /* Smarty version 2.6.18, created on 2014-09-25 15:29:14
         compiled from DetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtlib_purify', 'DetailView.tpl', 34, false),array('modifier', 'vtiger_imageurl', 'DetailView.tpl', 216, false),array('modifier', 'getTranslatedString', 'DetailView.tpl', 227, false),array('modifier', 'count', 'DetailView.tpl', 248, false),array('modifier', 'in_array', 'DetailView.tpl', 320, false),array('modifier', 'replace', 'DetailView.tpl', 364, false),)), $this); ?>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/Mail.js"></script>
<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script language="JavaScript" type="text/javascript" src="include/jquery/jquery-ui.js"></script>

<script type="text/javascript">
	jQuery.noConflict();
</script>

<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
	<!-- <a class="link"  align="right" href="javascript:;"><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON']; ?>
</a> -->
</span>


<div id="convertleaddiv" style="display:block;position:absolute;left:225px;top:150px;"></div>
<script>
var gVTModule = '<?php echo vtlib_purify($_REQUEST['module']); ?>
';
<?php echo '
function callConvertLeadDiv(id)
{
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'module=Leads&action=LeadsAjax&file=ConvertLead&record=\'+id,
                        onComplete: function(response) {
                                $("convertleaddiv").innerHTML=response.responseText;
				eval($("conv_leadcal").innerHTML);
                        }
                }
        );
}
function showHideStatus(sId,anchorImgId,sImagePath)
{
	oObj = eval(document.getElementById(sId));
	if(oObj.style.display == \'block\')
	{
		oObj.style.display = \'none\';
		if(anchorImgId !=null){
			eval(document.getElementById(anchorImgId)).src =  \'themes/images/inactivate.gif\';
			eval(document.getElementById(anchorImgId)).alt = \'Display\';
			eval(document.getElementById(anchorImgId)).title = \'Display\';
		}
	}
	else
	{
		oObj.style.display = \'block\';
		if(anchorImgId !=null){
			eval(document.getElementById(anchorImgId)).src = \'themes/images/activate.gif\';
			eval(document.getElementById(anchorImgId)).alt = \'Hide\';
			eval(document.getElementById(anchorImgId)).title = \'Hide\';
		}
	}
}
<!-- End Of Code modified by SAKTI on 10th Apr, 2008 -->

<!-- Start of code added by SAKTI on 16th Jun, 2008 -->
function setCoOrdinate(elemId){
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById(\'lstRecordLayout\');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do{
	  leftpos  += aTag.offsetLeft;
	  toppos += aTag.offsetTop;
	} while(aTag = aTag.offsetParent);

	tagName.style.top= toppos + 20 + \'px\';
	tagName.style.left= leftpos - 276 + \'px\';
}

function getListOfRecords(obj, sModule, iId,sParentTab)
{
		new Ajax.Request(
		\'index.php\',
		{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody: \'module=Users&action=getListOfRecords&ajax=true&CurModule=\'+sModule+\'&CurRecordId=\'+iId+\'&CurParentTab=\'+sParentTab,
			onComplete: function(response) {
				sResponse = response.responseText;
				$("lstRecordLayout").innerHTML = sResponse;
				Lay = \'lstRecordLayout\';
				var tagName = document.getElementById(Lay);
				var leftSide = findPosX(obj);
				var topSide = findPosY(obj);
				var maxW = tagName.style.width;
				var widthM = maxW.substring(0,maxW.length-2);
				var getVal = parseInt(leftSide) + parseInt(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = parseInt(leftSide) - parseInt(widthM);
					tagName.style.left = leftSide + 230 + \'px\';
					tagName.style.top = topSide + 20 + \'px\';
				}else{
					tagName.style.left = leftSide + 230 + \'px\';
				}
				setCoOrdinate(obj.id);

				tagName.style.display = \'block\';
				tagName.style.visibility = "visible";
			}
		}
	);
}
'; ?>

function tagvalidate()
{
	if(trim(document.getElementById('txtbox_tagfields').value) != '')
		SaveTag('txtbox_tagfields','<?php echo $this->_tpl_vars['ID']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
');
	else
	{
		alert("<?php echo $this->_tpl_vars['APP']['PLEASE_ENTER_TAG']; ?>
");
		return false;
	}
}
function DeleteTag(id,recordid)
{
	$("vtbusy_info").style.display="inline";
	Effect.Fade('tag_'+id);
	new Ajax.Request(
		'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "file=TagCloud&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajxaction=DELETETAG&recordid="+recordid+"&tagid=" +id,
                        onComplete: function(response) {
						getTagCloud();
						$("vtbusy_info").style.display="none";
                        }
                }
        );
}

//Added to send a file, in Documents module, as an attachment in an email
function sendfile_email()
{
	filename = $('dldfilename').value;
	document.DetailView.submit();
	OpenCompose(filename,'Documents');
}

</script>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'viewBox.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>

<?php if ($this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Leads'): ?>
	<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
		<?php $this->assign('address1', '$MOD.LBL_BILLING_ADDRESS'); ?>
		<?php $this->assign('address2', '$MOD.LBL_SHIPPING_ADDRESS'); ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
		<?php $this->assign('address1', '$MOD.LBL_PRIMARY_ADDRESS'); ?>
		<?php $this->assign('address2', '$MOD.LBL_ALTERNATE_ADDRESS'); ?>
	<?php endif; ?>
	<div id="locateMap" onMouseOut="fninvsh('locateMap')" onMouseOver="fnvshNrm('locateMap')">
		<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
						<a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Main' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_BILLING_ADDRESS']; ?>
</a>
						<a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Other' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_SHIPPING_ADDRESS']; ?>
</a>
					<?php endif; ?>

					<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
						<a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Main' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_PRIMARY_ADDRESS']; ?>
</a>
						<a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Other' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_ALTERNATE_ADDRESS']; ?>
</a>
					<?php endif; ?>

				</td>
			</tr>
		</table>
	</div>
<?php endif; ?>


<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr>
		<td>
			<?php if ($this->_tpl_vars['MODULE'] == 'Billing' || $this->_tpl_vars['MODULE'] == 'Payments' || $this->_tpl_vars['MODULE'] == 'AdvancePayment' || $this->_tpl_vars['MODULE'] == 'MemoAdvice' || $this->_tpl_vars['MODULE'] == 'House' || $this->_tpl_vars['MODULE'] == 'Cars'): ?>
			<br>
			<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
				<tr><td style="height:2px"></td></tr>
					<tr>
						<td style="padding-left:15px;padding-right:50px" class="moduleName" nowrap><a class="hdrLink" href="index.php?action=DetailView&module=HomeOwner&record=<?php echo $this->_tpl_vars['HOMEOWNERID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
">[ Back to Homeowner - <?php echo $this->_tpl_vars['HOMEOWNERENTITY']; ?>
]</a></td>
					</tr>
				<tr><td style="height:2px"></td></tr>
			</TABLE>
			<br>
			<?php else: ?>
				<br>
				<br>
			<?php endif; ?>

			<!-- Contents -->
			<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
				<tr>
					<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
					<td class="showPanelBg" valign=top width=100%>
						<!-- PUBLIC CONTENTS STARTS-->
						<div class="small" style="padding:10px" >
						<br>
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
								<tr><td>
																				<?php $this->assign('USE_ID_VALUE', $this->_tpl_vars['MOD_SEQ_ID']); ?>
									<?php if ($this->_tpl_vars['USE_ID_VALUE'] == ''): ?> <?php $this->assign('USE_ID_VALUE', $this->_tpl_vars['ID']); ?> <?php endif; ?>
									
									<span class="dvHeaderText">[ <?php echo $this->_tpl_vars['USE_ID_VALUE']; ?>
 ] <?php echo $this->_tpl_vars['NAME']; ?>
 -  <?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span>&nbsp;&nbsp;&nbsp;<br><span class="small"><?php echo $this->_tpl_vars['UPDATEINFO']; ?>
</span>&nbsp;<span id="vtbusy_info" style="display:none;" valign="bottom"><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span><span id="vtbusy_info" style="visibility:hidden;" valign="bottom"><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
									
								</td></tr>
							</table>
						<br>

						<!-- Account details tabs -->
						<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
										<tr>
											<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
											<td class="dvtSelectedCell" align=center nowrap><?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
											<td class="dvtTabCache" style="width:10px">&nbsp;</td>
											
											<?php if ($this->_tpl_vars['REPORT'] == 'true'): ?>
											<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=ReportsPerHomeOwner&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_REPORTSHOMEOWNER']; ?>
</a></td>
											<td class="dvtTabCache" style="width:10px">&nbsp;</td>
											<?php endif; ?>
											
											<?php if ($this->_tpl_vars['SinglePane_View'] == 'false' && $this->_tpl_vars['IS_REL_LIST'] != false && count($this->_tpl_vars['IS_REL_LIST']) > 0): ?>
						
												<td class="dvtUnSelectedCell" onmouseout="fnHideDrop('More_Information_Modules_List');" onmouseover="fnDropDown(this,'More_Information_Modules_List');" align="center" nowrap>
													<a href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
<?php echo $this->_tpl_vars['EXT']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a>
													<!--
													<div onmouseover="fnShowDrop('More_Information_Modules_List')" onmouseout="fnHideDrop('More_Information_Modules_List')"
														 id="More_Information_Modules_List" class="drop_mnu" style="left: 502px; top: 76px; display: none;">
														<table border="0" cellpadding="0" cellspacing="0" width="100%">
															<?php $_from = $this->_tpl_vars['IS_REL_LIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_RELATION_ID'] => $this->_tpl_vars['_RELATED_MODULE']):
?>
																<tr><td><a class="drop_down" href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
&selected_header=<?php echo $this->_tpl_vars['_RELATED_MODULE']; ?>
&relation_id=<?php echo $this->_tpl_vars['_RELATION_ID']; ?>
"><?php echo getTranslatedString($this->_tpl_vars['_RELATED_MODULE'], $this->_tpl_vars['MODULE']); ?>
</a></td></tr>
															<?php endforeach; endif; unset($_from); ?>
														</table>
													</div>
													-->
												</td>

											<?php endif; ?>
											
											<td class="dvtTabCache" align="right" style="width:100%">
												<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='DetailView'; DetailView.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';DetailView.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';submitFormForAction('DetailView','EditView');" type="button" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
												<?php endif; ?>
												<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted' && $this->_tpl_vars['MODULE'] != 'Documents'): ?>
													<!-- input title="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='DetailView'; DetailView.isDuplicate.value='true';DetailView.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; submitFormForAction('DetailView','EditView');" type="button" name="Duplicate" value="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_LABEL']; ?>
" &nbsp;--> 
												<?php endif; ?>
												<?php if ($this->_tpl_vars['DELETE'] == 'permitted'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='index'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> var confirmMsg = '<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
' <?php else: ?> var confirmMsg = '<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
' <?php endif; ?>; submitFormForActionWithConfirmation('DetailView', 'Delete', confirmMsg);" type="button" name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
												<?php endif; ?>

												<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
&start=<?php echo $this->_tpl_vars['privrecordstart']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php else: ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
												<?php endif; ?>
												<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdTop" id="jumpBtnIdTop" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php endif; ?>
												<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
&start=<?php echo $this->_tpl_vars['nextrecordstart']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php else: ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php endif; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign=top align=left >
									<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" style="border-bottom:0;">
										<tr valign=top>

											<td align=left>
												<!-- content cache -->


												<table border=0 cellspacing=0 cellpadding=0 width=100%>
													<tr valign=top>
														<td style="padding:5px">
															<!-- Command Buttons -->
															<table border=0 cellspacing=0 cellpadding=0 width=100%>
																<!-- NOTE: We should avoid form-inside-form condition, which could happen when
																   Singlepane view is enabled. -->
																<form action="index.php" method="post" name="DetailView" id="form">
																	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

																	<!-- Start of File Include by SAKTI on 10th Apr, 2008 -->
																	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "include/DetailViewBlockStatus.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

																	<!-- Start of File Include by SAKTI on 10th Apr, 2008 -->

																	<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
																																				<?php if (is_array ( $this->_tpl_vars['hideBlocksTPL'] ) && ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['hideBlocksTPL']) : in_array($_tmp, $this->_tpl_vars['hideBlocksTPL']))): ?>
																			<?php $this->assign('hidingStatBlock', "style='display:none'"); ?>
																		<?php else: ?>
																			<?php $this->assign('hidingStatBlock', ""); ?>
																		<?php endif; ?>
																																				
																		<tr <?php echo $this->_tpl_vars['hidingStatBlock']; ?>
><td style="padding:5px">
																				<!-- Detailed View Code starts here-->
																				<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
																					<tr>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td align=right>
																							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_ADDRESS_INFORMATION'] && ( $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Leads' )): ?>
																								<?php if ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
																									<input name="mapbutton" value="<?php echo $this->_tpl_vars['APP']['LBL_LOCATE_MAP']; ?>
" class="crmbutton small create" type="button" onClick="searchMapLocation( 'Main' )" title="<?php echo $this->_tpl_vars['APP']['LBL_LOCATE_MAP']; ?>
">
																								<?php else: ?>
																									<input name="mapbutton" value="<?php echo $this->_tpl_vars['APP']['LBL_LOCATE_MAP']; ?>
" class="crmbutton small create" type="button" onClick="fnvshobj(this,'locateMap');" onMouseOut="fninvsh('locateMap');" title="<?php echo $this->_tpl_vars['APP']['LBL_LOCATE_MAP']; ?>
">
																								<?php endif; ?>
																							<?php endif; ?>
																						</td>
																					</tr>

																					<!-- This is added to display the existing comments -->
																					<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENTS'] || $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']): ?>
																						<tr>
																							<td colspan=4 class="dvInnerHeader">
																								<b><?php echo $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']; ?>
</b>
																							</td>
																						</tr>
																						<tr>
																							<td colspan=4 class="dvtCellInfo"><?php echo $this->_tpl_vars['COMMENT_BLOCK']; ?>
</td>
																						</tr>
																						<tr><td>&nbsp;</td></tr>
																					<?php endif; ?>


																					<?php if ($this->_tpl_vars['header'] != 'Comments'): ?>

																						<tr><?php echo '<td colspan=4 class="dvInnerHeader"><div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus(\'tbl'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\'aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\''; ?><?php echo $this->_tpl_vars['IMAGE_PATH']; ?><?php echo '\');">'; ?><?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('activate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>'; ?><?php else: ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('inactivate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Display" title="Display"/>'; ?><?php endif; ?><?php echo '</a></div><b>&nbsp;'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b></div></td>'; ?>

																						</tr>
																					<?php endif; ?>																			
																				</table>
																				
																				<?php if ($this->_tpl_vars['header'] != 'Comments'): ?>
																					<?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?>
																						<div style="width:auto;display:block;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
																						<?php else: ?>
																						<div style="width:auto;display:none;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
																						<?php endif; ?>
																							<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
																								<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['detail']):
?>
																									<tr style="height:25px">
																										<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['data']):
?>
																											<?php $this->assign('keyid', $this->_tpl_vars['data']['ui']); ?>
																											<?php $this->assign('keyval', $this->_tpl_vars['data']['value']); ?>
																											<?php $this->assign('keytblname', $this->_tpl_vars['data']['tablename']); ?>
																											<?php $this->assign('keyfldname', $this->_tpl_vars['data']['fldname']); ?>
																											<?php $this->assign('keyfldid', $this->_tpl_vars['data']['fldid']); ?>
																											<?php $this->assign('keyoptions', $this->_tpl_vars['data']['options']); ?>
																											<?php $this->assign('keysecid', $this->_tpl_vars['data']['secid']); ?>
																											<?php $this->assign('keyseclink', $this->_tpl_vars['data']['link']); ?>
																											<?php $this->assign('keycursymb', $this->_tpl_vars['data']['cursymb']); ?>
																											<?php $this->assign('keysalut', $this->_tpl_vars['data']['salut']); ?>
																											<?php $this->assign('keyaccess', $this->_tpl_vars['data']['notaccess']); ?>
																											<?php $this->assign('keycntimage', $this->_tpl_vars['data']['cntimage']); ?>
																											<?php $this->assign('keyadmin', $this->_tpl_vars['data']['isadmin']); ?>
																											<?php $this->assign('display_type', $this->_tpl_vars['data']['displaytype']); ?>
																											<?php $this->assign('_readonly', $this->_tpl_vars['data']['readonly']); ?>

																																																						<?php if (is_array ( $this->_tpl_vars['hideFieldsTPL'] ) && ((is_array($_tmp=$this->_tpl_vars['keyfldname'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['hideFieldsTPL']) : in_array($_tmp, $this->_tpl_vars['hideFieldsTPL']))): ?>
																												<?php $this->assign('hidingStatField', "style='display:none'"); ?>
																											<?php else: ?>
																												<?php $this->assign('hidingStatField', ""); ?>
																											<?php endif; ?>

																																																						
																											<?php if ($this->_tpl_vars['label'] != ''): ?>
																												<?php if ($this->_tpl_vars['keycntimage'] != ''): ?>
																													<td <?php echo $this->_tpl_vars['hidingStatField']; ?>
 class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['keycntimage']; ?>
</td>
																												<?php elseif ($this->_tpl_vars['keyid'] == '71' || $this->_tpl_vars['keyid'] == '72'): ?><!-- Currency symbol -->
																													<td <?php echo $this->_tpl_vars['hidingStatField']; ?>
 class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['label']; ?>
<input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input> (<?php echo $this->_tpl_vars['keycursymb']; ?>
)</td>
																													<?php elseif ($this->_tpl_vars['keyid'] == '9'): ?>
																													<td <?php echo $this->_tpl_vars['hidingStatField']; ?>
 class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['label']; ?>
 <?php echo $this->_tpl_vars['APP']['COVERED_PERCENTAGE']; ?>
</td>
																													<?php elseif ($this->_tpl_vars['keyid'] == '14'): ?>
																													<td <?php echo $this->_tpl_vars['hidingStatField']; ?>
 class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['label']; ?>
<input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input> <?php echo getTranslatedString('LBL_TIMEFIELD'); ?>
 </td>
																													<?php else: ?>
																													<td <?php echo $this->_tpl_vars['hidingStatField']; ?>
 class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['label']; ?>
</td>
																													<?php endif; ?>
																																																										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																												<?php endif; ?>
																											<?php endforeach; endif; unset($_from); ?>
																									</tr>
																								<?php endforeach; endif; unset($_from); ?>
																							</table>
																							<?php if ($this->_tpl_vars['MODULE'] == 'HomeOwner'): ?>
																								<?php if ($this->_tpl_vars['header'] == 'Primary Address Information' && $this->_tpl_vars['HOUSECOUNT'] != 0): ?>
																									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "HouseList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																								<?php endif; ?>
																								<?php if ($this->_tpl_vars['header'] == 'Primary Car' && $this->_tpl_vars['CARCOUNT'] != 0): ?>
																									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CarsList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																								<?php endif; ?>
																							<?php endif; ?>
																						</div>
																					<?php endif; ?>	
																			</td>
																		</tr>
																	<?php endforeach; endif; unset($_from); ?>
																<tr>
																	<td style="padding:5px">
																		<?php if ($this->_tpl_vars['MODULE'] == 'Billing' || $this->_tpl_vars['MODULE'] == 'MemoAdvice'): ?>
																			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'PaymentTrack.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																		<?php endif; ?>
																		
																		<?php if ($this->_tpl_vars['MODULE'] == 'House'): ?>
																			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'GoogleMapDetail.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																		<?php endif; ?>
																	</td>
																</tr>
																
																
																																		<?php if ($this->_tpl_vars['CUSTOM_LINKS'] && ! empty ( $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWWIDGET'] )): ?>
																		<?php $_from = $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CUSTOM_LINK_DETAILVIEWWIDGET']):
?>
																			<?php if (preg_match ( "/^block:\/\/.*/" , $this->_tpl_vars['CUSTOM_LINK_DETAILVIEWWIDGET']->linkurl )): ?>
																				<tr>
																					<td style="padding:5px;" >
																						<?php 
					echo vtlib_process_widget($this->_tpl_vars['CUSTOM_LINK_DETAILVIEWWIDGET'], $this->_tpl_vars);
																						 ?>
																					</td>
																				</tr>
																			<?php endif; ?>
																		<?php endforeach; endif; unset($_from); ?>
																	<?php endif; ?>
																																		<!-- Inventory - Product Details informations -->
																	<tr>
																		<?php echo $this->_tpl_vars['ASSOCIATED_PRODUCTS']; ?>

																	</tr>
																	
																</form>
																<!-- End the form related to detail view -->
																
																<?php if ($this->_tpl_vars['SinglePane_View'] == 'true' && count($this->_tpl_vars['IS_REL_LIST']) > 0): ?>
																	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListNew.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
																	
																<?php endif; ?>
															</table>
														</td></tr>
														
														</table>
											</td>
											<td width=22% valign=top style="border-left:1px dashed #cccccc;padding:13px">

												<!-- right side relevant info -->
												<!-- Action links for Event & Todo START-by Minnie -->
												<table width="100%" border="0" cellpadding="5" cellspacing="0">
													<tr><td align="left" class="genHeaderSmall"><?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
</td></tr>
													
													<?php if ($this->_tpl_vars['MODULE'] == 'Disbursement'): ?>
													
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?module=Disbursement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
" target="_blank" ><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?module=Disbursement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
" target="_blank" >Print Voucher</a>
																</td>
															</tr>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'SHContacts'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SalesAgreement&action=EditView&customer=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=SalesAgreement&action=EditView&customer=<?php echo $this->_tpl_vars['ID']; ?>
">Add Sales Agreement</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SHExpenses&action=EditView&contact_person=<?php echo $this->_tpl_vars['ID']; ?>
&expense_type=Advances to person"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=SHExpenses&action=EditView&contact_person=<?php echo $this->_tpl_vars['ID']; ?>
&expense_type=Advances to person">Create Non-trade Payable</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=NonTradeR&action=EditView&contact_person=<?php echo $this->_tpl_vars['ID']; ?>
&ntr_type=Advances to person"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=NonTradeR&action=EditView&contact_person=<?php echo $this->_tpl_vars['ID']; ?>
&ntr_type=Advances to person">Create Non-trade Receivable</a>
															</td>
														</tr>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'SalesAgreement'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=1" target="_blank"><img src="<?php echo vtiger_imageurl('actionGenerateSalesOrder.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu"  href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=1" target="_blank">Print Template 1</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=2" target="_blank"><img src="<?php echo vtiger_imageurl('actionGenerateSalesOrder.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu"  href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=2" target="_blank">Print Template 2</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=3" target="_blank"><img src="<?php echo vtiger_imageurl('actionGenerateSalesOrder.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu"  href="index.php?module=SalesAgreement&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=3" target="_blank">Print Template 3</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=PO&action=EditView&sa_no=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=PO&action=EditView&sa_no=<?php echo $this->_tpl_vars['ID']; ?>
">Add Purchase Order</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=SHExpenses&action=EditView&sales_agreement=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=SHExpenses&action=EditView&sales_agreement=<?php echo $this->_tpl_vars['ID']; ?>
">Create Non-trade payable</a>
															</td>
														</tr>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'PO'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=PO&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=1" target="_blank"><img src="<?php echo vtiger_imageurl('actionGenerateSalesOrder.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu"  href="index.php?module=PO&action=PrintTemplate&record=<?php echo $this->_tpl_vars['ID']; ?>
&template=1" target="_blank">Print Template</a>
															</td>
														</tr>

														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=NonTradeR&action=EditView&po_no=<?php echo $this->_tpl_vars['ID']; ?>
&ntr_type=Refund from supplier"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu"  href="index.php?module=NonTradeR&action=EditView&po_no=<?php echo $this->_tpl_vars['ID']; ?>
&ntr_type=Refund from supplier">Create Non-trade receivable</a>
															</td>
														</tr>
														<?php if ($this->_tpl_vars['SUBMIT_APRROVED'] == 'true'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?module=PO&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?module=PO&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
">Approve</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'AccountsPayable'): ?>
														<?php if ($this->_tpl_vars['SUBMIT_APRROVED'] == 'true'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?module=AccountsPayable&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?module=AccountsPayable&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
">Approve</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'SHExpenses'): ?>
														<?php if ($this->_tpl_vars['SUBMIT_APRROVED'] == 'true'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?module=SHExpenses&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?module=SHExpenses&action=SubmitForApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
">Approve</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['MODULE'] == 'HomeOwner'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=Billing&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=Billing&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add Billing</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=MemoAdvice&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=MemoAdvice&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add Memo Advice</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add Payment</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=AdvancePayment&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=AdvancePayment&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add Advance Payment</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=House&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=House&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add House</a>
															</td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=Cars&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=Cars&action=EditView&homeowner=<?php echo $this->_tpl_vars['ID']; ?>
">Add Car</a>
															</td>
														</tr>
													<tr><td align="left" style="padding-left:10px;"><br></td></tr>
													<tr><td align="left" class="genHeaderSmall"><?php echo $this->_tpl_vars['APP']['LBL_STATUSHOMEOWNER']; ?>
</td></tr>
														<tr>
															<td align="left" style="padding-left:10px;">Pending Bills: <?php if ($this->_tpl_vars['PENDINGBILLS'] == '0'): ?>0<?php else: ?><span style="color:red"><?php echo $this->_tpl_vars['PENDINGBILLS']; ?>
</span><?php endif; ?></td>
															<td align="left"><button id="viewBill" class="crmButton small save" >View</button></td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">Bills Amt: (Php) <?php if ($this->_tpl_vars['PENDINGAMOUNT'] == ''): ?>0.00<?php else: ?><span style="color:red"><?php echo $this->_tpl_vars['PENDINGAMOUNT']; ?>
</span><?php endif; ?></td>
														</tr>
														<tr><td align="left" style="padding-left:10px;"><br></td></tr>
														<tr>
															<td align="left" style="padding-left:10px;">Pending Memo Advice: <?php if ($this->_tpl_vars['PENDINGMEMO'] == '0'): ?>0<?php else: ?><span style="color:red"><?php echo $this->_tpl_vars['PENDINGMEMO']; ?>
</span><?php endif; ?></td>
															<td align="left"><button id="viewMemo" class="crmButton small save" >View</button></td>
														</tr>
														<tr>
															<td align="left" style="padding-left:10px;">Memo Advice Amt: (Php) <?php if ($this->_tpl_vars['PENDINGAMOUNTMEMO'] == ''): ?>0.00<?php else: ?><span style="color:red"><?php echo $this->_tpl_vars['PENDINGAMOUNTMEMO']; ?>
</span><?php endif; ?></td>
														</tr>
														<tr><td align="left" style="padding-left:10px;"><br></td></tr>
													<?php endif; ?>
													
													<?php if ($this->_tpl_vars['MODULE'] == 'Billing'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['HOMEOWNERID']; ?>
&bill_no=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['HOMEOWNERID']; ?>
&bill_no=<?php echo $this->_tpl_vars['ID']; ?>
">Add Payment</a>
															</td>
														</tr>
													<?php endif; ?>
													
													<?php if ($this->_tpl_vars['MODULE'] == 'MemoAdvice'): ?>
														<tr>
															<td align="left" style="padding-left:10px;">
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['HOMEOWNERID']; ?>
&bill_no=<?php echo $this->_tpl_vars['ID']; ?>
"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																<a class="webMnu" href="index.php?module=Payments&action=EditView&homeowner=<?php echo $this->_tpl_vars['HOMEOWNERID']; ?>
&bill_no=<?php echo $this->_tpl_vars['ID']; ?>
">Add Payment</a>
															</td>
														</tr>
													<?php endif; ?>
													
													<?php if ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
														<?php if ($this->_tpl_vars['CONVERTASFAQ'] == 'permitted'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&record=<?php echo $this->_tpl_vars['ID']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=ConvertAsFAQ"><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&record=<?php echo $this->_tpl_vars['ID']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=ConvertAsFAQ"><?php echo $this->_tpl_vars['MOD']['LBL_CONVERT_AS_FAQ_BUTTON_LABEL']; ?>
</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
														<?php if ($this->_tpl_vars['CONVERTINVOICE'] == 'permitted'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&convertmode=<?php echo $this->_tpl_vars['CONVERTMODE']; ?>
&module=Invoice&action=EditView&account_id=<?php echo $this->_tpl_vars['ACCOUNTID']; ?>
"><img src="<?php echo vtiger_imageurl('actionGenerateInvoice.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a class="webMnu" href="index.php?return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&convertmode=<?php echo $this->_tpl_vars['CONVERTMODE']; ?>
&module=Invoice&action=EditView&account_id=<?php echo $this->_tpl_vars['ACCOUNTID']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_CREATE']; ?>
 <?php echo $this->_tpl_vars['APP']['Invoice']; ?>
</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php elseif ($this->_tpl_vars['TODO_PERMISSION'] == 'true' || $this->_tpl_vars['EVENT_PERMISSION'] == 'true' || $this->_tpl_vars['CONTACT_PERMISSION'] == 'true' || $this->_tpl_vars['MODULE'] == 'Contacts' || ( $this->_tpl_vars['MODULE'] == 'Documents' ) || $this->_tpl_vars['MODULE'] == 'HomeOwner' || $this->_tpl_vars['MODULE'] == 'SalesAgreement' || $this->_tpl_vars['MODULE'] == 'PO'): ?>

														<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
															<?php $this->assign('subst', 'contact_id'); ?>
															<?php $this->assign('acc', "&account_id=".($this->_tpl_vars['accountid'])); ?>
														<?php else: ?>
															<?php $this->assign('subst', 'parent_id'); ?>
															<?php $this->assign('acc', ""); ?>
														<?php endif; ?>

														<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'HomeOwner' || $this->_tpl_vars['MODULE'] == 'SalesAgreement' || $this->_tpl_vars['MODULE'] == 'PO'): ?>
															<?php if ($this->_tpl_vars['SENDMAILBUTTON'] == 'permitted'): ?>
																<tr>
																	<td align="left" style="padding-left:10px;">
																		<?php $_from = $this->_tpl_vars['EMAILS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['email']):
?>
																			<input type="hidden" name="email_<?php echo $this->_tpl_vars['index']; ?>
" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
																		<?php endforeach; endif; unset($_from); ?>
																		<a href="javascript:void(0);" class="webMnu" onclick="<?php echo $this->_tpl_vars['JS']; ?>
"><img src="<?php echo vtiger_imageurl('sendmail.png', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>&nbsp;
																		<a href="javascript:void(0);" class="webMnu" onclick="<?php echo $this->_tpl_vars['JS']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_SENDMAIL_BUTTON_LABEL']; ?>
</a>
																	</td>
																</tr>
															<?php endif; ?>
														<?php endif; ?>

														<?php if ($this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['EVENT_PERMISSION'] == 'true'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Events&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddEvent.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Events&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Event']; ?>
</a>
																</td>
															</tr>
														<?php endif; ?>

														<?php if ($this->_tpl_vars['TODO_PERMISSION'] == 'true' && ( $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Leads' )): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddToDo.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
</a>
																</td>
															</tr>
														<?php endif; ?>

														<?php if ($this->_tpl_vars['MODULE'] == 'Contacts' && $this->_tpl_vars['CONTACT_PERMISSION'] == 'true'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><img src="<?php echo vtiger_imageurl('AddToDo.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
																	<a href="index.php?module=Calendar&action=EditView&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_action=DetailView&activity_mode=Task&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&<?php echo $this->_tpl_vars['subst']; ?>
=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['acc']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" class="webMnu"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
</a>
																</td>
															</tr>
														<?php endif; ?>

														<?php if ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
															<?php if ($this->_tpl_vars['CONVERTLEAD'] == 'permitted'): ?>
																<tr>
																	<td align="left" style="padding-left:10px;">
																		<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('<?php echo $this->_tpl_vars['ID']; ?>
');"><img src="<?php echo vtiger_imageurl('Leads.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a>
																		<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('<?php echo $this->_tpl_vars['ID']; ?>
');"><?php echo $this->_tpl_vars['APP']['LBL_CONVERT_BUTTON_LABEL']; ?>
</a>
																	</td>
																</tr>
															<?php endif; ?>
														<?php endif; ?>

														<!-- Start: Actions for Documents Module -->
														<?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
															<tr><td align="left" style="padding-left:10px;">
																	<?php if ($this->_tpl_vars['DLD_TYPE'] == 'I' && $this->_tpl_vars['FILE_STATUS'] == '1' && $this->_tpl_vars['FILE_EXIST'] == 'yes'): ?>
																		<br><a href="index.php?module=uploads&action=downloadfile&fileid=<?php echo $this->_tpl_vars['FILEID']; ?>
&entityid=<?php echo $this->_tpl_vars['NOTESID']; ?>
"  onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);" class="webMnu"><img src="<?php echo vtiger_imageurl('fbDownload.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_DOWNLOAD']; ?>
" border="0"/></a>
																		<a href="index.php?module=uploads&action=downloadfile&fileid=<?php echo $this->_tpl_vars['FILEID']; ?>
&entityid=<?php echo $this->_tpl_vars['NOTESID']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_DOWNLOAD_FILE']; ?>
</a>
																	<?php elseif ($this->_tpl_vars['DLD_TYPE'] == 'E' && $this->_tpl_vars['FILE_STATUS'] == '1'): ?>
																		<br><a target="_blank" href="<?php echo $this->_tpl_vars['DLD_PATH']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><img src="<?php echo vtiger_imageurl('fbDownload.gif', $this->_tpl_vars['THEME']); ?>
"" align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_DOWNLOAD']; ?>
" border="0"></a>
																		<a target="_blank" href="<?php echo $this->_tpl_vars['DLD_PATH']; ?>
" onclick="javascript:dldCntIncrease(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_DOWNLOAD_FILE']; ?>
</a>
																	<?php endif; ?>
																</td></tr>
																<?php if ($this->_tpl_vars['CHECK_INTEGRITY_PERMISSION'] == 'yes'): ?>
																<tr><td align="left" style="padding-left:10px;">
																		<br><a href="javascript:;" onClick="checkFileIntegrityDetailView(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><img id="CheckIntegrity_img_id" src="<?php echo vtiger_imageurl('yes.gif', $this->_tpl_vars['THEME']); ?>
" alt="Check integrity of this file" title="Check integrity of this file" hspace="5" align="absmiddle" border="0"/></a>
																		<a href="javascript:;" onClick="checkFileIntegrityDetailView(<?php echo $this->_tpl_vars['NOTESID']; ?>
);"><?php echo $this->_tpl_vars['MOD']['LBL_CHECK_INTEGRITY']; ?>
</a>&nbsp;
																		<input type="hidden" id="dldfilename" name="dldfilename" value="<?php echo $this->_tpl_vars['FILEID']; ?>
-<?php echo $this->_tpl_vars['FILENAME']; ?>
">
																		<span id="vtbusy_integrity_info" style="display:none;">
																			<img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
																		<span id="integrity_result" style="display:none"></span>
																	</td></tr>
																<?php endif; ?>
															<tr><td align="left" style="padding-left:10px;">
																	<?php if ($this->_tpl_vars['DLD_TYPE'] == 'I' && $this->_tpl_vars['FILE_STATUS'] == '1' && $this->_tpl_vars['FILE_EXIST'] == 'yes'): ?>
																		<input type="hidden" id="dldfilename" name="dldfilename" value="<?php echo $this->_tpl_vars['FILEID']; ?>
-<?php echo $this->_tpl_vars['FILENAME']; ?>
">
																		<br><a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; document.DetailView.return_id.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; sendfile_email();" class="webMnu"><img src="<?php echo vtiger_imageurl('attachment.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></a>
																		<a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; document.DetailView.return_id.value=<?php echo $this->_tpl_vars['NOTESID']; ?>
; sendfile_email();"><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_FILE']; ?>
</a>
																	<?php endif; ?>
																</td></tr>
															<tr><td>&nbsp;</td></tr>

														<?php endif; ?>
													<?php endif; ?>
													
																										<?php if ($this->_tpl_vars['MODULE'] == 'PersonnelAssignments'): ?>
														<?php if ($this->_tpl_vars['ACTIVATE_PERSONNEL_LINK'] == 'YES'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<!-- <a class="webMnu" href="#" ><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a> -->
																	<a class="webMnu" href="#" onclick="return jQuery.fn.confirmationPrompt();">Activate Personnel</a>
																</td>
															</tr>
														<?php elseif ($this->_tpl_vars['DEACTIVATE_PERSONNEL_LINK'] == 'YES'): ?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<!-- <a class="webMnu" href="#" ><img src="<?php echo vtiger_imageurl('convert.gif', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle"  border="0"/></a> -->
																	<a class="webMnu" href="#" onclick="return jQuery.fn.confirmationPrompt();">Deactivate Personnel</a>
																</td>
															</tr>
														<?php endif; ?>
													<?php endif; ?>
													
													
													
																										
													
												</table>
																								<?php if (! isset ( $this->_tpl_vars['CUSTOM_LINKS'] ) || empty ( $this->_tpl_vars['CUSTOM_LINKS'] )): ?>
													<br>
												<?php endif; ?>

																								<?php if ($this->_tpl_vars['CUSTOM_LINKS'] && $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWBASIC']): ?>
													<table width="100%" border="0" cellpadding="5" cellspacing="0">
														<?php $_from = $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWBASIC']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CUSTOMLINK']):
?>
															<tr>
																<td align="left" style="padding-left:10px;">
																	<?php $this->assign('customlink_href', $this->_tpl_vars['CUSTOMLINK']->linkurl); ?>
																	<?php $this->assign('customlink_label', $this->_tpl_vars['CUSTOMLINK']->linklabel); ?>
																	<?php if ($this->_tpl_vars['customlink_label'] == ''): ?>
																		<?php $this->assign('customlink_label', $this->_tpl_vars['customlink_href']); ?>
																	<?php else: ?>
																																				<?php $this->assign('customlink_label', getTranslatedString($this->_tpl_vars['customlink_label'], $this->_tpl_vars['CUSTOMLINK']->module())); ?>
																	<?php endif; ?>
																	<?php if ($this->_tpl_vars['CUSTOMLINK']->linkicon): ?>
																		<a class="webMnu" href="<?php echo $this->_tpl_vars['customlink_href']; ?>
"><img hspace=5 align="absmiddle" border=0 src="<?php echo $this->_tpl_vars['CUSTOMLINK']->linkicon; ?>
"></a>
																		<?php endif; ?>
																	<a class="webMnu" href="<?php echo $this->_tpl_vars['customlink_href']; ?>
"><?php echo $this->_tpl_vars['customlink_label']; ?>
</a>
																</td>
															</tr>
														<?php endforeach; endif; unset($_from); ?>
													</table>
												<?php endif; ?>

																								<?php if ($this->_tpl_vars['CUSTOM_LINKS'] && $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEW']): ?>
													<br>
													<?php if (! empty ( $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEW'] )): ?>
														<table width="100%" border="0" cellpadding="5" cellspacing="0">
															<tr><td align="left" class="dvtUnSelectedCell dvtCellLabel">
																	<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_customLinksLay');" onclick="fnvshobj(this,'vtlib_customLinksLay');"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
 &#187;</b></a>
																</td></tr>
														</table>
														<br>
														<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_customLinksLay"
															 onmouseout="fninvsh('vtlib_customLinksLay')" onmouseover="fnvshNrm('vtlib_customLinksLay')">
															<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
																<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ACTIONS']; ?>
 &#187;</b></td></tr>
																<tr>
																	<td>
																		<?php $_from = $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEW']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CUSTOMLINK']):
?>
																			<?php $this->assign('customlink_href', $this->_tpl_vars['CUSTOMLINK']->linkurl); ?>
																			<?php $this->assign('customlink_label', $this->_tpl_vars['CUSTOMLINK']->linklabel); ?>
																			<?php if ($this->_tpl_vars['customlink_label'] == ''): ?>
																				<?php $this->assign('customlink_label', $this->_tpl_vars['customlink_href']); ?>
																			<?php else: ?>
																																								<?php $this->assign('customlink_label', getTranslatedString($this->_tpl_vars['customlink_label'], $this->_tpl_vars['CUSTOMLINK']->module())); ?>
																			<?php endif; ?>
																			<a href="<?php echo $this->_tpl_vars['customlink_href']; ?>
" class="drop_down"><?php echo $this->_tpl_vars['customlink_label']; ?>
</a>
																		<?php endforeach; endif; unset($_from); ?>
																	</td>
																</tr>
															</table>
														</div>
													<?php endif; ?>
												<?php endif; ?>
																								<!-- Action links END -->

																								<!-- Mail Merge-->
												<br>
												<?php if ($this->_tpl_vars['MERGEBUTTON'] == 'permitted'): ?>
													<form action="index.php" method="post" name="TemplateMerge" id="form">
														<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
														<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
														<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
														<input type="hidden" name="action">
														<table border=0 cellspacing=0 cellpadding=0 width=100% class="rightMailMerge">
															<tr>
																<td class="rightMailMergeHeader"><b><?php echo $this->_tpl_vars['WORDTEMPLATEOPTIONS']; ?>
</b></td>
															</tr>
															<tr style="height:25px">
																<td class="rightMailMergeContent">
																	<?php if ($this->_tpl_vars['TEMPLATECOUNT'] != 0): ?>
																		<select name="mergefile"><?php $_from = $this->_tpl_vars['TOPTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['templid'] => $this->_tpl_vars['tempflname']):
?><option value="<?php echo $this->_tpl_vars['templid']; ?>
"><?php echo $this->_tpl_vars['tempflname']; ?>
</option><?php endforeach; endif; unset($_from); ?></select>
																		<input class="crmbutton small create" value="<?php echo $this->_tpl_vars['APP']['LBL_MERGE_BUTTON_LABEL']; ?>
" onclick="this.form.action.value='Merge';" type="submit"></input>
																	<?php else: ?>
																		<a href=index.php?module=Settings&action=upload&tempModule=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=Settings><?php echo $this->_tpl_vars['APP']['LBL_CREATE_MERGE_TEMPLATE']; ?>
</a>
																	<?php endif; ?>
																</td>
															</tr>
														</table>
													</form>
												<?php endif; ?>

												<?php if (! empty ( $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWWIDGET'] )): ?>
													<?php $_from = $this->_tpl_vars['CUSTOM_LINKS']['DETAILVIEWWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['CUSTOMLINK_NO'] => $this->_tpl_vars['CUSTOMLINK']):
?>
														<?php $this->assign('customlink_href', $this->_tpl_vars['CUSTOMLINK']->linkurl); ?>
														<?php $this->assign('customlink_label', $this->_tpl_vars['CUSTOMLINK']->linklabel); ?>
																												<?php if (! preg_match ( "/^block:\/\/.*/" , $this->_tpl_vars['customlink_href'] )): ?>
															<?php if ($this->_tpl_vars['customlink_label'] == ''): ?>
																<?php $this->assign('customlink_label', $this->_tpl_vars['customlink_href']); ?>
															<?php else: ?>
																																<?php $this->assign('customlink_label', getTranslatedString($this->_tpl_vars['customlink_label'], $this->_tpl_vars['CUSTOMLINK']->module())); ?>
															<?php endif; ?>
															<br/>
															<table border=0 cellspacing=0 cellpadding=0 width=100% class="rightMailMerge">
																<tr>
																	<td class="rightMailMergeHeader">
																		<b><?php echo $this->_tpl_vars['customlink_label']; ?>
</b>
																		<img id="detailview_block_<?php echo $this->_tpl_vars['CUSTOMLINK_NO']; ?>
_indicator" style="display:none;" src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0" align="absmiddle" />
																	</td>
																</tr>
																<tr style="height:25px">
																	<td class="rightMailMergeContent"><div id="detailview_block_<?php echo $this->_tpl_vars['CUSTOMLINK_NO']; ?>
"></div></td>
																</tr>
																<script type="text/javascript">
																			vtlib_loadDetailViewWidget("<?php echo $this->_tpl_vars['customlink_href']; ?>
", "detailview_block_<?php echo $this->_tpl_vars['CUSTOMLINK_NO']; ?>
", "detailview_block_<?php echo $this->_tpl_vars['CUSTOMLINK_NO']; ?>
_indicator");
																</script>
															</table>
														<?php endif; ?>
													<?php endforeach; endif; unset($_from); ?>
												<?php endif; ?>
											</td>
										</tr>
									</table>

									<!-- PUBLIC CONTENTS STOPS-->
								</td>
							</tr>
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
										<tr>
											<td class="dvtTabCacheBottom" style="width:10px" nowrap>&nbsp;</td>

											<td class="dvtSelectedCellBottom" align=center nowrap><?php echo getTranslatedString($this->_tpl_vars['SINGLE_MOD'], $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
											<td class="dvtTabCacheBottom" style="width:10px">&nbsp;</td>
											
											<?php if ($this->_tpl_vars['REPORT'] == 'true'): ?>
											<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=ReportsPerHomeOwner&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_REPORTSHOMEOWNER']; ?>
</a></td>
											<td class="dvtTabCacheBottom" style="width:10px">&nbsp;</td>
											<?php endif; ?>
											
											<?php if ($this->_tpl_vars['SinglePane_View'] == 'false' && $this->_tpl_vars['IS_REL_LIST'] != false && count($this->_tpl_vars['IS_REL_LIST']) > 0): ?>
								
												<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a></td>
											<?php endif; ?>
											<td class="dvtTabCacheBottom" align="right" style="width:100%">
												&nbsp;
												<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='DetailView'; DetailView.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';DetailView.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';submitFormForAction('DetailView','EditView');" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
												<?php endif; ?>
												<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted' && $this->_tpl_vars['MODULE'] != 'Documents'): ?>
													<!-- input title="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='DetailView'; DetailView.isDuplicate.value='true';DetailView.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; submitFormForAction('DetailView','EditView');" type="submit" name="Duplicate" value="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_LABEL']; ?>
" &nbsp; -->
												<?php endif; ?>
												<?php if ($this->_tpl_vars['DELETE'] == 'permitted'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="DetailView.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; DetailView.return_action.value='index'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> var confirmMsg = '<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
' <?php else: ?> var confirmMsg = '<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
' <?php endif; ?>; submitFormForActionWithConfirmation('DetailView', 'Delete', confirmMsg);" type="button" name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
												<?php endif; ?>

												<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php else: ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
												<?php endif; ?>
												<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdBottom" id="jumpBtnIdBottom" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php endif; ?>
												<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php else: ?>
													<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
												<?php endif; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>


<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
<script language="JavaScript" type="text/javascript" src="modules/Products/Productsslide.js"></script>
<script language="JavaScript" type="text/javascript">Carousel();</script>
<?php endif; ?>

<script>

function getTagCloud()
{
	var obj = $("tagfields");
	if(obj != null && typeof(obj) != undefined) {
		new Ajax.Request(
		    'index.php',
			{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&file=TagCloud&ajxaction=GETTAGCLOUD&recordid=<?php echo $this->_tpl_vars['ID']; ?>
',
			onComplete: function(response) {
                                $("tagfields").innerHTML=response.responseText;
                                $("txtbox_tagfields").value ='';
                        }
			}
		);
	}
}
getTagCloud();
</script>
<!-- added for validation -->
<script language="javascript">
  var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
);
  var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
);
  var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
);
</script>
</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
</tr></table>

<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Campaigns' || $this->_tpl_vars['MODULE'] == 'Vendors' || $this->_tpl_vars['MODULE'] == 'HomeOwner' || $this->_tpl_vars['MODULE'] == 'SalesAgreement' || $this->_tpl_vars['MODULE'] == 'PO'): ?>
	<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;"></div></form>
<?php endif; ?>