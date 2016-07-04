<?php

/* @var $entity WizardStep */
$entity = elgg_extract('entity', $vars);
/* @var $container Wizard */
$container = elgg_extract('container', $vars);

if ($container instanceof Wizard) {
	echo elgg_view_input('hidden', [
		'name' => 'container_guid',
		'value' => $container->getGUID(),
	]);
}

if ($entity instanceof WizardStep) {
	echo elgg_view_input('hidden', [
		'name' => 'guid',
		'value' => $entity->getGUID(),
	]);
}

echo elgg_view_input('text', [
	'name' => 'title',
	'label' => elgg_echo('title'),
	'value' => empty($entity) ? '' : $entity->title,
]);

echo elgg_view_input('longtext', [
	'name' => 'description',
	'label' => elgg_echo('wizard:step:edit:description'),
	'help' => elgg_echo('wizard:step:edit:description:help'),
	'value' => empty($entity) ? '' : html_entity_decode($entity->description, ENT_QUOTES, 'UTF-8'),
	'required' => true,
]);

// footer
$footer = elgg_view_input('submit', [
	'value' => elgg_echo('save'),
	'field_class' => 'mbs',
]);
$footer .= elgg_view('wizard/replacement_helper');

echo elgg_format_element('div', ['class' => ['elgg-foot', 'mbn']], $footer);
