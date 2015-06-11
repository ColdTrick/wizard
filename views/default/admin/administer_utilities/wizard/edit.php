<?php

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

$title = elgg_echo('wizard:edit:title', array($entity->title));

$form = elgg_view_form('wizard/edit', array('action' => 'action/wizard/edit'), array('entity' => $entity));

echo elgg_view_module('inline', $title, $form);
