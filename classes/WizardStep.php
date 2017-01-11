<?php

class WizardStep extends ElggObject {
	
	const SUBTYPE = 'wizard_step';
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::initializeAttributes()
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->getGUID();
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
		
		$this->order = time();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ElggObject::getDisplayName()
	 */
	public function getDisplayName() {
		
		if (empty($this->title)) {
			return elgg_echo('untitled');
		}
		
		return $this->title;
	}
}
