<?php

/**
 * Custom class for Wizard
 *
 * @property string $friendly_title              friendly title to use in the wizard URL
 * @property int    $starttime                   start date to show the wizard
 * @property int    $endtime                     last date to show the wizard
 * @property string $display_mode                how to show the wizard (overlay|full_screen)
 * @property string $show_users                  who to show the wizard to (everybody|new_users)
 * @property int    $user_can_close              user can close the wizard without completing (1|0)
 * @property string $forward_url                 once the wizard is completed forward to this URL
 * @property int    $days_after_account_creation number of days after account created to show the wizard
 * @property int    $days_after_first_login      number of days after the first login to show the wizard
 * @property int    $days_since_account_creation maximum number of days after account creation to still show the wizard
 * @property int    $account_created_after       only show the wizard if the account was created after this date
 */
class Wizard extends \ElggObject {
	
	const SUBTYPE = 'wizard';
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
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
