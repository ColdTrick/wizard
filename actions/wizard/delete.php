<?php
/**
 * Remove a wizard entity
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

$title = $entity->title;
if ($entity->delete()) {
	system_message(elgg_echo('entity:delete:success', [$title]));
	forward('admin/administer_utilities/wizard');
} else {
	register_error(elgg_echo('entity:delete:fail', [$title]));
	forward(REFERER);
}
