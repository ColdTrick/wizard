<?php

$guid = elgg_extract('guid', $vars);

/* @var $entity Wizard */
$entity = elgg_entity_gatekeeper($guid, 'object', \Wizard::SUBTYPE);

$content = elgg_view_entity($entity, ['full_view' => true]);

echo elgg_view_page($entity->getDisplayName(), ['content' => $content], 'wizard');
