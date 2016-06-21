<?php

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!($entity instanceof \Wizard)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

$title = elgg_echo('wizard:edit:title', [$entity->title]);

$form = elgg_view_form('wizard/edit', ['action' => 'action/wizard/edit'], ['entity' => $entity]);

echo elgg_view_module('inline', $title, $form);
