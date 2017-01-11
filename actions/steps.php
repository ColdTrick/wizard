<?php

elgg_make_sticky_form('wizard');

$wizard_guid = (int) get_input('wizard_guid');
$user_guid = (int) get_input('user_guid');
$foward_url = urldecode(get_input('forward_url'));

$profile = get_input('profile');

if (empty($wizard_guid) || empty($user_guid)) {
	register_error(elgg_echo('wizard:action:steps:error:input'));
	forward(REFERER);
}

$user = get_user($user_guid);
$entity = get_entity($wizard_guid);

if (empty($user) || empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	register_error(elgg_echo('wizard:action:steps:error:input'));
	forward(REFERER);
}

// check profile fields
if (!empty($profile)) {
	$profile_fields = elgg_get_config('profile_fields');
	
	foreach ($profile as $metadata_name => $value) {
		
		if (empty($profile_fields) || !isset($profile_fields[$metadata_name])) {
			continue;
		}
		
		if (empty($value)) {
			$label = $metadata_name;
			if (elgg_language_key_exists("profile:{$metadata_name}")) {
				$label = elgg_echo("profile:{$metadata_name}");
			}
			
			register_error(elgg_echo('wizard:action:steps:error:profile_field', [$label]));
			forward(REFERER);
		}
		
		$type = elgg_extract($metadata_name, $profile_fields);
		if ($type === 'tags') {
			$value = string_to_tag_array($value);
		}
		
		// cleanup existing metadata
		elgg_delete_metadata([
			'guid' => $user->getGUID(),
			'metadata_name' => $metadata_name,
			'limit' => false,
		]);
		
		// save profile field
		if (!is_array($value)) {
			create_metadata($user->getGUID(), $metadata_name, $value, '', $user->getGUID(), ACCESS_LOGGED_IN);
		} else {
			// correctly save tag/array values
			foreach ($value as $v) {
				create_metadata($user->getGUID(), $metadata_name, $v, '', $user->getGUID(), ACCESS_LOGGED_IN, true);
			}
		}
	}
}

elgg_clear_sticky_form('wizard');

// user did this wizard
$entity->addRelationship($user->getGUID(), 'done');

// cleanup session
elgg_get_session()->remove('wizards');

if (empty($foward_url) && !empty($entity->forward_url)) {
	$foward_url = elgg_normalize_url($entity->forward_url);
}
forward($foward_url);
