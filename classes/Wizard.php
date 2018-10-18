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
	 * {@inheritDoc}
	 * @see ElggEntity::initializeAttributes()
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
	}

	/**
	 * {@inheritDoc}
	 * @see ElggEntity::__clone()
	 */
	public function __clone() {
		parent::__clone();
		
		$this->title = elgg_echo('wizard:copy:of', [$this->getDisplayName()]);
		$this->friendly_title = elgg_get_friendly_title($this->getDisplayName());
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		$friendly_title = $this->friendly_title;
		if (!empty($friendly_title)) {
			return elgg_generate_url('default:object:wizard', [
				'title' => $friendly_title,
			]);
		}
		
		// something went wrong, use fallback url
		return elgg_generate_entity_url($this);
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggObject::canComment()
	 */
	public function canComment($user_guid = 0, $default = null) {
		
		if (!isset($default)) {
			$default = false;
		}
		
		return parent::canComment($user_guid, $default);
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
			'container_guid' => $this->guid,
			'order_by_metadata' => [
				'name' => 'order',
				'as' => 'integer',
				'direction' => 'ASC',
			],
			'count' => $count,
		];
		
		return elgg_get_entities($options);
	}
}
