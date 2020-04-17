<?php

$entity = elgg_extract('entity', $vars);
if ($entity instanceof Wizard) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

// make form
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'required' => true,
]);

// trigger mode
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('wizard:edit:show_users'),
	'fields' => [
		[
			'#type' => 'checkbox',
			'#label' => elgg_echo('wizard:edit:show_users:new_users'),
			'name' => 'show_users',
			'default' => 'everybody',
			'value' => 'new_users',
			'checked' => elgg_extract('show_users', $vars) === 'new_users',
			'switch' => true,
		],
	],
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('wizard:edit:user_can_close'),
	'#help' => elgg_echo('wizard:edit:user_can_close:description'),
	'name' => 'user_can_close',
	'value' => 1,
	'checked' => !empty(elgg_extract('user_can_close', $vars)),
	'switch' => true,
]);

// start date
echo elgg_view_field([
	'#type' => 'fieldset',
	'legend' => elgg_echo('wizard:edit:time_restrictions'),
	'fields' => [
		[
			'#type' => 'date',
			'#label' => elgg_echo('wizard:edit:start_date'),
			'#help' => elgg_echo('wizard:edit:start_date:description'),
			'name' => 'starttime',
			'value' => elgg_extract('starttime', $vars),
			'timestamp' => true,
			'required' => true,
		],
		[
			'#type' => 'date',
			'#label' => elgg_echo('wizard:edit:end_date'),
			'#help' => elgg_echo('wizard:edit:end_date:description'),
			'name' => 'endtime',
			'value' => elgg_extract('endtime', $vars),
			'timestamp' => true,
		],
	],
]);

// display mode
echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('wizard:edit:display_mode'),
	'#help' => elgg_echo('wizard:edit:display_mode:help'),
	'name' => 'display_mode',
	'options' => [
		elgg_echo('wizard:edit:display_mode:full_screen') => 'full_screen',
		elgg_echo('wizard:edit:display_mode:overlay') => 'overlay',
	],
	'value' => elgg_extract('display_mode', $vars),
	'required' => true,
]);

// forward url
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('wizard:edit:forward_url'),
	'#help' => elgg_echo('wizard:edit:forward_url:help'),
	'name' => 'forward_url',
	'value' => elgg_extract('forward_url', $vars),
]);

// submit
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
