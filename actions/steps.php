<?php

elgg_make_sticky_form('wizard');

$wizard_guid = (int) get_input('wizard_guid');
$user_guid = (int) get_input('user_guid');

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
			$lankey = "profile:{$metadata_name}";
			$label = $metadata_name;
			if (elgg_echo($lankey) !== $lankey) {
				$label = elgg_echo($lankey);
			}
			
			register_error(elgg_echo('wizard:action:steps:error:profile_field', array($label)));
			forward(REFERER);
		}
		
		$type = elgg_extract($metadata_name, $profile_fields);
		if ($type === 'tags') {
			$value = string_to_tag_array($value);
		}
		
		// cleanup existing metadata
		$delete_options = array(
			'guid' => $user->getGUID(),
			'metadata_name' => $metadata_name,
			'limit' => false
		);
		elgg_delete_metadata($delete_options);
		
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
if (empty($_SESSION['wizards'])) {
	$_SESSION['wizards'] = true;
} elseif ($_SESSION['wizards'] !== true) {
	$wizards = $_SESSION['wizards'];
	foreach ($wizards as $index => $guid) {
		if ($guid == $entity->getGUID()) {
			unset($wizards[$index]);
		}
	}
	
	if (empty($wizards)) {
		// no more wizards to follow
		$_SESSION['wizards'] = true;
	} else {
		// you need to do more wizards
		$_SESSION['wizards'] = $wizards;
	}
}

forward();
