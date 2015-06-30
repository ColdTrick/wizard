<?php
/**
 * Reset all users to re-do this wizard
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

remove_entity_relationships($entity->getGUID(), 'done');
system_message(elgg_echo('wizard:action:reset', array($entity->title)));

forward(REFERER);