<?php

$wizard_guid = (int) get_input('wizard_guid');
$user_guid = (int) get_input('user_guid');
$forward_url = urldecode((string) get_input('forward_url', ''));

$profile = get_input('profile');

if (empty($wizard_guid) || empty($user_guid)) {
	return elgg_error_response(elgg_echo('wizard:action:steps:error:input'));
}

$user = get_user($user_guid);
$entity = get_entity($wizard_guid);
if (empty($user) || !$entity instanceof \Wizard) {
	return elgg_error_response(elgg_echo('wizard:action:steps:error:input'));
}

// check profile fields
if (!empty($profile)) {
	$profile_fields = elgg()->fields->get('user', 'user');
	foreach ($profile_fields as $field) {
		$name = elgg_extract('name', $field);
		if (!isset($profile[$name])) {
			continue;
		}
		
		$new_value = $profile[$name];
		if (elgg_is_empty($new_value)) {
			return elgg_error_response(elgg_echo('wizard:action:steps:error:profile_field', [elgg_extract('#label', $field)]));
		}
		
		$user->setProfileData($name, $new_value);
	}
}

elgg_trigger_event('steps', 'wizard', $entity);

// user did this wizard
$entity->addRelationship($user->guid, 'done');

// cleanup session
elgg_get_session()->remove('wizards');

if (empty($forward_url) && !empty($entity->forward_url)) {
	$forward_url = elgg_normalize_url($entity->forward_url);
}

return elgg_redirect_response($forward_url, ELGG_HTTP_FOUND, false);
