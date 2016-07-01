<?php

/* @var $entity WizardStep */
$entity = elgg_extract('entity', $vars);
$full_view = (bool) elgg_extract('full_view', $vars);

$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', [
		'entity' => $entity,
		'handler' => 'wizard_step',
		'class' => 'elgg-menu-hz',
		'sort_by' => 'priority',
	]);
}

if ($full_view) {
	// something
} else {
	
	$params = [
		'title' => $entity->getDisplayName(),
		'content' => $entity->description,
		'metadata' => $entity_menu,
	];
	$params = $params + $vars;
	
	$list_content = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block('', $list_content);
}
