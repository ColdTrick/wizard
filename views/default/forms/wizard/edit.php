<?php

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
	
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $entity->getGUID()));
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
echo '<div>';
echo '<label>' . elgg_echo('title');
echo elgg_view('input/text', array(
	'name' => 'title',
	'value' => $title,
	'required' => true
));
echo '</label>';
echo '</div>';

// start date
echo '<div class="wizard-edit-start-date">';
echo '<label>' . elgg_echo('wizard:edit:start_date') . '<br />';
echo elgg_view('input/date', array(
	'name' => 'start_date',
	'value' => $start_date,
	'timestamp' => true
));
echo '</label>';
echo '</div>';

// end date
echo '<div class="wizard-edit-end-date">';
echo '<label>' . elgg_echo('wizard:edit:end_date') . '<br />';
echo elgg_view('input/date', array(
	'name' => 'end_date',
	'value' => empty($endtime) ? '' : $end_date,
	'timestamp' => true
));
echo '</label>';
echo '<div class="elgg-subtext">' . elgg_echo('wizard:edit:end_date:description') . '</div>';
echo '</div>';

// steps
echo '<div class="wizard-edit-steps">';
echo '<label>' . elgg_echo('wizard:edit:steps') . '</label><br />';

if (!empty($steps)) {
	
	foreach ($steps as $step) {
		if (empty($step)) {
			continue;
		}
		echo '<div>';
		echo elgg_view('input/longtext', array('name' => 'steps[]', 'value' => $step));
		echo '</div>';
	}
}

echo elgg_view('output/url', array(
	'text' => elgg_echo('add'),
	'href' => '#',
	'onclick' => 'return elgg.wizard.add_step();',
	'class' => 'float-alt'
));

echo '<div class="wizard-edit-step-template hidden">';
echo elgg_view('input/plaintext', array('name' => 'steps[]'));
echo '</div>';

// add a unused longtext to initialize the ckeditor
echo '<div class="hidden">' . elgg_view('input/longtext', array('name' => 'unused')) . '</div>';

echo '</div>';

// submit
echo '<div class="elgg-foot">';
echo elgg_view('input/submit', array('value' => elgg_echo('save')));
echo '</div>';

$profile_fields = elgg_get_config('profile_fields');
if (!empty($profile_fields)) {
	$templates = array();
	foreach ($profile_fields as $metadata_name => $type) {
		$templates[] = "{{profile_{$metadata_name}}}";
	}

	echo elgg_view('output/longtext', array(
		'value' => elgg_echo('wizard:edit:steps:profile_fields', array(implode('<br /> ', $templates))),
		'class' => 'elgg-subtext'
	));
}
