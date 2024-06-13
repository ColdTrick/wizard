<?php

$entity = elgg_extract('entity', $vars);
$steps = elgg_extract('steps', $vars);
if (!$entity instanceof \Wizard) {
	return;
}

elgg_import_esm('forms/wizard/steps');

echo elgg_view('input/hidden', [
	'name' => 'wizard_guid',
	'value' => $entity->guid,
]);

echo elgg_view('input/hidden', [
	'name' => 'user_guid',
	'value' => elgg_get_logged_in_user_guid(),
]);

echo elgg_view('input/hidden', [
	'name' => 'forward_url',
	'value' => '',
]);

if (!empty($steps)) {
	$count = count($steps);
	
	foreach ($steps as $index => $step) {
		echo elgg_view('wizard/step', [
			'value' => $step,
			'step' => $index,
			'last' => ($index + 1) === $count,
		]);
	}
} else {
	echo elgg_echo('wizard:no_steps');
}

echo elgg_view('wizard/pagination', $vars);
