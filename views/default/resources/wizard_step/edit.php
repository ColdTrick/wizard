<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \WizardStep::SUBTYPE, true);

/* @var $entity \WizardStep */
$entity = get_entity($guid);

/* @var $container \Wizard */
$container = $entity->getContainerEntity();

$title = elgg_echo('wizard:step:edit:title', [$entity->getDisplayName(), $container->getDisplayName()]);

$form = elgg_view_form('wizard_step/edit', ['sticky_enabled' => true], ['entity' => $entity]);

if (elgg_is_xhr()) {
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, [
	'entity' => $entity,
	'content' => $form,
]);
