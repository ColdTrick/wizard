<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \WizardStep) {
	return;
}

if (!(bool) elgg_extract('full_view', $vars)) {
	$content = elgg_view('output/longtext', [
		'value' => $entity->description,
	]);
	
	$params = [
		'icon' => elgg_view_icon('arrows-alt'),
		'title' => $entity->getDisplayName(),
		'content' => $content,
		'byline' => false,
		'access' => false,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
