<?php

$entity = elgg_extract('entity', $vars);
if ($entity instanceof \WizardStep) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => elgg_extract('container_guid', $vars),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('wizard:step:edit:description'),
	'#help' => elgg_echo('wizard:step:edit:description:help'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
	'required' => true,
]);

// footer
$fields = [];
$fields[] = [
	'#type' => 'submit',
	'#class' => 'elgg-field-stretch',
	'text' => elgg_echo('save'),
];

$replacements = elgg_view('wizard/replacement_helper');
if ($replacements) {
	elgg_import_esm('elgg/toggle');
	
	$fields[] = [
		'#type' => 'button',
		'icon' => 'eye',
		'text' => elgg_echo('wizard:replacements:toggle'),
		'data-toggle-selector' => '#replacements',
		'class' => 'elgg-toggle',
	];
}

$footer = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => $fields,
]);

if ($replacements) {
	$footer .= elgg_format_element('div', ['id' => 'replacements', 'class' => 'hidden'], $replacements);
}

elgg_set_form_footer($footer);
