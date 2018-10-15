<?php

elgg_admin_gatekeeper();

$guid = (int) get_input('guid');
$title = elgg_echo('wizard:add:title');
$body_vars = [];
if ($guid) {
	elgg_entity_gatekeeper($guid, 'object', \Wizard::SUBTYPE);
	$entity = get_entity($guid);
	$body_vars['entity'] = $entity;
	
	$title = elgg_echo('wizard:edit:title', [$entity->getDisplayName()]);
}

$form = elgg_view_form('wizard/edit', [], $body_vars);

echo elgg_view_module('inline', $title, $form);
