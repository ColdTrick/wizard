<?php

// add description
echo elgg_view('output/longtext', [
	'value' => elgg_echo('admin:upgrades:migrate_wizard_steps:description'),
]);

// how much content to upgrade
$count = 0;
$batch = new \ElggBatch('elgg_get_entities', [
	'type' => 'object',
	'subtype' => \Wizard::SUBTYPE,
	'limit' => false,
]);
foreach ($batch as $entity) {
	$fa = new \ElggFile();
	$fa->owner_guid = $entity->getGUID();
	
	$fa->setFilename('steps.json');
	if (!$fa->exists()) {
		continue;
	}
	
	$count++;
}

// show upgrade progress + start button
echo elgg_view('admin/upgrades/view', [
	'count' => $count,
	'action' => 'action/wizard/upgrades/migrate_wizard_steps',
]);
