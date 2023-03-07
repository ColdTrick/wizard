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
], '{{user_name}}');
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
	'title' => elgg_echo('wizard:replacements:user_fields:eg', [$user->username]),
], '{{user_username}}');
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
	'title' => elgg_echo('wizard:replacements:user_fields:eg', [$user->guid]),
], '{{user_guid}}');

echo elgg_format_element('div', [
	'class' => ['elgg-subtext', 'elgg-grid'],
], implode('', $templates));

// exit link replacement
echo elgg_view('output/longtext', [
	'value' => elgg_echo('wizard:replacements:exit'),
	'class' => 'elgg-subtext',
]);

$templates = [];
$templates[] = elgg_format_element('div', [
	'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
], '{{exit?some_url}}');

echo elgg_format_element('div', [
	'class' => ['elgg-subtext', 'elgg-grid'],
], implode('', $templates));

// profile fields input
$profile_fields = elgg()->fields->get('user', 'user');
if (empty($profile_fields)) {
	return;
}

$templates = [];
foreach ($profile_fields as $field) {
	$metadata_name = elgg_extract('name', $field);
	$templates[] = elgg_format_element('div', [
		'class' => ['elgg-col', 'elgg-col-1of3', 'wizard-replacement-helper'],
		'title' => elgg_extract('#label', $field),
	], "{{profile_{$metadata_name}}}");
}

echo elgg_view('output/longtext', [
	'value' => elgg_echo('wizard:replacements:profile_fields'),
	'class' => 'elgg-subtext',
]);

echo elgg_format_element('div', [
	'class' => ['elgg-subtext', 'elgg-grid'],
], implode('', $templates));
