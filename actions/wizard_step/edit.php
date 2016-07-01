<?php

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid');

$title = get_input('title');
$description = get_input('description');

if (empty($guid) && empty($container_guid)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

if (empty($description)) {
	register_error(elgg_echo('error:missing_data'));
	forward(REFERER);
}

$entity = false;
if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!($entity instanceof WizardStep)) {
		register_error(elgg_echo('wizard:action:error:entity:wizard_step'));
		forward(REFERER);
	}
} else {
	$container = get_entity($container_guid);
	if (!($container instanceof Wizard)) {
		register_error(elgg_echo('wizard:action:error:entity'));
		forward(REFERER);
	}
	
	$entity = new WizardStep();
	$entity->container_guid = $container->getGUID();
	
	if (!$entity->save()) {
		register_error(elgg_echo('wizard:action:wizard_step:edit:error:create'));
		forward(REFERER);
	}
}

$entity->title = $title;
$entity->description = $description;

if ($entity->save()) {
	system_message(elgg_echo('wizard:action:wizard_step:edit:success'));
} else {
	register_error(elgg_echo('save:fail'));
}

forward(REFERER);
