<?php

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid');

$title = get_input('title');
$description = get_input('description');

if (empty($guid) && empty($container_guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (empty($description)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = false;
if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!$entity instanceof \WizardStep) {
		return elgg_error_response(elgg_echo('wizard:action:error:entity:wizard_step'));
	}
} else {
	$container = get_entity($container_guid);
	if (!$container instanceof \Wizard) {
		return elgg_error_response(elgg_echo('wizard:action:error:entity'));
	}
	
	$entity = new \WizardStep();
	$entity->container_guid = $container->getGUID();
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('wizard:action:wizard_step:edit:error:create'));
	}
}

$entity->title = $title;
$entity->description = $description;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('save:fail'));
}

return elgg_ok_response('', elgg_echo('wizard:action:wizard_step:edit:success'));
