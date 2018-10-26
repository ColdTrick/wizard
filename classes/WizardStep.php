<?php

class WizardStep extends ElggObject {
	
	const SUBTYPE = 'wizard_step';
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::initializeAttributes()
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
		
		$this->order = time();
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::getDisplayName()
	 */
	public function getDisplayName() {
		
		if (empty($this->title)) {
			return elgg_echo('untitled');
		}
		
		return $this->title;
	}
}
