<?php

/**
 * Wizard step entity class
 */
class WizardStep extends \ElggObject {
	
	const SUBTYPE = 'wizard_step';
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
		
		$this->order = time();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName(): string {
		$title = parent::getDisplayName();
		if (!empty($title)) {
			return $title;
		}
		
		return elgg_echo('untitled');
	}
}
