<?php

namespace ColdTrick\Wizard\Upgrades;

use Elgg\Upgrade\Result;

class MigrateFirstLogin extends \Elgg\Upgrade\AsynchronousUpgrade {
	
	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2023030701;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		/* @var $batch \ElggBatch */
		$batch = elgg_get_entities($this->getOptions([
			'offset' => $offset,
		]));
		/* @var $user \ElggUser */
		foreach ($batch as $user) {
			// set in the new location
			$user->setPluginSetting('wizard', 'check_first_login_wizards', true);
			
			// remove old value
			unset($user->wizard_check_first_login_wizards);
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get selection options for this upgrade
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 * @see elgg_get_entities()
	 */
	protected function getOptions(array $options = []): array {
		$defaults = [
			'type' => 'user',
			'limit'  => 100,
			'batch' => true,
			'batch_inc_offset' => $this->needsIncrementOffset(),
			'metadata_name_value_pairs' => [
				[
					'name' => 'last_login',
					'value' => 0,
					'operand' => '>',
				],
				[
					'name' => 'wizard_check_first_login_wizards',
					'value' => true,
				],
			],
		];
		
		return array_merge($defaults, $options);
	}
}
