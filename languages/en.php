<?php

$english = array(
	
	'wizard:menu:admin' => "Wizards",
	'admin:administer_utilities:wizard' => "Manage wizards",
	'admin:administer_utilities:wizard:add' => "Create wizard",
	'admin:administer_utilities:wizard:edit' => "Edit wizard",
	'wizards:admin:list' => "Wizard listing",
	
	'wizard:starttime' => "Starttime: %s",
	'wizard:endtime' => "Endtime: %s",
	'wizard:step_count' => "Number of steps: %s",
	'wizard:completed' => "# user completed: %s",
	'wizard:finish' => "Finish",
	
	'wizard:add:title' => "Create a new wizard",
	'wizard:edit:title' => "Edit wizard: %s",
	
	'wizard:no_steps' => "This wizard has no steps",
	
	// edit
	'wizard:edit:start_date' => "Start date",
	'wizard:edit:end_date' => "End date",
	'wizard:edit:steps' => "Steps",
	
	// actions
	'wizard:action:error:entity' => "Wizard not found, please check your input",
	
	'wizard:action:edit:error:title' => "Please provide a title",
	'wizard:action:edit:error:starttime' => "The starttime can't be before now",
	'wizard:action:edit:error:endtime' => "The endtime can't be before the start time",
	'wizard:action:edit:error:create' => "Something went wrong while creating a new wizard, please try again",
	'wizard:action:edit:success' => "Wizard saved",
	
	'wizard:action:delete:error:can_edit' => "You're not allowed to do this",
	'' => "",
);

add_translation('en', $english);