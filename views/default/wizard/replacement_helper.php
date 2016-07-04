<?php

// user replacements
$user = elgg_get_logged_in_user_entity();
echo elgg_view('output/longtext', [
	'value' => elgg_echo('wizard:replacements:user_fields'),
	'class' => 'elgg-subtext',
]);

$templates = [];
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
	'title' => elgg_echo('wizard:replacements:user_fields:eg', [$user->name]),
], "{{user_name}}");
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
	'title' => elgg_echo('wizard:replacements:user_fields:eg', [$user->username]),
], "{{user_username}}");
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
	'title' => elgg_echo('wizard:replacements:user_fields:eg', [$user->getGUID()]),
], "{{user_guid}}");

echo elgg_format_element('div', [
	'class' => ['elgg-subtext', 'clearfix', 'mbm'],
], implode('', $templates));

// profile fields input
$profile_fields = elgg_get_config('profile_fields');
if (empty($profile_fields)) {
	return;
}

$templates = [];
foreach ($profile_fields as $metadata_name => $type) {
	$title = '';
	if (elgg_language_key_exists("profile:{$metadata_name}")) {
		$title = elgg_echo("profile:{$metadata_name}");
	}
	
	$templates[] = elgg_format_element('div', [
		'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
		'title' => $title,
	], "{{profile_{$metadata_name}}}");
}

echo elgg_view('output/longtext', [
	'value' => elgg_echo('wizard:replacements:profile_fields'),
	'class' => 'elgg-subtext',
]);

echo elgg_format_element('div', [
	'class' => ['elgg-subtext', 'clearfix'],
], implode('', $templates));
