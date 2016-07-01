<?php

elgg_admin_gatekeeper();

$title = elgg_echo('wizard:add:title');

$form = elgg_view_form('wizard/edit');

if (elgg_is_xhr()) {
	echo elgg_view_module('inline', $title, $form);
} else {
	$page_data = elgg_view_layout('content', [
		'title' => $title,
		'content' => $form,
		'filter' => '',
	]);
	
	echo elgg_view_page($title, $page_data);
}
