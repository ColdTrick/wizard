<?php

use ColdTrick\Wizard\EditWizardStep;

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', WizardStep::SUBTYPE);

/* @var $entity WizardStep */
$entity = get_entity($guid);

/* @var $container Wizard */
$container = $entity->getContainerEntity();

$title = elgg_echo('wizard:step:edit:title', [$entity->getDisplayName(), $container->getDisplayName()]);

$form_helper = new EditWizardStep($container, $entity);

$form = elgg_view_form('wizard_step/edit', [], $form_helper());

if (elgg_is_xhr()) {
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, [
	'entity' => $entity,
	'content' => $form,
]);
