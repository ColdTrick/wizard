<?php

$user = elgg_get_logged_in_user_entity();
$metadata_name = elgg_extract('name', $vars);

$profile_fields = elgg()->fields->get('user', 'user');
$matched_field = false;
foreach ($profile_fields as $field) {
	if (elgg_extract('name', $field) === $metadata_name) {
		$matched_field = $field;
		break;
	}
}

if (empty($matched_field)) {
	return;
}

$sticky_values = elgg_get_sticky_value('wizard', 'profile');

$value = $user->getProfileData($metadata_name);

if (!empty($sticky_values)) {
	$value = elgg_extract($metadata_name, $sticky_values, $value);
}

$params = [
	'#type' => elgg_extract('#type', $field),
	'#label' => elgg_extract('#label', $field),
	'name' => "profile[{$metadata_name}]",
	'value' => $value,
	'required' => true,
];
$params = $params + $vars;

echo elgg_view_field($params);
