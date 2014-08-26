<?php    // Turn on debugging level    $Vtiger_Utils_Log = true;    include_once('vtlib/Vtiger/Menu.php');    include_once('vtlib/Vtiger/Module.php');        // Create module instance and save it first    $module = new Vtiger_Module();    $module->name = 'SHExpenses';	$module->parent ='Tools';    $module->save();    $module->initWebservice();        // Initialize all the tables required    $module->initTables();    /**    * Creates the following table:    * vtiger_payslip (payslipid INTEGER)    * vtiger_payslipcf(payslipid INTEGER PRIMARY KEY)    * vtiger_payslipgrouprel((payslipid INTEGER PRIMARY KEY, groupname VARCHAR(100))    */        // Add the module to the Menu (entry point from UI)    $menu = Vtiger_Menu::getInstance('Tools');    $menu->addModule($module); 
	$block_0_ = new Vtiger_Block();	$block_0_->label = 'General Information';	$module->addBlock($block_0_);
				$field_block_0_field_0 = new Vtiger_Field();				$field_block_0_field_0->label = 'Created Time';				$field_block_0_field_0->name = 'CreatedTime';				$field_block_0_field_0->table = 'vtiger_crmentity';				$field_block_0_field_0->column = 'createdtime';				$field_block_0_field_0->uitype = 70; 				$field_block_0_field_0->typeofdata = 'T~O';				$field_block_0_field_0->displaytype = 2;				$block_0_->addField($field_block_0_field_0); 			
				$field_block_0_field_1 = new Vtiger_Field();				$field_block_0_field_1->label = 'Modified Time';				$field_block_0_field_1->name = 'ModifiedTime';				$field_block_0_field_1->table = 'vtiger_crmentity';				$field_block_0_field_1->column = 'modifiedtime';				$field_block_0_field_1->uitype = 70; 				$field_block_0_field_1->typeofdata = 'T~O';				$field_block_0_field_1->displaytype = 2;				$block_0_->addField($field_block_0_field_1); 			
				$field_block_0_field_2 = new Vtiger_Field();				$field_block_0_field_2->label = 'Assigned To';				$field_block_0_field_2->name = 'assigned_user_id';				$field_block_0_field_2->table = 'vtiger_crmentity';				$field_block_0_field_2->column = 'smownerid';				$field_block_0_field_2->uitype = 53; 				$field_block_0_field_2->typeofdata = 'V~M';				$block_0_->addField($field_block_0_field_2); 			
				$field_block_0_field_3 = new Vtiger_Field();				$field_block_0_field_3->label = 'Expense No';				$field_block_0_field_3->name = 'expense_no';				$field_block_0_field_3->column = 'expense_no';				$field_block_0_field_3->columntype = 'VARCHAR(100)';				$field_block_0_field_3->uitype = 4; 				$field_block_0_field_3->typeofdata = 'V~O';				$block_0_->addField($field_block_0_field_3); 			
				$module->setEntityIdentifier($field_block_0_field_3);				
				$field_block_0_field_4 = new Vtiger_Field();				$field_block_0_field_4->label = 'Expense Name';				$field_block_0_field_4->name = 'expense_name';				$field_block_0_field_4->column = 'expense_name';				$field_block_0_field_4->columntype = 'VARCHAR(100)';				$field_block_0_field_4->uitype = 1; 				$field_block_0_field_4->typeofdata = 'V~O~LE~100';				$block_0_->addField($field_block_0_field_4); 			
				$field_block_0_field_5 = new Vtiger_Field();				$field_block_0_field_5->label = 'Cost';				$field_block_0_field_5->name = 'cost';				$field_block_0_field_5->column = 'cost';				$field_block_0_field_5->columntype = 'DECIMAL(13,2)';				$field_block_0_field_5->uitype = 71; 				$field_block_0_field_5->typeofdata = 'N~O~10,2';				$block_0_->addField($field_block_0_field_5); 			
				$field_block_0_field_6 = new Vtiger_Field();				$field_block_0_field_6->label = 'Status';				$field_block_0_field_6->name = 'expense_status';				$field_block_0_field_6->column = 'expense_status';				$field_block_0_field_6->columntype = 'VARCHAR(255)';				$field_block_0_field_6->uitype = 15; 				$field_block_0_field_6->typeofdata = 'V~O';				$block_0_->addField($field_block_0_field_6); 				$field_block_0_field_6->setPicklistValues(Array('Pending','Paid'));				$filter1 = new Vtiger_Filter();    $filter1->name = 'All';    $filter1->isdefault = true;    $module->addFilter($filter1);    // Add fields to the filter created    $filter1->addField($field_block_0_field_0)->addField($field_block_0_field_1)->addField($field_block_0_field_2)->addField($field_block_0_field_3)->addField($field_block_0_field_4)->addField($field_block_0_field_5)->addField($field_block_0_field_6);        /** Associate other modules to this module */    //$module->setRelatedList(Vtiger_Module::getInstance('Leads'), 'Leads', Array('SELECT'));        /** Set sharing access of this module */    //$module->setDefaultSharing('Private');        /** Enable and Disable available tools */    $module->enableTools(Array('Import', 'Export'));    $module->disableTools('Merge');?>