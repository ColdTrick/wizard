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

echo elgg_view_page($title, ['content' => $form]);
