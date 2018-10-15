<?php

$success_count = 0;
$error_count = 0;
$dbprefix = elgg_get_config('dbprefix');

$offset = (int) get_input('offset', 0);
$upgrade_complete = (bool) get_input('upgrade_completed', false);

// prepare options
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
	
	// needs to be migrated
	if ($entity->migrateJsonSteps()) {
		$success_count++;
	} else {
		$error_count++;
	}
}

// are we done?
if ((($success_count + $error_count) === 0) || $upgrade_complete) {
	$path = 'admin/upgrades/migrate_wizard_steps';
	
	$factory = new ElggUpgrade();
	
	$upgrade = $factory->getUpgradeFromPath($path);
	if ($upgrade instanceof ElggUpgrade) {
		$upgrade->setCompleted();
	}
}

// Give some feedback for the UI
echo json_encode([
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
]);
