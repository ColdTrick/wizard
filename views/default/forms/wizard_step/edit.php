<?php

/* @var $entity WizardStep */
$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => elgg_extract('container_guid', $vars),
]);

if ($entity instanceof WizardStep) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

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
$replacements = elgg_view('wizard/replacement_helper');

$footer = '';
if ($replacements) {
	$footer .= elgg_view('output/url', [
		'text' => elgg_echo('wizard:replacements:toggle'),
		'href' => '#replacements',
		'class' => ['float-alt', 'elgg-toggle'],
	]);
}

$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

if ($replacements) {
	$footer .= elgg_format_element('div', ['id' => 'replacements', 'class' => 'hidden'], $replacements);
}

elgg_set_form_footer($footer);
