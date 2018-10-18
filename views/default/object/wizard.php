<?php

use Elgg\Values;

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Wizard) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

if (!$full_view) {
	// (admin) listing
	
	$url_options = [
		'text' => $entity->getDisplayName(),
		'href' => $entity->getURL(),
		'is_trusted' => true,
	];
	
	if ($entity->display_mode == 'overlay') {
		
		$url_options['class'] = 'elgg-lightbox';
		$url_options['data-colorbox-opts'] = json_encode([
			'width' => '80%',
			'height' => '90%',
			'maxWidth' => '990px',
			'iframe' => true,
			'trapFocus' => false,
		]);
	}
	
	$title = elgg_view('output/url', $url_options);
	
	// imprint
	$imprint = [];
	
	// starttime
	$start = Values::normalizeTime($entity->starttime);
	$imprint[] = [
		'icon_name' => 'calendar-alt',
		'content' => elgg_echo('wizard:starttime', [$start->format('j F Y')])
	];
	
	// endtime
	if (!empty($entity->endtime)) {
		$end = Values::normalizeTime($entity->endtime);
		$imprint[] = [
			'icon_name' => 'calendar-alt',
			'content' => elgg_echo('wizard:endtime', [$end->format('j F Y')])
		];
	}
	
	// steps
	$imprint[] = [
		'icon_name' => 'shoe-prints',
		'content' => elgg_echo('wizard:step_count', [$entity->getSteps(true)]),
	];
	
	// users who finished
	$completed_count = elgg_get_entities([
		'type' => 'user',
		'relationship' => 'done',
		'relationship_guid' => $entity->guid,
		'count' => true,
	]);
	$imprint[] = [
		'icon_name' => 'users',
		'content' => elgg_echo('wizard:completed', [$completed_count]),
	];
	
	$params = [
		'entity' => $entity,
		'title' => $title,
		'imprint' => $imprint,
		'tags' => false,
		'show_social_menu' => false,
		'byline' => false,
		'time' => false,
		'access' => false,
		'icon' => false,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/summary', $params);
} else {
	// full view
	$contents = '';
	$steps = $entity->getSteps();
	
	$form_vars = [
		'class' => 'elgg-form-alt',
	];
	$body_vars = [
		'entity' => $entity,
		'steps' => $steps,
	];
	$contents .= elgg_view_form('wizard/steps', $form_vars, $body_vars);
	
	$params = [
		'entity' => $entity,
		'body' => $contents,
		'tags' => false,
		'show_responses' => false,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
}
