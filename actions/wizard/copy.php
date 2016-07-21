<?php

$guid = (int) get_input('guid');

elgg_entity_gatekeeper($guid, 'object', \Wizard::SUBTYPE);

$entity = get_entity($guid);

$new_entity = clone $entity;
$new_entity->save();

foreach ($entity->getSteps() as $step) {
	$new_step = clone $step;
	$new_step->container_guid = $new_entity->guid;
	
	$new_step->save();
}

forward('admin/administer_utilities/wizard');
