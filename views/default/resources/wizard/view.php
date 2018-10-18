<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', Wizard::SUBTYPE);

/* @var $entity Wizard */
$entity = get_entity($guid);

// build page elements
$title = $entity->getDisplayName();

$content = elgg_view_entity($entity, ['full_view' => true]);

// build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title,
	'content' => $content,
]);

// draw page
if (elgg_is_xhr()) {
	echo $page_data;
	return;
}

echo elgg_view_page($title, $page_data, 'wizard');
