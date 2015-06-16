<?php

gatekeeper();

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	forward(REFERER);
}

// build page elements
$title = $entity->title;

$content = elgg_view_entity($entity, array('full_view' => true));

// build page
$page_data = elgg_view_layout('one_column', array(
	'title' => $title,
	'content' => $content
));

// draw page
echo elgg_view_page($title, $page_data, 'wizard');