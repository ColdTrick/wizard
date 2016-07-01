<?php

elgg_require_js('wizard/admin_edit');

$entity = elgg_extract('entity', $vars);

// prepare default values
$title = '';
$starttime = time() + (24 * 60 * 60);
$endtime = 0;
$steps = false;

if (!empty($entity)) {
	$title = $entity->title;
	$starttime = (int) $entity->starttime;
	$endtime = (int) $entity->endtime;
	
	$steps = $entity->getSteps();
	
	echo elgg_view('input/hidden', [
		'name' => 'guid',
		'value' => $entity->getGUID(),
	]);
}

// make default start times based on timestamp
$start_date = (int) gmmktime(0, 0, 0, date('n', $starttime), date('j', $starttime), date('Y', $starttime));

// make default end times based on timestamp
$end_date = (int) gmmktime(0, 0, 0, date('n', $endtime), date('j', $endtime), date('Y', $endtime));

// get sticky form values
$title = elgg_get_sticky_value('wizard', 'title', $title);
$start_date = (int) elgg_get_sticky_value('wizard', 'start_date', $start_date);
$end_date = (int) elgg_get_sticky_value('wizard', 'end_date', $end_date);

// clear sticky form
elgg_clear_sticky_form('wizard');

// define some options
$hour_options = range(0, 23);
$min_options = range(0, 59);

// make form
echo elgg_view_input('text', [
	'label' => elgg_echo('title'),
	'name' => 'title',
	'value' => $title,
	'required' => true,
]);

// start date
echo elgg_view_input('date', [
	'label' => elgg_echo('wizard:edit:start_date'),
	'name' => 'start_date',
	'value' => $start_date,
	'timestamp' => true,
]);

// end date
echo elgg_view_input('date', [
	'label' => elgg_echo('wizard:edit:end_date'),
	'name' => 'end_date',
	'value' => empty($endtime) ? '' : $end_date,
	'timestamp' => true,
	'help' => elgg_echo('wizard:edit:end_date:description'),
]);

// steps
$steps_content = '';
if (!empty($steps)) {
	
	foreach ($steps as $step) {
		if (empty($step)) {
			continue;
		}

		$steps_content .= elgg_view_input('longtext', [
			'name' => 'steps[]',
			'value' => $step,
		]);
	}
}

$steps_content .= elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => '#',
	'id' => 'wizard-add-step',
	'class' => 'float-alt elgg-button elgg-button-action mtm',
]);

$steps_content .= '<div class="wizard-edit-step-template hidden">';
$steps_content .= elgg_view('input/plaintext', ['name' => 'steps[]']);
$steps_content .= '</div>';

echo elgg_view_module('inline', elgg_echo('wizard:edit:steps'), $steps_content, ['class' => 'wizard-edit-steps mbn']);

// submit
echo '<div class="elgg-foot">';
echo elgg_view('input/submit', ['value' => elgg_echo('save')]);
echo '</div>';

$profile_fields = elgg_get_config('profile_fields');
if (!empty($profile_fields)) {
	$templates = [];
	foreach ($profile_fields as $metadata_name => $type) {
		$templates[] = "{{profile_{$metadata_name}}}";
	}

	echo elgg_view('output/longtext', [
		'value' => elgg_echo('wizard:edit:steps:profile_fields'),
		'class' => 'elgg-subtext',
	]);
	
	echo elgg_format_element('div', [
		'class' => 'elgg-subtext',
	], implode('<br /> ', $templates));
}
