<?php

elgg_admin_gatekeeper();

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', WizardStep::SUBTYPE);

/* @var $entity WizardStep */
$entity = get_entity($guid);

/* @var $container Wizard */
$container = $entity->getContainerEntity();

$title = elgg_echo('wizard:step:edit:title', [$entity->getDisplayName(), $container->title]);

$form = elgg_view_form('wizard_step/edit', [], [
	'entity' => $entity,
]);

if (elgg_is_xhr()) {
	echo elgg_view_module('inline', $title, $form);
} else {
	$page_data = elgg_view_layout('content', [
		'title' => $title,
		'content' => $form,
		'filter' => '',
	]);
	
	echo elgg_view_page($title, $page_data);
}
