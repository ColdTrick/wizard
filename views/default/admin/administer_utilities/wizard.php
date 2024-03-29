<?php

elgg_register_menu_item('title', [
	'name' => 'add',
	'icon' => 'plus',
	'text' => elgg_echo('add'),
	'href' => elgg_generate_url('add:object:wizard'),
	'link_class' => [
		'elgg-button',
		'elgg-button-action',
		'elgg-lightbox',
	],
	'data-colorbox-opts' => json_encode([
		'width' => '800px;',
	]),
]);

// check if there are users who need repairing
$count = elgg_count_entities([
	'type' => 'user',
	'metadata_name_value_pairs' => [
		[
			'name' => 'last_login',
			'value' => 0,
			'operand' => '>',
		],
		[
			'name' => 'plugin:user_setting:wizard:check_first_login_wizards',
			'value' => true,
		],
	],
]);
if ($count > 0) {
	elgg_register_menu_item('title', [
		'name' => 'repair_users',
		'icon' => 'tools',
		'text' => elgg_echo('wizard:admin:repair_users'),
		'title' => elgg_echo('wizard:admin:repair_users:title'),
		'badge' => $count,
		'confirm' => true,
		'href' => elgg_generate_action_url('wizard/admin/repair_users'),
		'link_class' => [
			'elgg-button',
			'elgg-button-delete',
		],
	]);
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => \Wizard::SUBTYPE,
	'full_view' => false,
	'sort_by' => [
		'name' => 'starttime',
		'direction' => 'ASC',
		'signed' => true,
	],
	'no_results' => true,
]);
