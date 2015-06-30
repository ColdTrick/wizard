<?php

$entity = elgg_extract('entity', $vars);
if (empty($entity) || !elgg_instanceof($entity, 'object', Wizard::SUBTYPE)) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => 'wizard',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz'
	));
}

if (!$full_view) {
	// (admin) listing
	$icon = '';
	
	$title = elgg_view('output/url', array(
		'text' => $entity->title,
		'href' => $entity->getURL(),
		'is_trusted' => true
	));
	
	$subtitle = array();
	$subtitle[] = elgg_echo('wizard:starttime', array(date(elgg_echo('friendlytime:date_format'), $entity->starttime)));
	if (!empty($entity->endtime)) {
		$subtitle[] = elgg_echo('wizard:endtime', array(date(elgg_echo('friendlytime:date_format'), $entity->endtime)));
	}
	$subtitle[] = elgg_echo('wizard:step_count', array($entity->getSteps(true)));
	
	$completed_count = elgg_get_entities_from_relationship(array(
		'type' => 'user',
		'relationshp' => 'done',
		'relationship_guid' => $entity->getGUID(),
		'count' => true
	));
	$subtitle[] = elgg_echo('wizard:completed', array($completed_count));
	
	$params = array(
		'entity' => $entity,
		'title' => $title,
		'subtitle' => implode('<br />', $subtitle),
		'metadata' => $entity_menu,
		'tags' => false
	);
	$params = $params + $vars;
	
	$summary = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $summary);
} else {
	// full view
	$contents = '';
	$steps = $entity->getSteps();
	
	$form_vars = array(
		'class' => 'elgg-form-alt'
	);
	$body_vars = array(
		'entity' => $entity,
		'steps' => $steps
	);
	$contents .= elgg_view_form('wizard/steps', $form_vars, $body_vars);
	
	$params = array(
		'entity' => $entity,
		'tags' => false,
		'body' => $contents
	);
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
}