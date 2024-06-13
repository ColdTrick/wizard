<?php

/**
 * Wizard step entity class
 *
 * @property int $order the order of the step in the wizard
 */
class WizardStep extends \ElggObject {
	
	const SUBTYPE = 'wizard_step';
	
	/**
	 * {@inheritdoc}
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
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		$title = parent::getDisplayName();
		if (!empty($title)) {
			return $title;
		}
		
		return elgg_echo('untitled');
	}
}
