<?php

elgg_register_menu_item('title', [
	'name' => 'add',
	'icon' => 'add',
	'text' => elgg_echo('add'),
	'href' => 'admin/administer_utilities/wizard/manage',
	'link_class' => [
		'elgg-button',
		'elgg-button-action',
	],
]);

$list = elgg_list_entities([
	'type' => 'object',
	'subtype' => Wizard::SUBTYPE,
	'full_view' => false,
	'order_by_metadata' => [
		'name' => 'starttime',
		'as' => 'integer',
		'direction' => 'ASC',
	],
	'no_results' => true,
]);

$title = elgg_echo('wizards:admin:list');

echo elgg_view_module('inline', $title, $list);
