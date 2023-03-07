<?php

namespace ColdTrick\Wizard\Forms;

use Elgg\Values;

/**
 * Prepare form fields for the wizard/edit form
 */
class PrepareWizardFields {
	
	/**
	 * Prepare fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'wizard/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$result = [
			'title' => '',
			'starttime' => Values::normalizeTimestamp('+1 day'),
			'endtime' => null,
			'display_mode' => 'full_screen',
			'show_users' => 'everybody',
			'user_can_close' => 0,
			'forward_url' => null,
			'days_after_account_creation' => null,
			'days_after_first_login' => null,
			'days_since_account_creation' => null,
			'account_created_after' => null,
		];
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \Wizard) {
			foreach ($result as $key => $value) {
				$result[$key] = $entity->$key;
			}
		}
		
		return array_merge($result, $vars);
	}
}
