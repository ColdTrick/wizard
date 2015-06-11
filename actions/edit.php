<?php
/**
 * Create/edit a wizard
 */

elgg_make_sticky_form('wizard');

$guid = (int) get_input('guid');
$title = get_input('title');
$start_date = (int) get_input('start_date');
$end_date = (int) get_input('end_date');

$steps = (array) get_input('steps');

$starttime = mktime(0, 0, 0, gmdate('n', $start_date), gmdate('j', $start_date), gmdate('Y', $start_date));
$endtime = 0;
if (!empty($end_date)) {
	$endtime = mktime(0, 0, 0, gmdate('n', $end_date), gmdate('j', $end_date), gmdate('Y', $end_date));
}

if (empty($title)) {
	register_error(elgg_echo('wizard:action:edit:error:title'));
	forward(REFERER);
}

if (empty($guid) && ($starttime < time())) {
	register_error(elgg_echo('wizard:action:edit:error:starttime'));
	forward(REFERER);
}

if (!empty($endtime) && ($endtime < $starttime)) {
	register_error(elgg_echo('wizard:action:edit:error:endtime'));
	forward(REFERER);
}

$entity = false;
if (!empty($guid)) {
	// edit
	$entity = get_entity($guid);
	if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
		$entity = false;
	}
} else {
	// create
	$entity = new Wizard();
	
	if (!$entity->save()) {
		register_error(elgg_echo('wizard:action:edit:error:create'));
		forward(REFERER);
	}
}

if (empty($entity)) {
	register_error(elgg_echo('wizard:action:error:entity'));
	forward(REFERER);
}

$entity->title = $title;
$entity->friendly_title = elgg_get_friendly_title($title);
$entity->starttime = $starttime;
$entity->endtime = $endtime;

// save steps
foreach ($steps as $index => $step) {
	if (empty($step)) {
		unset($steps[$index]);
	}
}
$entity->saveSteps($steps);

$entity->save();

elgg_clear_sticky_form('wizard');

system_message(elgg_echo('wizard:action:edit:success'));
forward('admin/administer_utilities/wizard');
