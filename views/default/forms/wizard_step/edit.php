<?php

/* @var $entity WizardStep */
$entity = elgg_extract('entity', $vars);
/* @var $container Wizard */
$container = elgg_extract('container', $vars);

if ($container instanceof Wizard) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'container_guid',
		'value' => $container->getGUID(),
	]);
}

if ($entity instanceof WizardStep) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->getGUID(),
	]);
}

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => empty($entity) ? '' : $entity->title,
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('wizard:step:edit:description'),
	'#help' => elgg_echo('wizard:step:edit:description:help'),
	'name' => 'description',
	'value' => empty($entity) ? '' : html_entity_decode($entity->description, ENT_QUOTES, 'UTF-8'),
	'required' => true,
]);

// footer
$replacements = elgg_view('wizard/replacement_helper');

$footer = '';
if ($replacements) {
	$footer .= elgg_view('output/url', [
		'text' => 'Show replacement options',
		'href' => '#replacements',
		'rel' => 'toggle',
		'class' => 'float-alt',
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
