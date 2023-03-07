<?php

$title = elgg_echo('wizard:add:title');

$form = elgg_view_form('wizard/edit', ['sticky_enabled' => true]);

if (elgg_is_xhr()) {
	// ajax loaded
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, ['content' => $form]);
