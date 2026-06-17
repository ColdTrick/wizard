<?php

$guid = elgg_extract('guid', $vars);

/* @var $entity \Wizard */
$entity = elgg_entity_gatekeeper($guid, 'object', \Wizard::SUBTYPE);

echo elgg_view_layout('default', [
	'title' => $entity->getDisplayName(),
	'content' => elgg_view_entity($entity, ['full_view' => true]),
]);
