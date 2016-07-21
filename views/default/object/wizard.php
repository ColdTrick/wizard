<?php

$entity = elgg_extract('entity', $vars);
if (!($entity instanceof \Wizard)) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', [
		'entity' => $entity,
		'handler' => 'wizard',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if (!$full_view) {
	// (admin) listing
	$icon = '';
	
	$url_options = [
		'text' => $entity->title,
		'href' => $entity->getURL(),
		'is_trusted' => true,
	];
	
	if ($entity->display_mode == 'overlay') {
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		$url_options['class'] = 'elgg-lightbox';
		$url_options['data-colorbox-opts'] = json_encode([
			'width' => '80%',
			'height' => '90%',
		]);
	}
	
	$title = elgg_view('output/url', $url_options);
	
	$subtitle = [];
	$time_line = elgg_echo('wizard:starttime', [date(elgg_echo('friendlytime:date_format'), $entity->starttime)]);
	if (!empty($entity->endtime)) {
		$time_line .= ' - ' . elgg_echo('wizard:endtime', [date(elgg_echo('friendlytime:date_format'), $entity->endtime)]);
	}
	$subtitle[] = $time_line;
	$subtitle[] = elgg_echo('wizard:step_count', [$entity->getSteps(true)]);
	
	$completed_count = elgg_get_entities_from_relationship([
		'type' => 'user',
		'relationshp' => 'done',
		'relationship_guid' => $entity->getGUID(),
		'count' => true,
	]);
	$subtitle[] = elgg_echo('wizard:completed', [$completed_count]);
	
	$params = [
		'entity' => $entity,
		'title' => $title,
		'subtitle' => implode('<br />', $subtitle),
		'metadata' => $entity_menu,
		'tags' => false,
	];
	$params = $params + $vars;
	
	$summary = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $summary);
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
		'tags' => false,
		'body' => $contents,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
}