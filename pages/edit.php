<?php

admin_gatekeeper();

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

$title = elgg_echo('wizard:edit:title', array($entity->title));

$form = elgg_view_form('wizard/edit', array(), array('entity' => $entity));

if (elgg_is_xhr()) {
	// lightbox
	echo elgg_view_module('inline', $title, $form, array('class' => 'wizard-lightbox-wrapper'));
} else {
	// full page
	$page_data = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $form,
		'filter' => ''
	));
	
	echo elgg_view_page($title, $page_data);
}