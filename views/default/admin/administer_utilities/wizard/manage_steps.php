<?php

elgg_load_js('lightbox');
elgg_load_css('lightbox');

elgg_require_js('wizard/admin_edit');

$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Wizard::SUBTYPE);

/* @var $entity Wizard */
$entity = get_entity($guid);

// wizard info
$title = elgg_echo('wizard:manage_steps:info:title');

$wizard_info = elgg_view_entity($entity, ['full_view' => false]);
echo elgg_view_module('inline', $title, $wizard_info);

// stepts
echo elgg_format_element('div', ['class' => 'clearfix'], elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => "wizard_step/add/{$entity->getGUID()}",
	'class' => [
		'elgg-lightbox',
		'elgg-button',
		'elgg-button-action',
		'float-alt',
		'mbn',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '650px;',
	]),
]));

$title = elgg_echo('wizard:manage_steps:steps:title');
$steps = elgg_list_entities_from_metadata([
	'type' => 'object',
	'subtype' => WizardStep::SUBTYPE,
	'limit' => false,
	'container_guid' => $entity->getGUID(),
	'order_by_metadata' => [
		'name' => 'order',
		'as' => 'integer',
		'direction' => 'ASC',
	],
	'list_class' => 'wizard-manage-steps',
	'no_results' => elgg_echo('wizard:no_steps'),
]);

echo elgg_view_module('inline', $title, $steps, ['class' => 'mts']);
