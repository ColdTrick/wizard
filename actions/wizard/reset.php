<?php
/**
 * Reset all users to re-do this wizard
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof \Wizard) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!$entity->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$entity->removeAllRelationships('done');

return elgg_ok_response('', elgg_echo('wizard:action:reset', [$entity->getDisplayName()]));
