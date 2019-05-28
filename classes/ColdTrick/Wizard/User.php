<?php

namespace ColdTrick\Wizard;

class User {
	
	/**
	 * Listen to login event
	 *
	 * @param \Elgg\Event $event 'login:before', 'user'
	 *
	 * @return void
	 */
	public static function login(\Elgg\Event $event) {
		
		$user = $event->getObject();
		if (!$user instanceof \ElggUser || !empty($user->last_login)) {
			return;
		}
		
		// set flag to check for first login wizards
		$user->setPrivateSetting('wizard_check_first_login_wizards', true);
	}
}
