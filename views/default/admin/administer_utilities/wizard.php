<?php

$options = array(
	'type' => 'object',
	'subtype' => Wizard::SUBTYPE,
	'full_view' => false,
	'order_by_metadata' => array(
		'name' => 'starttime',
		'as' => 'integer',
		'direction' => 'ASC'
	)
);

$list = elgg_list_entities_from_metadata($options);
if (empty($list)) {
	$list = elgg_echo('notfound');
}

$title = elgg_view('output/url', array(
	'text' => elgg_echo('add'),
	'href' => 'admin/administer_utilities/wizard/add',
	'is_trusted' => true,
	'class' => 'float-alt elgg-button elgg-button-action'
));
$title .= elgg_echo('wizards:admin:list');

echo elgg_view_module('inline', $title, $list);