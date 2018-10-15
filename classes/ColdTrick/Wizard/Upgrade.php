<?php

namespace ColdTrick\Wizard;

class Upgrade {
	
	/**
	 * Listen to upgrade event
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function migrateSteps($event, $type, $object) {
		
		$path = 'admin/upgrades/migrate_wizard_steps';
		$upgrade = new \ElggUpgrade();
		
		// ignore acces while checking for existence
		$ia = elgg_set_ignore_access(true);
		
		// already registered?
		if ($upgrade->getUpgradeFromPath($path)) {
			// restore access
			elgg_set_ignore_access($ia);
			return;
		}
		
		// find if upgrade is needed
		$upgrade_needed = false;
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
			
			$upgrade_needed = true;
			break;
		}
		
		if (!$upgrade_needed) {
			// restore access
			elgg_set_ignore_access($ia);
			return;
		}
		
		$upgrade->title = elgg_echo('admin:upgrades:migrate_wizard_steps');
		$upgrade->description = elgg_echo('admin:upgrades:migrate_wizard_steps:description');
		
		$upgrade->setPath($path);
		
		$upgrade->save();
		
		// restore access
		elgg_set_ignore_access($ia);
	}
}
