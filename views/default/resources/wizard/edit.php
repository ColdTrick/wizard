<?php

use ColdTrick\Wizard\EditWizard;
use Elgg\EntityPermissionsException;

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', Wizard::SUBTYPE);

/* @var $entity Wizard */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new EntityPermissionsException();
}

$title = elgg_echo('wizard:edit:title', [$entity->getDisplayName()]);

$form_helper = new EditWizard($entity);

$form = elgg_view_form('wizard/edit', [], $form_helper());

if (elgg_is_xhr()) {
	// ajax loaded
	echo elgg_view_module('info', $title, $form);
	return;
}

echo elgg_view_page($title, ['content' => $form]);
