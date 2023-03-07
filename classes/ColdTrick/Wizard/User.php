<?php

namespace ColdTrick\Wizard;

/**
 * User related events
 */
class User {
	
	/**
	 * Listen to the first login event
	 *
	 * @param \Elgg\Event $event 'login:first', 'user'
	 *
	 * @return void
	 */
	public static function firstLogin(\Elgg\Event $event): void {
		$user = $event->getObject();
		if (!$user instanceof \ElggUser) {
			return;
		}
		
		// set flag to check for first login wizards
		$user->setPluginSetting('wizard', 'check_first_login_wizards', true);
	}
}
