<?php

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
	'value' => elgg_echo('wizard:edit:steps:profile_fields'),
	'class' => 'elgg-subtext',
]);

echo elgg_format_element('div', [
	'class' => 'elgg-subtext',
], implode('', $templates));
