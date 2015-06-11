<?php

$entity = elgg_extract('entity', $vars);
$steps = elgg_extract('steps', $vars);

if (empty($entity) || empty($steps)) {
	return;
}

echo elgg_view('input/hidden', array(
	'name' => 'wizard_guid',
	'value' => $entity->getGUID()
));
echo elgg_view('input/hidden', array(
	'name' => 'user_guid',
	'value' => elgg_get_logged_in_user_guid(),
));

$count = count($steps);

foreach ($steps as $index => $step) {
	echo elgg_view('wizard/step', array(
		'value' => $step,
		'step' => $index,
		'last' => (($index + 1) === $count) ? true : false
	));
}

elgg_clear_sticky_form('wizard');