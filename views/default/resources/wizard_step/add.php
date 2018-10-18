<?php

use ColdTrick\Wizard\EditWizardStep;

$container_guid = (int) elgg_extract('container_guid', $vars);
elgg_entity_gatekeeper($container_guid, 'object', Wizard::SUBTYPE);

/* @var $container Wizard */
$container = get_entity($container_guid);

$title = elgg_echo('wizard:step:add:title', [$container->getDisplayName()]);

$form_helper = new EditWizardStep($container);

$form = elgg_view_form('wizard_step/edit', [], $form_helper());

if (elgg_is_xhr()) {
	echo elgg_view_module('info', $title, $form);
	return;
}

$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $form,
	'filter' => '',
]);

echo elgg_view_page($title, $page_data);
