<?php
/**
 * Remove a wizard_step entity
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!($entity instanceof \WizardStep)) {
	register_error(elgg_echo('wizard:action:error:entity:wizard_step'));
	forward(REFERER);
}

if (!$entity->canEdit()) {
	register_error(elgg_echo('wizard:action:delete:error:can_edit'));
	forward(REFERER);
}

$title = $entity->getDisplayName();
if ($entity->delete()) {
	system_message(elgg_echo('entity:delete:success', [$title]));
} else {
	register_error(elgg_echo('entity:delete:fail', [$title]));
}

forward(REFERER);
