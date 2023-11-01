<?php

namespace ColdTrick\Wizard;

use Elgg\Database\Seeds\Seed;
use Elgg\Exceptions\Seeding\MaxAttemptsException;
use Elgg\Values;

/**
 * Database seeder for wizards (including steps)
 */
class Seeder extends Seed {
	
	protected array $display_modes = [
		'full_screen',
		'overlay',
	];
	
	/**
	 * {@inheritDoc}
	 */
	public function seed() {
		$this->advance($this->getCount());
		
		$site = elgg_get_site_entity();
		
		while ($this->getCount() < $this->limit) {
			try {
				/* @var $entity \Wizard */
				$entity = $this->createObject([
					'subtype' => \Wizard::SUBTYPE,
					'owner_guid' => $site->guid,
					'container_guid' => $site->guid,
					'access_id' => ACCESS_LOGGED_IN,
					'display_mode' => $this->getRandomDisplayMode(),
					'show_users' => 'everybody',
					'user_can_close' => (int) $this->faker()->boolean(),
				]);
			} catch (MaxAttemptsException $e) {
				// unable to create entity with given options
				continue;
			}
			
			unset($entity->description);
			unset($entity->tags);
			
			$entity->friendly_title = elgg_get_friendly_title($entity->title);
			$this->addStartEndTime($entity);
			$this->setAccountLimitations($entity);
			$this->addSteps($entity);
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \Wizard::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \Wizard */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted wizard {$entity->guid}");
			} else {
				$this->log("Failed to delete wizard {$entity->guid}");
				$entities->reportFailure();
				continue;
			}
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public static function getType(): string {
		return \Wizard::SUBTYPE;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public static function getDefaultLimit(): int {
		return 5;
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \Wizard::SUBTYPE,
		];
	}
	
	/**
	 * Get a random display mode for the wizard
	 *
	 * @return string
	 */
	protected function getRandomDisplayMode(): string {
		$key = array_rand($this->display_modes);
		
		return $this->display_modes[$key];
	}
	
	/**
	 * Set a random start/end time for the wizard
	 *
	 * @param \Wizard $entity wizard
	 *
	 * @return void
	 */
	protected function addStartEndTime(\Wizard $entity): void {
		if (!$this->faker()->boolean(75)) {
			return;
		}
		
		$since = $this->create_since;
		$until = $this->create_until;
		
		$this->setCreateSince($entity->time_created);
		
		if ($since === $until) {
			// probably no option given, so both are 'now'
			$week = Values::normalizeTime($until);
			$week->modify('+1 week');
			
			$this->setCreateUntil($week->getTimestamp());
		}
		
		$start = Values::normalizeTime($this->getRandomCreationTimestamp());
		$start->modify('midnight');
		
		$this->setCreateSince($start->getTimestamp());
		
		$end = Values::normalizeTime($this->getRandomCreationTimestamp());
		$end->modify('midnight');
		
		$deadloop = 0;
		while ($end->getTimestamp() <= $start->getTimestamp() && $deadloop < 10) {
			$deadloop++;
			
			$end = Values::normalizeTime($this->getRandomCreationTimestamp());
			$end->modify('midnight');
		}
		
		$this->setCreateSince($since);
		$this->setCreateUntil($until);
		
		if ($deadloop >= 10) {
			// unable to create correct start/end time
			return;
		}
		
		$entity->starttime = $start->getTimestamp();
		$entity->endtime = $end->getTimestamp();
	}
	
	/**
	 * Set account limitations on the wizard
	 *
	 * @param \Wizard $entity wizard
	 *
	 * @return void
	 */
	protected function setAccountLimitations(\Wizard $entity): void {
		if (!$this->faker()->boolean(75)) {
			return;
		}
		
		switch ($this->faker()->numberBetween(1, 5)) {
			case 1:
				// show users
				$entity->show_users = 'new_users';
				
				break;
			case 2:
				// number of days after account creation
				$entity->days_after_account_creation = $this->faker()->numberBetween(1, 30);
				
				break;
			case 3:
				// min number of days after first login
				$entity->days_after_first_login = $this->faker()->numberBetween(1, 30);
				
				break;
			case 4:
				// max number of days since account creation
				$entity->days_since_account_creation = $this->faker()->numberBetween(1, 30);
				
				break;
			case 5:
				// accounts created after date
				$since = $this->create_since;
				$this->setCreateSince($entity->time_created);
				
				$date = Values::normalizeTime($this->getRandomCreationTimestamp());
				$date->modify('midnight');
				
				$entity->account_created_after = $date->getTimestamp();
				
				$this->setCreateSince($since);
				
				break;
		}
	}
	
	/**
	 * Add steps to the wizard
	 *
	 * @param \Wizard $entity wizard
	 *
	 * @return void
	 */
	protected function addSteps(\Wizard $entity): void {
		for ($i = 0; $i < $this->faker()->numberBetween(0, 3); $i++) {
			try {
				/* @var $step \WizardStep */
				$step = $this->createObject([
					'subtype' => \WizardStep::SUBTYPE,
					'owner_guid' => $entity->owner_guid,
					'container_guid' => $entity->guid,
					'access_id' => ACCESS_LOGGED_IN,
					'order' => $i + 1,
				]);
			} catch (MaxAttemptsException $e) {
				// unable to create step with the given options
				continue;
			}
			
			unset($step->tags);
		}
	}
}
