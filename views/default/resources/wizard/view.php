<?php

gatekeeper();

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);
if (!($entity instanceof \Wizard)) {
	forward(REFERER);
}

// build page elements
$title = $entity->title;

$content = elgg_view_entity($entity, ['full_view' => true]);

// build page
$page_data = elgg_view_layout('one_column', [
	'title' => $title,
	'content' => $content,
]);

// draw page
if (elgg_is_xhr()) {
	echo $page_data;
} else {
	echo elgg_view_page($title, $page_data, 'wizard');
}
