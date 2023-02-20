<?php

return [
	
	'item:object:wizard' => "Wizard",
	'item:object:wizard_step' => "Wizard step",
	
	'entity:delete:object:wizard:success' => "The wizard '%s' was deleted",
	'entity:delete:object:wizard_step:success' => "The wizard step '%s' was deleted",

	'wizard:menu:admin' => "Wizards",
	'admin:administer_utilities:wizard' => "Manage wizards",
	'admin:administer_utilities:wizard:manage_steps' => "Manage steps",
	'admin:administer_utilities:wizard:manage' => "Manage a wizard",
	
	'wizard:starttime' => "Starttime: %s",
	'wizard:endtime' => "Endtime: %s",
	'wizard:step_count' => "Number of steps: %s",
	'wizard:completed' => "Users completed: %s",
	'wizard:finish' => "Finish",
	
	'wizard:add:title' => "Create a new wizard",
	'wizard:edit:title' => "Edit wizard: %s",
	'wizard:copy' => "Copy",
	'wizard:copy:of' => "Copy of: %s",
	
	'wizard:no_steps' => "This wizard has no steps",
	
	'wizard:reset:confirm' => "Are you sure you wish to reset all users? This will force all users to re-do this wizard.",
	
	'wizard:admin:repair_users' => "Remove new user flag",
	'wizard:admin:repair_users:title' => "Some users might see the 'New user' wizards, dispite being a member for a long time. This will fix that issue.",
	
	// edit
	'wizard:edit:time_restrictions' => 'Time restrictions',
	'wizard:edit:start_date' => "Start date",
	'wizard:edit:start_date:description' => "The wizard will be shown after this date",
	'wizard:edit:end_date' => "End date",
	'wizard:edit:end_date:description' => "The wizard will no longer be shown after this date. To clear the end date, click on the field and use Ctrl+End on your keyboard.",
	'wizard:edit:show_users' => "Who to show the wizard",
	'wizard:edit:show_users:new_users' => "Only new users (when they login for the first time)",
	'wizard:edit:show_users:days_after_account_creation' => "Minimum number of days after account creation",
	'wizard:edit:show_users:days_after_account_creation:help' => "The wizard will only show after the given number of days has passed since the user account was created",
	'wizard:edit:show_users:days_after_first_login' => "Minimum number of days after the first login",
	'wizard:edit:show_users:days_after_first_login:help' => "The wizard will only show after the given number of days has passed since the user first logged in",
	'wizard:edit:show_users:days_since_account_creation' => "Maximum number of days since account creation",
	'wizard:edit:show_users:days_since_account_creation:help' => "The wizard will only show if the account was created within the given number of days",
	'wizard:edit:show_users:account_created_after' => "Accounts created after",
	'wizard:edit:show_users:account_created_after:help' => "The wizard will only show if the account was created after the given date",
	'wizard:edit:user_can_close' => "User can close the wizard without finishing it",
	'wizard:edit:user_can_close:description' => "If a user closes a wizard, they will not see it again until a new browser session is started",
	'wizard:edit:display_mode' => "Display mode",
	'wizard:edit:display_mode:help' => "How should the wizard be presented to the users.",
	'wizard:edit:display_mode:full_screen' => "Full screen",
	'wizard:edit:display_mode:overlay' => "Overlay",
	'wizard:edit:forward_url' => "Finished URL",
	'wizard:edit:forward_url:help' => "When the user finishes the wizard, this will be the URL where they are sent to.",
	
	// replacements
	'wizard:replacements:toggle' => "Show replacement options",
	'wizard:replacements:user_fields' => "You can use the replacements below to display some user information.",
	'wizard:replacements:user_fields:eg' => "eg: %s",
	'wizard:replacements:exit' => "You can have an exit URL replacement. Use the placeholder below and replace some_url by the URL where you wish the user to go.",
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
	
	'wizard:action:steps:error:input' => "Wizard not found, please check your input",
	'wizard:action:steps:error:profile_field' => "No value submitted for %s",
	
	'wizard:action:reset' => "All users have been reset for the wizard: %s",
	
	'wizard:action:wizard_step:edit:error:create' => "Something went wrong while creating a new wizard step, please try again",
	'wizard:action:wizard_step:edit:success' => "The wizard step was saved",
	
	'wizard:action:admin:repair_users:success' => "All new user flags have been removed",
];
