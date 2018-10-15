<?php
/**
 * Create/edit a wizard
 */

elgg_make_sticky_form('wizard');

$guid = (int) get_input('guid');
$title = get_input('title');
$start_date = (int) get_input('start_date');
$end_date = (int) get_input('end_date');
$display_mode = get_input('display_mode', 'full_screen');
$show_users = get_input('show_users', 'everybody');
$user_can_close = get_input('user_can_close', 0);
$forward_url = get_input('forward_url');

$starttime = mktime(0, 0, 0, gmdate('n', $start_date), gmdate('j', $start_date), gmdate('Y', $start_date));
$endtime = 0;
if (!empty($end_date)) {
	$endtime = mktime(0, 0, 0, gmdate('n', $end_date), gmdate('j', $end_date), gmdate('Y', $end_date));
}

if (empty($title)) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:title'));
}

if (empty($guid) && ($starttime < time())) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:starttime'));
}

if (!empty($endtime) && ($endtime < $starttime)) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:endtime'));
}

$entity = false;
if (!empty($guid)) {
	// edit
	$entity = get_entity($guid);
	if (!$entity instanceof \Wizard) {
		$entity = false;
	}
} else {
	// create
	$entity = new \Wizard();
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('wizard:action:edit:error:create'));
	}
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('wizard:action:error:entity'));
}

$entity->title = $title;

$entity->friendly_title = elgg_get_friendly_title($title);
$entity->starttime = $starttime;
$entity->endtime = $endtime;
$entity->display_mode = $display_mode;
$entity->show_users = $show_users;
$entity->user_can_close = $user_can_close;
$entity->forward_url = $forward_url;

$entity->save();

elgg_clear_sticky_form('wizard');

return elgg_ok_response('', elgg_echo('wizard:action:edit:success'), 'admin/administer_utilities/wizard');
