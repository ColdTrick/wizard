<?php

$user = elgg_get_logged_in_user_entity();
$metadata_name = elgg_extract('name', $vars);

$profile_fields = elgg_get_config('profile_fields');
if (empty($profile_fields) || !isset($profile_fields[$metadata_name])) {
	return;
}

$type = elgg_extract($metadata_name, $profile_fields);

$sticky_values = elgg_get_sticky_value('wizard', 'profile');
$value = $user->$metadata_name;
if (!empty($sticky_values)) {
	$value = elgg_extract($metadata_name, $sticky_values, $value);
}

$params = array(
	'name' => "profile[{$metadata_name}]",
	'required' => 'required',
	'value' => $value,
	'required' => true
);
$params = $params + $vars;

$lankey = "profile:{$metadata_name}";
$label = $metadata_name;
if (elgg_echo($lankey) !== $lankey) {
	$label = elgg_echo($lankey);
}

echo "<label>{$label}";
echo elgg_view("input/{$type}", $params);
echo '</label>';
