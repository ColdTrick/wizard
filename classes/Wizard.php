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
	 * Save the wiard steps to disk (because of DB limits)
	 *
	 * @param string[] $steps the wizard steps
	 *
	 * @return void
	 */
	public function saveSteps($steps) {
		
		if (!is_array($steps)) {
			$steps = array($steps);
		}
		
		$fh = new ElggFile();
		$fh->owner_guid = $this->getGUID();
		
		$fh->setFilename('steps.json');
		
		$fh->open('write');
		$fh->write(json_encode($steps));
		$fh->close();
	}
	
	/**
	 * Get the steps from disk
	 *
	 * @param bool $count get the count of the steps
	 *
	 * @return false|string[]|int
	 */
	public function getSteps($count = false) {
		
		$count = (bool) $count;
		
		$fh = new ElggFile();
		$fh->owner_guid = $this->getGUID();
		
		$fh->setFilename('steps.json');
		if (!$fh->exists()) {
			return false;
		}
		
		$steps = $fh->grabFile();
		
		unset($fh);
		
		$steps = @json_decode($steps, true);
		if ($count) {
			return count($steps);
		}
		
		// reset indexing on steps
		$steps = array_values($steps);
		
		return $steps;
	}
}
