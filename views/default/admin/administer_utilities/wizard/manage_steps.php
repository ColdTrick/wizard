<?php

elgg_require_js('wizard/admin_edit');

$guid = (int) get_input('guid');
elgg_entity_gatekeeper($guid, 'object', Wizard::SUBTYPE);

elgg_register_menu_item('title', [
	'name' => 'wizards',
	'text' => elgg_echo('admin:administer_utilities:wizard'),
	'href' => 'admin/administer_utilities/wizard',
	'link_class' => 'elgg-button elgg-button-action',
]);

/* @var $entity Wizard */
$entity = get_entity($guid);

// wizard info
$title = elgg_echo('wizard:manage_steps:info:title');

$wizard_info = elgg_view_entity($entity, ['full_view' => false]);
echo elgg_view_module('info', $title, $wizard_info);

// stepts
$add_button = elgg_view('output/url', [
	'icon' => 'plus',
	'text' => elgg_echo('add'),
	'href' => elgg_generate_url('add:object:wizard_step', [
		'container_guid' => $entity->guid
	]),
	'class' => [
		'elgg-lightbox',
		'elgg-button',
		'elgg-button-action',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '650px;',
	]),
]);

$title = elgg_echo('wizard:manage_steps:steps:title');
$steps = elgg_list_entities([
	'type' => 'object',
	'subtype' => WizardStep::SUBTYPE,
	'limit' => false,
	'container_guid' => $entity->guid,
	'sort_by' => [
		'property' => 'order',
		'direction' => 'ASC',
		'signed' => true,
	],
	'list_class' => 'wizard-manage-steps',
	'no_results' => elgg_echo('wizard:no_steps'),
]);

echo elgg_view_module('info', $title, $steps, ['class' => 'mts', 'menu' => $add_button]);
