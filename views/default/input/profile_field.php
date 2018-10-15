<?php

$user = elgg_get_logged_in_user_entity();
$metadata_name = elgg_extract('name', $vars);

$profile_fields = elgg_get_config('profile_fields');
if (empty($profile_fields) || !isset($profile_fields[$metadata_name])) {
	return;
}

$type = elgg_extract($metadata_name, $profile_fields);

$sticky_values = elgg_get_sticky_value('wizard', 'profile');
$annotations = $user->getAnnotations([
	'annotation_name' => $metadata_name,
	'limit' => false,
]);
$value = null;
if (!empty($annotations)) {
	$value = [];
	/* @var $annotation ElggAnnotation */
	foreach ($annotations as $annotation) {
		$value[] = $annotation->value;
	}
	
	if (count($value) === 1) {
		$value = $value[0];
	}
}

if (!empty($sticky_values)) {
	$value = elgg_extract($metadata_name, $sticky_values, $value);
}

$label = $metadata_name;
if (elgg_language_key_exists("profile:{$metadata_name}")) {
	$label = elgg_echo("profile:{$metadata_name}");
}

$params = [
	'#type' => $type,
	'#label' => $label,
	'name' => "profile[{$metadata_name}]",
	'value' => $value,
	'required' => true,
];
$params = $params + $vars;

echo elgg_view_field($params);
