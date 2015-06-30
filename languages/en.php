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
	'wizard:edit:end_date:description' => "To clear the end date, click on the field and use Ctrl+End on your keyboard.",
	'wizard:edit:steps' => "Steps",
	'wizard:edit:steps:profile_fields' => "You can integrate an input field to require a certain profile field during the wizard.
You can use the following profile field templates:

%s",
	'wizard:reset:confirm' => "Are you sure you wish to reset all users? This will force all users to re-do this wizard.",
	
	// actions
	'wizard:action:error:entity' => "Wizard not found, please check your input",
	
	'wizard:action:edit:error:title' => "Please provide a title",
	'wizard:action:edit:error:starttime' => "The starttime can't be before now",
	'wizard:action:edit:error:endtime' => "The endtime can't be before the start time",
	'wizard:action:edit:error:create' => "Something went wrong while creating a new wizard, please try again",
	'wizard:action:edit:success' => "Wizard saved",
	
	'wizard:action:delete:error:can_edit' => "You're not allowed to do this",
	
	'wizard:action:steps:error:input' => "Wizard not found, please check your input",
	'wizard:action:steps:error:profile_field' => "No value submitted for %s",
	
	'wizard:action:reset' => "All users have been reset for the wizard: %s",
);

add_translation('en', $english);