<?php
/**
 * Create/edit a wizard
 */

use Elgg\Values;

elgg_make_sticky_form('wizard/edit');

$guid = (int) get_input('guid');
$title = get_input('title');
$starttime = Values::normalizeTime(get_input('starttime'));
$endtime = (int) get_input('endtime');
$display_mode = get_input('display_mode', 'full_screen');
$show_users = get_input('show_users', 'everybody');
$user_can_close = (int) get_input('user_can_close', 0);
$forward_url = get_input('forward_url');

if (empty($title)) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:title'));
}

$starttime->modify('midnight');
$starttime = $starttime->getTimestamp();

if (empty($guid) && ($starttime < time())) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:starttime'));
}

if (!empty($endtime)) {
	$endtime = Values::normalizeTime($endtime);
	
	$endtime->modify('midnight');
	$endtime = $endtime->getTimestamp();
}

if (!empty($endtime) && ($endtime < $starttime)) {
	return elgg_error_response(elgg_echo('wizard:action:edit:error:endtime'));
}

$entity = false;
if (!empty($guid)) {
	// edit
	$entity = get_entity($guid);
	if (!$entity instanceof \Wizard || !$entity->canEdit()) {
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

elgg_clear_sticky_form('wizard/edit');

return elgg_ok_response('', elgg_echo('wizard:action:edit:success'), 'admin/administer_utilities/wizard');
