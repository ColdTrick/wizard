<?php

elgg_register_menu_item('title', [
	'name' => 'add',
	'text' => elgg_echo('add'),
	'href' => 'wizard/add',
	'link_class' => [
		'elgg-button',
		'elgg-button-action',
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '550px;',
	]),
]);

$list = elgg_list_entities_from_metadata([
	'type' => 'object',
	'subtype' => Wizard::SUBTYPE,
	'full_view' => false,
	'order_by_metadata' => [
		'name' => 'starttime',
		'as' => 'integer',
		'direction' => 'ASC',
	],
	'no_results' => elgg_echo('notfound'),
]);

$title = elgg_echo('wizards:admin:list');

echo elgg_view_module('inline', $title, $list);