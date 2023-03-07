<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \Wizard::SUBTYPE, true);

/* @var $entity \Wizard */
$entity = get_entity($guid);

$title = elgg_echo('wizard:edit:title', [$entity->getDisplayName()]);

$form = elgg_view_form('wizard/edit', ['sticky_enabled' => true], ['entity' => $entity]);

if (elgg_is_xhr()) {
	// ajax loaded
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, ['content' => $form]);
