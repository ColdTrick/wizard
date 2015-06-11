<?php
/**
 * Remove a wizard entity
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

if (!$entity->canEdit()) {
	register_error(elgg_echo('wizard:action:delete:error:can_edit'));
	forward(REFERER);
}

$title = $entity->title;
if ($entity->delete()) {
	system_message(elgg_echo('entity:delete:success', array($title)));
} else {
	register_error(elgg_echo('entity:delete:fail', array($title)));
}

forward(REFERER);