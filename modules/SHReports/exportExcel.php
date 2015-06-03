<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$_REQUEST['report_name'].".xls");
header("Pragma: no-cache");
header("Expires: 0");
$_REQUEST['mode'] = 'print';
require('modules/SHReports/Reports/'.$_REQUEST['report_name'].'.php');
require('modules/SHReports/TemplateMaker/'.$_REQUEST['report_name'].'.php');
require('modules/SHReports/Excel/'.$_REQUEST['report_name'].'.php');
die();
?>
