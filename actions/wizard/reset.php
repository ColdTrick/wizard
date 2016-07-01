<?php
/**
 * Reset all users to re-do this wizard
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!($entity instanceof \Wizard)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

if (!$entity->canEdit()) {
	register_error(elgg_echo('wizard:action:delete:error:can_edit'));
	forward(REFERER);
}

remove_entity_relationships($entity->getGUID(), 'done');
system_message(elgg_echo('wizard:action:reset', [$entity->title]));

forward(REFERER);