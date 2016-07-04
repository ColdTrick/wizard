<?php

return [
	
	'wizard:menu:admin' => "Wizards",
	'admin:administer_utilities:wizard' => "Manage wizards",
	'admin:administer_utilities:wizard:manage_steps' => "Manage steps",
	'wizards:admin:list' => "Wizard listing",
	
	'admin:upgrades:migrate_wizard_steps' => "Migrate wizard steps",
	'admin:upgrades:migrate_wizard_steps:description' => "The wizard steps need to be saved in a new format.
This upgrade is there to migrate all the wizards.",
	
	'wizard:starttime' => "Starttime: %s",
	'wizard:endtime' => "Endtime: %s",
	'wizard:step_count' => "Number of steps: %s",
	'wizard:completed' => "# user completed: %s",
	'wizard:finish' => "Finish",
	
	'wizard:add:title' => "Create a new wizard",
	'wizard:edit:title' => "Edit wizard: %s",
	
	'wizard:no_steps' => "This wizard has no steps",
	
	'wizard:reset:confirm' => "Are you sure you wish to reset all users? This will force all users to re-do this wizard.",
	
	// edit
	'wizard:edit:start_date' => "Start date",
	'wizard:edit:end_date' => "End date",
	'wizard:edit:end_date:description' => "To clear the end date, click on the field and use Ctrl+End on your keyboard.",
	'wizard:edit:display_mode' => "Display mode",
	'wizard:edit:display_mode:help' => "How should the wizard be presented to the users.",
	'wizard:edit:display_mode:full_screen' => "Full screen",
	'wizard:edit:display_mode:overlay' => "Overlay",
	'wizard:edit:forward_url' => "Finished URL",
	'wizard:edit:forward_url:help' => "When the user finishes the wizard, this will be the URL where they are sent to.",
	
	// replacements
	'wizard:replacements:user_fields' => "You can use the replacements below to display some user information.",
	'wizard:replacements:user_fields:eg' => "eg: %s",
	'wizard:replacements:profile_fields' => "You can integrate an input field to require a certain profile field during the wizard.
You can use the following profile field templates:",
	
	// manage steps
	'wizard:manage_steps:info:title' => "Wizard information",
	'wizard:manage_steps:steps:title' => "Steps",
	
	// edit step
	'wizard:step:add:title' => "Add a step to: %s",
	'wizard:step:edit:title' => "Edit the step '%s' for the wizard: %s",
	'wizard:step:edit:description' => "Step content",
	'wizard:step:edit:description:help' => "This is the text the user will see for this step. Below you can find some replacement placeholders.",
	
	// actions
	'wizard:action:error:entity' => "Wizard not found, please check your input",
	'wizard:action:error:entity:wizard_step' => "WizardStep not found, please check your input",
	
	'wizard:action:edit:error:title' => "Please provide a title",
	'wizard:action:edit:error:starttime' => "The starttime can't be before now",
	'wizard:action:edit:error:endtime' => "The endtime can't be before the start time",
	'wizard:action:edit:error:create' => "Something went wrong while creating a new wizard, please try again",
	'wizard:action:edit:success' => "Wizard saved",
	
	'wizard:action:delete:error:can_edit' => "You're not allowed to do this",
	
	'wizard:action:steps:error:input' => "Wizard not found, please check your input",
	'wizard:action:steps:error:profile_field' => "No value submitted for %s",
	
	'wizard:action:reset' => "All users have been reset for the wizard: %s",
	
	'wizard:action:wizard_step:edit:error:create' => "Something went wrong while creating a new wizard step, please try again",
	'wizard:action:wizard_step:edit:success' => "The wizard step was saved",
];
