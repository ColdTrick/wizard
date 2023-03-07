<?php

$guid = (int) get_input('guid');
if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof \Wizard) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$new_entity = clone $entity;
$new_entity->save();

foreach ($entity->getSteps() as $step) {
	$new_step = clone $step;
	$new_step->container_guid = $new_entity->guid;
	
	$new_step->save();
}

return elgg_ok_response('', '', 'admin/administer_utilities/wizard');
