<?php

/**
 * Custom class for Wizard
 */
class Wizard extends \ElggObject {
	
	const SUBTYPE = 'wizard';
	
	/**
	 * {@inheritDoc}
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
	 */
	public function __clone() {
		parent::__clone();
		
		$this->title = elgg_echo('wizard:copy:of', [$this->getDisplayName()]);
		$this->friendly_title = elgg_get_friendly_title($this->getDisplayName());
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getURL(): string {
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
	 * Get the steps
	 *
	 * @param bool $count get the count of the steps
	 *
	 * @return false|WizardStep[]|int
	 */
	public function getSteps(bool $count = false) {
		return elgg_get_entities([
			'type' => 'object',
			'subtype' => WizardStep::SUBTYPE,
			'limit' => false,
			'container_guid' => $this->guid,
			'sort_by' => [
				'property' => 'order',
				'direction' => 'ASC',
				'signed' => true,
			],
			'count' => $count,
		]);
	}
}
