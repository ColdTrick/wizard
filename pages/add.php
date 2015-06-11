<?php

admin_gatekeeper();

$title = elgg_echo('wizard:add:title');

$form = elgg_view_form('wizard/edit');

if (elgg_is_xhr()) {
	// lightbox
	echo elgg_view_module('inline', $title, $form, array('class' => 'wizard-lightbox-wrapper'));
} else {
	// full page
	$page_data = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $form,
		'filter' => ''
	));
	
	echo elgg_view_page($title, $page_data);
}