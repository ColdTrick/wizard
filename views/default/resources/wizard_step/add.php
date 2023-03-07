<?php

$container_guid = (int) elgg_extract('container_guid', $vars);
elgg_entity_gatekeeper($container_guid, 'object', \Wizard::SUBTYPE);

/* @var $container \Wizard */
$container = get_entity($container_guid);

$title = elgg_echo('wizard:step:add:title', [$container->getDisplayName()]);

$form = elgg_view_form('wizard_step/edit', ['sticky_enabled' => true], ['container' => $container]);

if (elgg_is_xhr()) {
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, ['content' => $form]);
