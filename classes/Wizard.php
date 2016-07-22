<?php

/**
 * Custom class for Wizard
 *
 * @author ColdTrick
 * @package wizard
 */
class Wizard extends ElggObject {
	
	const SUBTYPE = 'wizard';
	
	/**
	 * Initialize the Wizard object
	 *
	 * @see ElggObject::initializeAttributes()
	 *
	 * @return void
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->getGUID();
		$this->attributes['container_guid'] = $site->getGUID();
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
	}

	/**
	 * Initialize the Wizard object
	 *
	 * @see ElggObject::initializeAttributes()
	 *
	 * @return void
	 */
	public function __clone() {
		parent::__clone();
		
		$this->title = elgg_echo('wizard:copy:of', [$this->title]);
		$this->friendly_title = elgg_get_friendly_title($this->title);
	}
	
	/**
	 * Get url
	 *
	 * @see ElggEntity::getURL()
	 * @return string
	 */
	public function getURL() {
		$friendly_title = $this->friendly_title;
		if (!empty($friendly_title)) {
			return elgg_normalize_url("wizard/{$this->friendly_title}");
		}
		
		// something went wrong, use fallback url
		$friendly_title = elgg_get_friendly_title($this->title);
		return elgg_normalize_url("wizard/view/{$this->getGUID()}/{$friendly_title}");
	}
	
	/**
	 * Get the steps
	 *
	 * @param bool $count get the count of the steps
	 *
	 * @return false|WizardStep[]|int
	 */
	public function getSteps($count = false) {
		
		$count = (bool) $count;
		
		$options = [
			'type' => 'object',
			'subtype' => WizardStep::SUBTYPE,
			'limit' => false,
			'container_guid' => $this->getGUID(),
			'order_by_metadata' => [
				'name' => 'order',
				'as' => 'integer',
				'direction' => 'ASC',
			],
		];
		
		if ($count) {
			$options['count'] = true;
		}
		
		return elgg_get_entities_from_metadata($options);
	}
	
	public function migrateJsonSteps() {
		
		$fh = new \ElggFile();
		$fh->owner_guid = $this->getGUID();
		
		$fh->setFilename('steps.json');
		if (!$fh->exists()) {
			return false;
		}
		
		$steps = $fh->grabFile();
		$steps = @json_decode($steps, true);
		
		foreach ($steps as $step) {
			
			$new_step = new WizardStep();
			$new_step->container_guid = $this->getGUID();
			
			$new_step->description = $step;
			
			$new_step->save();
		}
		
		$fh->delete();
		
		return true;
	}
}
