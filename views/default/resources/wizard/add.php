<?php

use ColdTrick\Wizard\EditWizard;

$title = elgg_echo('wizard:add:title');

$form_helper = new EditWizard();

$form = elgg_view_form('wizard/edit', [], $form_helper());

if (elgg_is_xhr()) {
	// ajax loaded
	echo elgg_view_module('info', $title, $form);
	return;
}

$page_data = elgg_view_layout('content', [
	'title' => $title,
	'content' => $form,
	'filter' => false,
]);

echo elgg_view_page($title, $page_data);
