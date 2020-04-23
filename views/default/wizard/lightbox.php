<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', Wizard::SUBTYPE);

/* @var $entity Wizard */
$entity = get_entity($guid);

echo elgg_view_layout('default', [
	'title' => $entity->getDisplayName(),
	'content' => elgg_view_entity($entity, ['full_view' => true]),
]);
