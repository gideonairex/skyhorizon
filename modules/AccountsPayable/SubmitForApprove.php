<?php
global $currentModule;
$focus = CRMEntity::getInstance($currentModule);
$record = $_REQUEST['record'];
$focus->mode = 'edit';
$focus->id = $_REQUEST['record'];
$focus->retrieve_entity_info($focus->id, $currentModule);
$focus->column_fields['payable_approval'] = 'Approved';
$focus->column_fields['confirmation'] = random_text('alnum',15);
$focus->save($currentModule);

header("Location: index.php?action=DetailView&module=$currentModule&record=$record");
die();
?>