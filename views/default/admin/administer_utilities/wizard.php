<?php

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

$title = elgg_view('output/url', [
	'text' => elgg_echo('add'),
	'href' => 'admin/administer_utilities/wizard/add',
	'is_trusted' => true,
	'class' => 'float-alt elgg-button elgg-button-action',
]);
$title .= elgg_echo('wizards:admin:list');

echo elgg_view_module('inline', $title, $list);