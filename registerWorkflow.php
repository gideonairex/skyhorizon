<?php
require_once 'include/utils/utils.php';
require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
$emm = new VTEntityMethodManager($adb); 

//$emm->addEntityMethod("Module Name","Label", "Path to file" , "Method Name" );
//$emm->addEntityMethod("WorkPlan", "generateCalls", "include/custom_workflows/WorkPlan.php", "GenerateCalls");
//$emm->addEntityMethod("Priorities", "setPriorityPeriod", "include/custom_workflows/Priorities.php", "SetPriorityPeriod");
//$emm->addEntityMethod("Priorities", "addRelatedAccounts", "include/custom_workflows/Priorities.php", "AddRelatedAccounts");
//$emm->addEntityMethod("Calls", "updateCallStatus", "include/custom_workflows/Calls.php", "UpdateCallStatus");
//$emm->addEntityMethod("SurveyForms", "generateTable", "include/custom_workflows/SurveyForm.php", "generateTable");
//$emm->addEntityMethod("FormFields", "alterFormField", "include/custom_workflows/FormFields.php", "alterFormField");
//$emm->addEntityMethod("SurveyForms", "addRelatedAccounts", "include/custom_workflows/SurveyForms.php", "AddRelatedAccounts");
//$emm->addEntityMethod("Notifications", "autoRelateCDSNotif", "include/custom_workflows/Notifications.php", "AutoRelateCDSNotif");
//$emm->addEntityMethod("Payments", "updateBill", "include/custom_workflows/Payments.php", "updateBill");
//$emm->addEntityMethod("House", "updateHouseInfo", "include/custom_workflows/House.php", "updateHouseInfo");
//$emm->addEntityMethod("Cars", "updateCarsInfo", "include/custom_workflows/Cars.php", "updateCarsInfo");
//$emm->addEntityMethod("ReportsKHA", "createClass", "include/custom_workflows/ReportsKHA.php", "createClass");


//$emm->addEntityMethod("SalesAgreement", "createAR", "include/custom_workflows/SalesAgreement.php", "createAR");
//$emm->addEntityMethod("NonTradeR", "createAR", "include/custom_workflows/NTR.php", "createAR");
//$emm->addEntityMethod("PO", "createAP", "include/custom_workflows/PO.php", "createAP");
//$emm->addEntityMethod("SHExpenses", "createAP", "include/custom_workflows/SHExpenses.php", "createAP");
//$emm->addEntityMethod("AccountsReceivable", "updateStatus", "include/custom_workflows/AccountsReceivable.php", "updateStatus");
//$emm->addEntityMethod("AccountsPayable", "updateStatus", "include/custom_workflows/AccountsPayable.php", "updateStatus");
?>