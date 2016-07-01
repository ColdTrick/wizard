<?php

elgg_admin_gatekeeper();

$guid = (int) elgg_extract('guid', $vars);
$entity = get_entity($guid);
if (!($entity instanceof \Wizard)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

$title = elgg_echo('wizard:edit:title', [$entity->title]);

$form = elgg_view_form('wizard/edit', [], ['entity' => $entity]);

if (elgg_is_xhr()) {
	echo elgg_view_module('inline', $title, $form);
} else {
	$page_data = elgg_view_layout('content', [
		'title' => $title,
		'content' => $form,
		'filter' => '',
	]);
	
	echo elgg_view_page($title, $page_data);
}
