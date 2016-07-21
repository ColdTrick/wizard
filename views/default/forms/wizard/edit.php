<?php

$entity = elgg_extract('entity', $vars);

// prepare default values
$title = '';
$starttime = time() + (24 * 60 * 60);
$endtime = 0;
$display_mode = 'full_screen';
$forward_url = '';

if (!empty($entity)) {
	$title = $entity->title;
	$starttime = (int) $entity->starttime;
	$endtime = (int) $entity->endtime;
	$display_mode = $entity->display_mode;
	$forward_url = $entity->forward_url;
	
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
$display_mode = elgg_get_sticky_value('wizard', 'display_mode', $display_mode);
$forward_url = elgg_get_sticky_value('wizard', 'forward_url', $forward_url);

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
	'required' => true,
]);

// end date
echo elgg_view_input('date', [
	'label' => elgg_echo('wizard:edit:end_date'),
	'name' => 'end_date',
	'value' => empty($endtime) ? '' : $end_date,
	'timestamp' => true,
	'help' => elgg_echo('wizard:edit:end_date:description'),
]);

// display mode
echo elgg_view_input('radio', [
	'name' => 'display_mode',
	'label' => elgg_echo('wizard:edit:display_mode'),
	'help' => elgg_echo('wizard:edit:display_mode:help'),
	'options' => [
		elgg_echo('wizard:edit:display_mode:full_screen') => 'full_screen',
		elgg_echo('wizard:edit:display_mode:overlay') => 'overlay',
	],
	'value' => empty($display_mode) ? 'full_screen' : $display_mode,
	'required' => true,
]);

// forward url
echo elgg_view_input('text', [
	'name' => 'forward_url',
	'label' => elgg_echo('wizard:edit:forward_url'),
	'help' => elgg_echo('wizard:edit:forward_url:help'),
	'value' => $forward_url,
]);

// submit
echo '<div class="elgg-foot">';
echo elgg_view('input/submit', ['value' => elgg_echo('save')]);
echo '</div>';
