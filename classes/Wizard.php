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
		$this->attributes['owner_guid'] = $site->getGUID();
		$this->attributes['container_guid'] = $site->getGUID();
		$this->attributes['access_id'] = ACCESS_LOGGED_IN;
	}

	/**
	 * {@inheritDoc}
	 * @see ElggEntity::__clone()
	 */
	public function __clone() {
		parent::__clone();
		
		$this->title = elgg_echo('wizard:copy:of', [$this->title]);
		$this->friendly_title = elgg_get_friendly_title($this->title);
	}
	
	/**
	 * {@inheritDoc}
	 * @see ElggEntity::getURL()
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
	 * {@inheritDoc}
	 * @see ElggEntity::canDelete()
	 */
	public function canDelete($user_guid = 0) {
		return elgg_is_admin_user($user_guid);
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
}
