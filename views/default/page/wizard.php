<?php

$sections = elgg_extract('sections', $vars);

if (empty($sections)) {
	// render content before head so that JavaScript and CSS can be loaded. See #4032
	$sections = [
		'messages' => elgg_view('page/elements/messages', [
			'object' => elgg_extract('sysmessages', $vars),
		]),
		'body' => elgg_view('page/elements/body', $vars),
	];
}

$vars['sections'] = $sections;

$page_vars = elgg_extract('page_attrs', $vars, []);
$page_vars['class'] = elgg_extract_class($page_vars, ['elgg-page-wizard']);

$vars['page_attrs'] = $page_vars;

echo elgg_view('page/default', $vars);
